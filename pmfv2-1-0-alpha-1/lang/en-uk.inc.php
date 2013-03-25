<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2005  Simon E Booth (simon.booth@giric.com)

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

//=====================================================================================================================

//=====================================================================================================================
//  global definitions
//=====================================================================================================================

	$charset			= "ISO-8859-1";
	$clang				= "en";
	$dir				= "ltr";
	$datefmt 			= "'%d/%m/%Y'";
	// flags are from http://flags.sourceforge.net
	// I can't find a copyrigh to credit
	// but I'm sure somebody has it
	$flag				= "images/gb.gif";
        $strPhpMyFamily                 ="PhpMyFamily"; // MODIFICA 20120506
        $strMsgDescendants                  ="This module is EXPERIMENTAL - please report bugs and/or requests in the forum."; // MODIFICA 20120506         
//=====================================================================================================================
//=====================================================================================================================
	$currentRequest->setDateFormat($datefmt);

//=====================================================================================================================
// strings for translation
//=====================================================================================================================

	$strPDF = "PDF";
	$strDivorce = "Divorce";
	$strFirstNames = "First Name(s)";
	$strLinkNames = "Last Name prefix";
	$strLastName = "Last Name";
	$strAKA = "Alias";
	$strLocations = "Locations";
	$strTimeline = "Timeline";
	$strCharts = "Charts";
	$strReport = "Report";
	$strMissing = "Missing";
	$strDescendants     = "Decendants";
	$strLivingPerson    = "Living person";
	$strAncestors       = "Ancestors";  
	$strDateDescr[0]    = "";    // Default for old entries without details
	$strDateDescr[1]    = "about"; // dev < 1 year
	$strDateDescr[2]    = "circa"; // dev <5 years
	$strDateDescr[3]    = "estimated"; // dev. < 15 years
	$strDateDescr[4]    = "roughly"; // dev > 15 years
	$strDateDescr[5]    = "calculated"; // Gedcom compatible
	$strDateDescr[6]    = "before"; // Gedcom compatible
	$strDateDescr[7]    = "after"; // Gedcom compatible
	$strDateDescr[8]    = "on"; // exact date
	$strDateDescr[9]    = "in"; // day not known
	$strDateDescr[10]   = "probably"; // source inconclusive
	
	$strDateExplain[0]    = "Default";
	$strDateExplain[1]    = "within 1 year";
	$strDateExplain[2]    = "within 5 years";
	$strDateExplain[3]    = "within 15 years";
	$strDateExplain[4]    = "more than 15 years";
	$strDateExplain[5]    = "calculated"; // Gedcom compatible
	$strDateExplain[6]    = "before"; // Gedcom compatible
	$strDateExplain[7]    = "after"; // Gedcom compatible
	$strDateExplain[8]    = "exact date";
	$strDateExplain[9]    = "day not known";
	$strDateExplain[10]   = "source inconclusive";
	
	$strDate = "Date";
	$strPlace = "Place";
	$strCert = "Certified";
	$strSource = "Source";
	$strReference = "Reference";
	$strURL = "URL";
	
	$strFaB = "Details of father at birth";
	$strSon = "Son";
	$strDaughter = "Daughter";
	$strWith = "with";
	
	$strPlace = "Place";
	$strLatitude = "Latitude";
	$strLongitude = "Longitude";
	$strCentre = "Centre of map";
	
	$strCertainty = array("Unreliable evidence or estimated data", "Questionable reliability of evidence (interviews, census, oral genealogies, or potential for bias for example, an autobiography)", "Secondary evidence, data officially recorded sometime after event", "Direct and primary evidence used, or by dominance of the evidence");

	$strInvalidPerson   = "Invalid person name";
	$strDeceasedPerson  = "Deceased Person";    // EN-UK
  	$strOnFile			= "people on file";
	$strSelect			= "Select person";
	$strUnknown			= "unknown";
	$strLoggedIn		= "You are logged in as ";
	$strAdmin			= "admin";
	$strLoggedOut		= "You are not logged in";
	$strYes				= "Yes";
	$strNo				= "No";
	$strSubmit			= "Submit";
	$strReset			= "Reset";
	$strLogout			= "logout";
	$strHome			= "home";
	$strEdit			= "edit";
	$strAdd				= "add";
	$strDetails			= "Details";
	$strBorn			= "Born";
	$strBornAbbrev		= "b.";
	$strCertified		= "Certified";
	$strFather			= "Father";
	$strRestricted		= "<a href=\"restricted.php\">Restricted</a>";
	$strDied			= "Died";
	$strMother			= "Mother";
	$strChildren		= "Children";
	$strSiblings		= "Siblings";
	$strMarried			= "Married";
	$strUnmarried			= "unmarried";
	$strWidowed			= "widowed";
	$strInsert			= "insert";
	$strNewMarriage		= "new marriage";
	$strNotes			= "Notes";
	$strGallery			= "Image Gallery";
	$strUpload			= "upload";
	$strNewImage		= "new image";
	$strNoImages		= "No images available";
	$strCensusDetails	= "Census Details";
	$strNewCensus		= "new census";
	$strNoInfo			= "No information available";
	$strYear			= "Year";
	$strAddress			= "Address";
	$strCondition		= "Condition";
	$strOf				= "of";
	$strAnd				= "and";
	$strAge				= "Age";
	$strProfession		= "Profession";
	$strBirthPlace		= "Place of Birth";
	$strDocTrans		= "Document Transcripts";
	$strNewTrans		= "new transcript";
	$strTitle			= "Title";
	$strDesc			= "Description";
	$strDate			= "Date";
	$strRightClick		= "Click the document title to download. (Might need to right click &amp; Save Target As.. in Internet Explorer)";
	$strStats			= "Site Statistics";
	$strArea			= "Area";
	$strNumber			= "Number";
	$strCensusRecs		= "Census records";
	$strImages			= "Images";
	$strLast20			= "Last 20 People Updated";
	$strPerson			= "Person";
	$strUpdated			= "Updated";
	$strEditing			= "Editing";
	$strName			= "Name";
	$strDOB				= "Date of Birth";
	$strDateFmt			= "Please use format YYYY-MM-DD";
	$strDOD				= "Date of Death";
	$strCauseDeath		= "Cause of Death";
	$strMarriage		= "Marriage";
	$strSpouse			= "Spouse";
	$strCensus			= "Census";
	$strSchedule 		= "Schedule";
	$strDragons			= "Here be dragons!";
	$strGender			= "Gender";
	$strMale			= "Male";
	$strFemale			= "Female";
	$strNewPassword		= "New Password";
	$strOldPassword		= "Old Password";
	$strReOldPassword	= "Re-enter Old Password";
	$strChange			= "Change";
	$strPwdChange		= "Password Change";
	$strPwdChangeMsg	= "Please use this form if you wish to change your password.";
	$strLogin			= "login";
	$strUsername		= "Username";
	$strPassword		= "Password";
	$strRePassword		= "Re-enter Password";
	$strForbidden		= "Forbidden";
	$strForbiddenMsg	= "The page that you have requested has reported that you do not have sufficient rights to view it.  Do not repeat this request.  Please click <a href=\"index.php\">here</a> to continue.";
	$strDelete			= "delete";
	$strFUpload			= "File to Upload";
	$strFTitle			= "File Title";
	$strFDesc			= "File Description";
	$strFDate			= "File Date";
	$strIUpload			= "Image to Upload";
	$strISize			= "JPEG only (max size 1MB)";
	$strITitle			= "Image Title";
	$strIDesc			= "Image Description";
	$strIDate			= "Image Date";
	$strOn				= "on";
	$strAt				= "at";
	$strAdminFuncs		= "Admin Functions";
	$strAction			= "action";
	$strUserCreate		= "Create new user";
	$strCreate			= "Create";
	$strBack			= "Back";
	$strToHome			= "to the homepage.";
	$strNewMsg			= "Please make sure that the person does not already exist in the database before creating!";
	$strIndex			= "All details for people born after $currentRequest->dispdate are restricted to protect their identities.  If you are a registered user you can view these details and edit record.  Everybody is free to browse the unrestricted records.<br /><b>If you think anybody here matches into your family tree, please <a href=\"$1\">let me know</a></b> or send me this "; // MODIFICA 20120508 
	$strScheda                      = "worksheet."; // MODIFICA 20120508 
	$strNote			= "Note";
	$strFooter			= "Email the <a href=\"$1\">webmaster</a> with any problems.";
	$strPowered			= "Powered by";
	$strPedigreeOf		= "Pedigree of";
	$strBirths			= "Births";
	$strAnniversary		= "Anniversary";
    $strYears           = "years"; // MODIFICA 20120506 	
	$strUpcoming		= "Upcoming Anniversaries";
	$strMarriages		= "Marriages";
	$strDeaths			= "Deaths";
	$strConfirmDelete	= "\"Are you sure you wish to delete the\\n'\" + year + \"' \" + section +\"?\"";
	$strTranscript		= "transcript";
	$strImage			= "image";
	$strNewPerson		= "a new person";
	$strPedigree		= "pedigree";
	$strToDetails		= "to details";
	$strSurnameIndex	= "Index of Surnames";
	$strTopSurnames		= "Top 10 Surnames";
        $strFounders            = "Founders";	
	$strTracking		= "Tracking";
	$strTrack			= "track";
	$strThisPerson		= "this person";
	$strTrackSpeel		= "Use the form below to track this person.  You will automatically be sent an email everytime this record is updated";
	$strEmail			= "Email";
	$strSubscribe		= "subscribe";
	$strUnSubscribe		= "unsubscribe";
	$strMonAccept		= "You request for monitoring has been accepted<br />You will now receive an email every time this person is updated.<br />";
	$strMonCease		= "You request to cease monitoring has been accepted<br />You will no longer receive any emails.<br />";
	$strMonError		= "There has been a problem with your monitoring request.<br />Please contact the site administrator for assistance";
	$strMonRequest		= "Your request for monitoring this person is being processed.<br />A confirmation email has been sent to your address and you should follow the instructions therein.<br />";
	$strCeaseRequest	= "Your request for ceasing monitoring this person is being processed.<br />A confirmation email has been sent to your address and you should follow the instructions therein.<br />";
	$strAlreadyMon		= "You already seem to be monitoring this person.<br />No action is required.<br />";
	$strNotMon			= "You do not seem to be monitoring this person.<br />No action is required.<br />";
	$strRandomImage		= "Random Image";
	$strMailTo			= "Send Message";
	$strSubject			= "Subject";
	$strNoEmail			= "\"You must provide an email address\"";
	$strEmailSent		= "Your email has been sent to the webmaster.";
	$strExecute			= "Execution time";
	$strSeconds			= "seconds";
	$strStyle			= "Style";
	$strPreferences		= "preferences";
	$strRecoverPwd		= "recover password";
	$strStop			= "stop";
	$strRememberMe		= "Remember me";
	$strSuffix			= "Suffix";
	$strLost			= "You have lost your password";
	$strSent			= "A New password has been sent";
	$strMyLoggedIn		= "Logged in to phpmyfamily";
	$strAdminUser		= "You are an <a href=\"admin.php\">admin</a> user";
	$strMonitoring		= "People you are monitoring";
	$strChangeStyle		= "Change your style";
	$strChangeEmail		= "Change your email";
	$strGedCom			= "gedcom";
	$strCompleteGedcom	= "Complete gedcom";
	$strCreateFamily	= "Creating new family member";
	$strCreatePerson	= "Create new person";

	$strEvent[0] = "Birth";
	$strEvent[1] = "Baptism";
	$strEvent[2] = "Death";
	$strEvent[3] = "Burial";
	$strEvent[4] = "Banns read";
	$strEvent[5] = "Marriage";
	$strEvent[6] = "Census";
	$strEvent[7] = "Other";
	$strEvent[8] = "Image";
	$strEvent[9] = "Transcript";
	
	$strEventVerb = array($strBorn,"Baptised",$strDied,"Buried",$strEvent[4],$strMarried,"Census","Other", "Image", "Transcript");
