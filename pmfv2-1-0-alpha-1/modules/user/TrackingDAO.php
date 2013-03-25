<?php

class TrackingDAO extends MyFamilyDAO {

       function updateEmail($newemail) {
                global $tblprefix, $pdo;

		$id = $this->getId();
                $stmt = $pdo->prepare("UPDATE ".$tblprefix."users SET email = ? WHERE id = ?");
                $stmt->bindParam(1, $newemail, PDO::PARAM_STR);
                $stmt->bindParam(2, $id, PDO::PARAM_STR);
                $stmt->execute();

//Tracking is allowed by unregistered users hence this
	 	$stmt = $pdo->prepare("UPDATE ".$tblprefix."tracking SET email = ? WHERE email = ?");
                $stmt->bindParam(1, $newemail, PDO::PARAM_STR);
                $stmt->bindParam(2, $_SESSION["email"], PDO::PARAM_STR);
                $stmt->execute();

		$_SESSION["email"] = $newemail;
        }

        // function: delete_expired
        // deletes timedout requests from database
        function delete_expired() {
                global $tblprefix, $pdo;

                // clear out subscription requests
                $dquery = "DELETE FROM ".$tblprefix."tracking WHERE expires < NOW() and expires IS NOT NULL AND `action` = 'sub'";
		if ($pdo->exec($dquery) === FALSE) {
			die(print_r($pdo->errorInfo(), true));
		}

                // clear out unsubscribe requests
                $dquery = "UPDATE ".$tblprefix."tracking SET `key` = '', `expires` = NULL WHERE expires < NOW() and expires IS NOT NULL AND `action` = 'unsub'";
		if ($pdo->exec($dquery) === FALSE) {
			die(print_r($pdo->errorInfo(), true));
		}

        }       // end of delete_expired()

	function trackByRegistered($person, $email) {
		global $tblprefix, $pdo;
   		$query = "INSERT INTO ".$tblprefix."tracking (person_id, email) VALUES (".$pdo->quote($person).", ".$pdo->quote($email).")";
		if ($pdo->exec($query) === FALSE) {
			die(print_r($pdo->errorInfo(), true));
		}


	}
	function untrackByRegistered($person, $email) {
		global $tblprefix, $pdo;
		$query = "DELETE FROM ".$tblprefix."tracking WHERE person_id = ".$pdo->quote($person)." AND email = ".$pdo->quote($email);
		if ($pdo->exec($query) === FALSE) {
			die(print_r($pdo->errorInfo(), true));
		}

	}
	function trackByUnregistered($person, $name, $newkey, $email) {
		global $tblprefix, $pdo, $eSubBody, $eSubSubject;
	                       // insert into database
        	$iquery = "INSERT INTO ".$tblprefix."tracking (person_id, email, `key`, `action`, expires) VALUES ('".$person."', '".$email."', '".$newkey."', 'sub', DATE_ADD(NOW(), INTERVAL 24 HOUR))";
                $iresult = mysql_query($iquery);

                // if we get this error then already tracking
                if (mysql_errno() == 1062) {
                    $ret = 1; 
                } else {
			$this->mailSubscriber($eSubBody, $name, $newkey, $eSubSubject, $email);
                    $ret = 0; 
		}
		return ($ret);
	}
	function untrackByUnregistered($person, $name, $newkey, $email) {
		global $tblprefix, $pdo, $eSubSubject, $eUnSubBody;
		$ret = 1;
        	$uquery = "UPDATE ".$tblprefix."tracking SET `key` = '".$newkey."', `expires` = DATE_ADD(NOW(), INTERVAL 24 HOUR), `action` = 'unsub' WHERE person_id = '".$person."' AND email = '".$email."'";
		if (($numrows = $pdo->exec($uquery)) === FALSE) {
			die(print_r($pdo->errorInfo(), true));
		}
		if ($numrows != 0) {
			$this->mailSubscriber($eUnSubBody, $name, $newkey, $eSubSubject, $email);
			$ret = 0;
		}

		return ($ret);

	}

	function isTracked($email, $person) {
		global $tblprefix, $pdo;
		$query = "SELECT * FROM ".$tblprefix."tracking WHERE email = ".$pdo->quote($email)." AND person_id = ".$pdo->quote($person);
		if (($result = $pdo->query($query)) == FALSE) {
			die(print_r($pdo->errorInfo(), true));
		}

                if ($result->rowCount() == 0) {
			$ret = false;
		} else {
			$ret = true;
		}
		return ($ret);
	}
	function processTrackingAction($key, $action) {
		global $tblprefix, $pdo;
		$ret = 0;
               // find out what we're supposed to do
                $kquery = "SELECT * FROM ".$tblprefix."tracking WHERE `key` = ".$pdo->quote($key);
		foreach ($pdo->query($kquery) as $krow) {
                        $action = $krow["action"];
                }


                // sub or un?
                if ($action == "sub") {
                        // check we have key and action it
                        $pquery = "UPDATE ".$tblprefix."tracking SET `key` = '', expires = NULL WHERE `key` = ".$pdo->quote($key);
			if (($numrows = $pdo->exec($pquery)) === FALSE) {
				die(print_r($pdo->errorInfo(), true));
			}
                        if ($numrows != 0) {
                                // You are now monitoring this person
                                $ret = 1;
                        } else {
                                // Theres been a problem
                                $ret = -1;
                        }
                } elseif ($action == "unsub") {
                        $uquery = "DELETE FROM ".$tblprefix."tracking WHERE `key` = ".$pdo->quote($key)." AND `action` = 'unsub'";
			if (($numrows = $pdo->exec($uquery)) === FALSE) {
				die(print_r($pdo->errorInfo(), true));
			}
                        if ($numrows != 0) {
                                // You are now not monitoring this person
                                $ret = 2;
                        } else {
                                // Theres been a problem
                                $ret = -1;
                        }
                } else {
			$ret = -1;
		}
		return ($ret);
	}

