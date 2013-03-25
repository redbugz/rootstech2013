<?php

class UserDAO extends MyFamilyDAO {

	function getId() {
		return ($_SESSION["id"]);
	}

	function updatePasswordById($id, $newpass) {
		global $tblprefix, $pdo;

                $stmt = $pdo->prepare("UPDATE ".$tblprefix."users SET password = ? WHERE id = ?");
                $stmt->bindParam(1, md5($newpass), PDO::PARAM_STR);
                $stmt->bindParam(2, $id, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() != 1) {
			return false;
		} else {
			return true;
		}
	}

	function updatePassword($newpass) {
		$id = $this->getId();
		return($this->updatePasswordById($id, $newpass));
	}
	function resetPassword($email, $newpass) {
		global $tblprefix, $pdo;
                // check we have a valid email address
                // just drop out if we don't
                $stmt = $pdo->prepare("SELECT id FROM ".$tblprefix."users WHERE email = ?");
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
		$stmt->execute();
		$i = 0;
		foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $row) {
                        $id = $row["id"];
			$i++;
                }
		$stmt->closeCursor();
		if ($i != 0) {
			return (-1);
		}

                // generate a new password
                $password = str_rand();

                // update the table
                // just drop out if it doesn't work out right
		if(!$this->updatePasswordById($id, $password))
                        return -1;

		return (0);
	}

	function addUser($user, $password, $email, $edit, $style) {
                global $tblprefix, $pdo, $err_new_user;
                $ret = 0;
                $stmt = $pdo->prepare("SELECT id FROM ".$tblprefix."users WHERE username = ?");
                $stmt->bindParam(1, $user, PDO::PARAM_STR);
		$stmt->execute();
                if ($stmt->rowCount() == 0) {
                	$stmt = $pdo->prepare("INSERT INTO ".$tblprefix."users (username, password, edit, style, email) VALUES (?, ?, ?, ?, ?)");
                	$stmt->bindParam(1, $user, PDO::PARAM_STR);
                	$stmt->bindParam(2, md5($password), PDO::PARAM_STR);
                	$stmt->bindParam(3, $edit, PDO::PARAM_STR);
                	$stmt->bindParam(4, $style.".css.php", PDO::PARAM_STR);
                	$stmt->bindParam(3, $email, PDO::PARAM_STR);
                	$stmt->execute() or die($err_new_user);
                } else {
                        $ret = 1;
		}
		return $ret;

	}
       function updateStyle($newstyle) {
                global $tblprefix, $pdo;

		$id = $this->getId();
                $stmt = $pdo->prepare("UPDATE ".$tblprefix."users SET style = ? WHERE id = ?");
                $stmt->bindParam(1, $newstyle, PDO::PARAM_STR);
                $stmt->bindParam(2, $id, PDO::PARAM_STR);
                $stmt->execute();

		$_SESSION["style"] = $newstyle.".css.php";
        }

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

}
?>