//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 has been updated";
	$eTrackBodyTop		= "This is an automated message.  $1 at $2 has been changed by $3.  Click below to see the updated record\n\n";
	$eTrackBodyBottom	= "This message has been sent because you previously signed up for tracking this person.  Click below to remove yourself from this monitoring\n\n";
	$eSubSubject		= "[phpmyfamily] monitoring request";
	$eSubBody			= "This is an automated message.  You have received this message because you have chosen to monitor the record of $1.  To confirm this subscription, please click the link below within the next 24 hours.\n\n";
	$eUnSubBody			= "This is an automated message.  You have received this message because you have chosen to cease monitoring the record of $1.  To confirm this cancellation, please click the link below within the next 24 hours.\n\n";
	$eBBSubject			= "[phpmyfamily] Big Brother has detected a change in $1";
	$eBBBottom			= "This message has been sent because your phpmyfamily installation has Big Brother turned on.  Please see the config file if you wish to switch this off.\n\n";
	$ePwdSubject		= "[phpmyfamily] New Password";
	$ePwdBody		= "Somebody, hopefully you, has requested a new password for phpmyfamily.  Your username/password is now $1 \n\n";

//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	$err_listpeeps		= "Error listing people in database";
	$err_image_insert	= "Error inserting image into database";
	$err_list_enums		= "Error enumerating types on column";
	$err_list_census	= "Error listing available censuses";
	$err_keywords		= "Error retrieving names for keywords from database";
	$err_changed		= "Error retrieving list of last changed people";
	$err_father			= "Error retrieving father's details from database";
	$err_mother			= "Error retrieving mother's details from database";
	$err_spouse			= "Error retrieving spouse's details from database";
	$err_marriage		= "Error retrieving marriage details from database";
	$err_census_ret		= "Error retrieving census details from database";
	$err_children		= "Error retrieving childrens details from database";
	$err_siblings		= "Error retrieving sibling details from database";
	$err_transcript		= "Error inserting transcript into database";
	$err_trans			= "Error retrieving transcripts from database";
	$err_detail			= "Error inserting person details into database";
	$err_census			= "Error inserting census into database";
	$err_logon			= "Error logging on";
	$err_change			= "Error checking password change";
	$err_pwd_incorrect	= "Error - Incorrect password supplied";
	$err_pwd_match		= "Error - New passwords do not match";
	$err_update			= "Error updating new password";
	$err_pwd_success	= "Password successfully updated";
	$err_image			= "Error retrieving image from database";
	$err_images			= "Error retrieving images from database";
	$err_person			= "Error retrieving person from database";
	$err_new_user		= "Error inserting new user into database";
	$err_user_exist		= "Error - user already exists";
	$err_pwd			= "Error retrieving password from database";
	$err_delete_user	= "Error deleting user from database";
	$err_users			= "Error retrieving users from database";
	$err_census_delete	= "Error deleting census from database";
	$err_marriage_delete= "Error deleting marriage from database";
	$err_trans_delete	= "Error deleting transcript from database";
	$err_person_delete	= "Error deleting person from database";
	$err_trans_file		= "Error deleting transcript file";
	$err_image_file		= "Error deleting image file";
	$err_child_update	= "Error updating childrens records";
	$err_person_update	= "Error updating person details";
	$err_marriage_insert= "Error inserting marriage into database";

	// eof
?>