       function trackPerson($person) {
                global $tblprefix;
                global $err_person;
                global $eTrackSubject;
                global $eTrackBodyTop;
                global $eTrackBodyBottom;
                global $currentRequest;
		global $pdo;

                $config = Config::getInstance();

                $tquery = "SELECT ".$tblprefix."people.person_id, email FROM ".$tblprefix."people, ".$tblprefix."tracking WHERE ".
                $tblprefix."people.person_id = ".$tblprefix."tracking.person_id AND ".$tblprefix."people.person_id = ?".
                " AND `key` = '' AND expires IS NULL";

                $stmt = $pdo->prepare($tquery);
                $stmt->bindParam(1, $person->person_id, PDO::PARAM_INT);
                if ($stmt->execute() === FALSE) {
                	die($err_person);
		}
                while ($trow = $stmt->fetch(PDO::FETCH_ASSOC)) {

                       $subject=str_replace("$1", $person->getDisplayName(), $eTrackSubject);
                       $body = str_replace("$1", $person->getDisplayName(), $eTrackBodyTop);
                       $body = str_replace("$2", $config->absurl, $body);
                       $body = str_replace("$3", $currentRequest->name, $body);
                       $body .= $config->absurl."people.php?person=".$person->person_id."\n\n";
                       $body .= $eTrackBodyBottom;
                       $body .= $config->absurl."track.php?person=".$person->person_id."&action=unsub&email=".$trow["email"]."&name=".urlencode($person->name->getDisplayName())."\n";

			$this->mailSubscriber($body, $person->getDisplayName(), '', $subject, $trow["email"]);
                }
                $stmt->closeCursor();
        }       // eod of track_person()

        // function: bb_person($person)
        // send a big brother email on all changes
        function bbPerson($person, $action = "updated") {
                global $tblprefix;
                global $err_person;
                global $eBBSubject;
                global $eTrackBodyTop;
                global $eBBBottom;
                global $currentRequest;

                $config = Config::getInstance();

                // Give a subject line
                $subject = str_replace("$1", $person->getDisplayName(), $eBBSubject);

                // Flesh out the body
                $body = str_replace("$1", $person->getDisplayName(), $eTrackBodyTop);
                $body = str_replace("$2", $config->absurl, $body);
                $body = str_replace("$3", $currentRequest->name, $body);
                $body .= $config->absurl."people.php?person=".$person->person_id."\n\n";
                $body .= $eBBBottom;

                // Fire of the Big Brother email
		$this->mailSubscriber($body, $person->getDisplayName(), '', $subject, $config->email);
        }       // end of bb_person()

        // function: stamppeeps
        // timestamp a particular person for last updated
        function stamppeeps($person) {
                // declare globals used within
                global $tblprefix, $currentRequest, $pdo;
                $config = Config::getInstance();


                // update the updated column
                $query = "UPDATE ".$tblprefix."people SET updated = NOW(), editor_id=".$currentRequest->id." WHERE person_id = '".$person->person_id."'";
                $result = $pdo->exec($query);

                // If we allow tracking by email
                if ($config->tracking)
                        $this->trackPerson($person);

                // If Big Brother is watching
                if ($config->bbtracking)
                        $this->bbPerson($person);

        }       // end of stamppeeps()


	function mailSubscriber($body, $name, $newkey, $subject, $email) {
		$config = Config::getInstance();

                $body = str_replace("$1", $name, $body);
		if ($newkey != '') {
                	$body .= $config->absurl."track.php?key=".$newkey."\n";
		}

               $email = $config->email;
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                // SMTP username
                $mail->Host = $config->smtp_host;
                $mail->Username = $config->smtp_user;
                $mail->Password = $config->smtp_password;

                $mail->From=$config->trackemail;
                $mail->AddAddress($email,'');
                $mail->Subject=$subject;
                $mail->Body=$body;
                if(!$mail->Send()) {
                        echo "Message could not be sent. <p>";
                        echo "Mailer Error: " . $mail->ErrorInfo;
                        exit;
                }

	}
}
?>
