<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2007  Simon E Booth (simon.booth@giric.com)
	//Contributions (C)2004 Ken Joyce (ken@poweringon.com)

	//This program is free software; you can redistribute it and/or
	//modify it under the terms of the GNU General Public License
	//as published by the Free Software Foundation; either version 2
	//of the License, or (at your option) any later version.

	//This program is distributed in the hope that it will be useful,
	//but WITHOUT ANY WARRANTY; without even the implied warranty of
	//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	//GNU General Public License for more details.

	//You should have received a copy of the GNU General Public License
	//along with this program; if not, write to the Free Software
	//Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

	// function: str_rand (aidan@php.net - http://aidan.dotgeek.org/lib/?file=function.str_rand.php)
	// generate a random string
	function str_rand($length = 8, $seeds = 'abcdefghijklmnopqrstuvwxyz0123456789')
	{
		$str = '';
		$seeds_count = strlen($seeds);
 
		// Seed
		list($usec, $sec) = explode(' ', microtime());
		$seed = (float) $sec + ((float) $usec * 100000);
		mt_srand($seed);
 
		// Generate
		for ($i = 0; $length > $i; $i++) {
		    $str .= $seeds{mt_rand(0, $seeds_count - 1)};
		}
 
		return $str;
	}	// end of str_rand()

	// function: liststyles
	// list styles to choose
	// "Ken Joyce"
	function liststyles($form, $style) {

		$config = Config::getInstance();
		
		if ($handle = opendir($config->styledir)) {
			echo "<select name=\"$form\">\n";
			while (false !== ($file = readdir($handle)) ) {
				if ( strrpos($file, "css.php")>1) {
					$filebits = explode(".",$file);
					echo "<option value=\"".$filebits[0]."\"" ;
					if ($style == $file ) echo " selected=\"selected\"";
					echo ">".$filebits[0]."</option>\n";
				}
			}
		echo "</select>\n";
		closedir($handle);
		}
	} // end of liststyles()

	function listlangs($form, $lang) {
		$ret = "";
		if ($handle = opendir('lang')) {
			$ret .= "<select name=\"$form\">\n";
			while (false !== ($file = readdir($handle)) ) {
				if ( strrpos($file, "inc.php")>1) {
					$filebits = explode(".",$file);
					$ret .= "<option value=\"".$filebits[0]."\"" ;
					if ($lang == $filebits[0] ) $ret .= " selected=\"selected\"";
					$ret .= ">".$filebits[0]."</option>\n";
				}
			}
		$ret .= "</select>\n";
		closedir($handle);
		}
		return ($ret);
	} // end of listslangs()
	
	// function: send password
	// sends a new password to a user who has forgotten
	function send_password($email) {
		global $tblprefix;
		global $ePwdSubject, $ePwdBody;
		
		$config = Config::getInstance();

		// generate a new password
		$password = str_rand();

		$dao = getUsersDAO();
		if($dao->resetPassword() != 0) {
			return (0);
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
		$mail->Subject=$ePwdSubject;
		$mail->Body=str_replace("$1", $username."/".$password, $ePwdBody);;
		if(!$mail->Send()) {
			echo "Message could not be sent. <p>";
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit;
		}
	}	// end of send_password()

if ( false === function_exists('lcfirst') ):
    function lcfirst( $str )
    { return (string)(strtolower(substr($str,0,1)).substr($str,1));}
endif; 
	// function: fmod
	// return the modulus of two numbers
//	function fmod($x, $y) {
//		$d = floor($x / $y);
//		return $x - $d * $y;
//	}	// end of fmod()

	// eof
?>
