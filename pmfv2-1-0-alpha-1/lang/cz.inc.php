<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2004  Simon E Booth (simon.booth@giric.com)

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

	//Czech translation by Jan Zalud <jan.zalud@gmail.com> 

//=====================================================================================================================

//=====================================================================================================================
//  global definitions
//=====================================================================================================================

	$charset			= "windows-1250"; //"ISO-8859-2";
	$clang				= "cz";
	$dir				= "ltr";
	$datefmt 			= "'%d.%m.%Y'";
	// flags are from http://flags.sourceforge.net
	// I can't find a copyright to credit
	// but I'm sure somebody has it
	$flag				= "images/cz.gif";

//=====================================================================================================================
//=====================================================================================================================
	$currentRequest->setDateFormat($datefmt);

//=====================================================================================================================
// strings for translation
//=====================================================================================================================

	$strOnFile			= "osob v databázi";
	$strSelect			= "Vybrat osobu";
	$strUnknown			= "neznámý";
	$strLoggedIn			= "Jste pøihlášen/a jako ";
	$strAdmin			= "administrátor";
	$strLoggedOut			= "Nejste pøihlášen/a";
	$strYes				= "Ano";
	$strNo				= "Ne";
	$strSubmit			= "Odeslat";
	$strReset			= "Prázdný formuláø";
	$strLogout			= "odhlásit";
	$strHome			= "domù";
	$strEdit			= "editovat";
	$strAdd				= "pøidat";
	$strDetails			= "Detaily";
	$strBorn			= "Narozen/a";
	$strCertified			= "Potvrzeno";
	$strFather			= "Otec";
	$strRestricted			= "Omezení";
	$strDied			= "Zemøel/a";
	$strMother			= "Matka";
	$strChildren			= "Dìti";
	$strSiblings			= "Sourozenci";
	$strMarried			= "Svatba";
	$strInsert			= "pøidat";
	$strNewMarriage			= "novou svatbu";
	$strNotes			= "Poznámky";
	$strGallery			= "Galerie obrázkù";
	$strUpload			= "nahrát";
	$strNewImage			= "nový obrázek";
	$strNoImages			= "Žádné dostupné obrázky";
	$strCensusDetails		= "Detaily ze sèítání lidu";
	$strNewCensus			= "nový záznam ze sèítání lidu";
	$strNoInfo			= "Žádné dostupné informace";
	$strYear			= "Rok";
	$strAddress			= "Adresa";
	$strCondition			= "Podmínka";
	$strOf				= "";
	$strAge				= "Vìk";
	$strProfession			= "Profese";
	$strBirthPlace			= "Místo narození";
	$strDocTrans			= "Dokumenty";
	$strNewTrans			= "nový dokument";
	$strTitle			= "Název";
	$strDesc			= "Popis";
	$strDate			= "Datum";
	$strRightClick			= "Dokument mùžete zobrazit kliknutím na jeho název.";
	$strStats			= "Statistiky serveru";
	$strArea			= "Kategorie";
	$strNo				= "Poèet";
	$strCensusRecs			= "Záznamy ze sèítání lidu";
	$strImages			= "Obrázky";
	$strLast20			= "Posledních 20 upravených záznamù";
	$strPerson			= "Osoba";
	$strUpdated			= "Upraveno";
	$strEditing			= "Úpravy";
	$strName			= "Jméno";
	$strDOB				= "Datum narození";
	$strDateFmt			= "Formát RRRR-MM-DD";
	$strDOD				= "Datum úmrtí";
	$strCauseDeath			= "Dùvod úmrtí";
	$strMarriage			= "Svatba";
	$strSpouse			= "Manžel/ka";
	$strDOM				= "Datum svatby";
	$strMarriagePlace		= "Místo svatby";
	$strCensus			= "Sèítání lidu";
	$strSchedule 			= "Seznam";
	$strDragons			= "HIC SUNT LEONES";
	$strGender			= "Pohlaví";
	$strMale			= "Muž";
	$strFemale			= "Žena";
	$strNewPassword			= "Nové heslo";
	$strOldPassword			= "Pùvodní heslo";
	$strReOldPassword		= "Znovu vložte pùvodní heslo";
	$strChange			= "Zmìnit";
	$strPwdChange			= "Zmìna hesla";
	$strPwdChangeMsg		= "Pro zmìnu hesla použijte tento formuláø.";
	$strLogin			= "pøihlášení";
	$strUsername			= "Uživatelské jméno";
	$strPassword			= "Heslo";
	$strRePassword			= "Znovu vložte heslo";
	$strForbidden			= "Pøístup zamítnut";
	$strForbiddenMsg		= "Pro zobrazení této stránky nemáte dostateèné oprávnìní. Pokraèujte <a href=\"index.php\">zde</a>.";
	$strDelete			= "odstranit";
	$strFUpload			= "Soubor k nahrání";
	$strFTitle			= "Název souboru";
	$strFDesc			= "Popis souboru";
	$strFDate			= "Datum souboru";
	$strIUpload			= "Obrázek k nahrání";
	$strISize			= "pouze JPEG (max. velikost 1MB)";
	$strITitle			= "Název obrázku";
	$strIDesc			= "Popis obrázku";
	$strIDate			= "Datum obrázku";
	$strOn				= "dne";
	$strAt				= "";
	$strAdminFuncs			= "Administrace";
	$strAction			= "akce";
	$strUserCreate			= "Vytvoøit nového uživatele";
	$strCreate			= "Vytvoøit";
	$strBack			= "Zpìt";
	$strToHome			= "na úvodní stránku.";
	$strNewMsg			= "Pøed vložením nového záznamu o osobì se ujistìte, zda již databázi neexistuje!";
	$strIndex			= "Pøístup k údajùm o osobách narozených pøed datem $currentRequest->dispdate je z dùvodu ochrany osobních dat omezen.  Prohlížení ostatních záznamù není uživatelùm omezeno.  Pokud se domníváte, že nìkdo ze zde uloženého seznamu osob patøí i Vašeho rodinného stromu, <a href=\"$1\">napište mi</a>.";
	$strNote			= "Poznámka";
	$strFooter			= "V pøípadì problémù pošlete e-mail na <a href=\"$1\">webmaster</a>.";
	$strPowered			= "Vytvoøeno za použití technologie ";
	$strPedigreeOf			= "Rodokmen";
	$strBirths			= "Narozeniny";
	$strAnniversary			= "Výroèí";
	$strUpcoming			= "Nadcházející výroèí";
	$strMarriages			= "Svatby";
	$strDeaths			= "Úmrtí";
	$strConfirmDelete		= "\"Jste si skuteènì jist/a, že chcete ODSTRANIT\\n'\" + year + \"' \" + section +\"?\"";
	$strTranscript			= "dokument";
	$strImage			= "obrázek";
	$strDoubleDelete	= "\"Jste si skuteènì jist/a, že chcete ODSTRANIT záznam o této osobì?\\nSmazání je nevratné!!\"";
	$strBirthCert		= "Narození potvrzeno?";
	$strDeathCert		= "Úmrtí potvrzeno?";
	$strMarriageCert	= "Svatba potvrzena?";
	$strNewPerson		= "novou osobu";
	$strPedigree		= "rodokmen";
	$strToDetails		= "na detaily";
	$strSurnameIndex	= "Seznam pøíjmení";
	$strTracking		= "Monitorování";
	$strTrack		= "log";
	$strThisPerson		= "tato osoba";
	$strTrackSpeel		= "Použijte níže uvedený formuláø pro monitorování záznamu o této osobì.  Po každé zmìnì záznamu Vám bude odeslán e-mail.";
	$strEmail		= "E-mail";
	$strSubscribe		= "pøihlásit";
	$strUnSubscribe		= "odhlásit";
	$strMonAccept		= "Váš požadavek na monitorování byl pøijat.<br />Od tohoto okamžiku Vám bude odeslán e-mail pokaždé, když bude záznam o dané osobì zmìnìn.<br />";
	$strMonCease		= "Váš požadavek na ukonèení monitorování byl pøijat.<br />Další e-maily Vám již nebudou zasílány.<br />";
	$strMonError		= "Vyskytl se problém s Vaším požadavkem na monitorování.<br />Pro vyøešení problému kontaktujte, prosím, administrátora.";
	$strMonRequest		= "Váš požadavek na monitorování se zpracovává.<br />Na Vaši adresu byl odeslán potvrzovací e-mail s dalšími instrukcemi.<br />";
	$strCeaseRequest	= "Váš požadavek na ukonèení monitorování se zpracovává.<br />Na Vaši adresu byl odeslán potvrzovací e-mail s dalšími instrukcemi.<br />";
	$strAlreadyMon		= "Tato osoba je již monitorována.<br />Není tøeba dalšího nastavování.<br />";
	$strNotMon		= "Tato osoba není monitorována.<br />Není tøeba dalšího nastavování.<br />";
	$strRandomImage		= "Náhodný obrázek";
	$strMailTo		= "Poslat zprávu";
	$strSubject		= "Pøedmìt";
	$strNoEmail		= "\"Musíte vyplnit e-mailovou adresu\"";
	$strEmailSent		= "Váš e-mail byl odeslán administrátorovi.";
	$strExecute		= "Sestavení stránky trvalo";
	$strSeconds		= "sekund";
	$strStyle		= "Styl";
	$strPreferences		= "nastavení";
	$strRecoverPwd		= "zapomenuté heslo";
	$strStop		= "stop";
	$strRememberMe		= "Pamatovat si";
	$strSuffix		= "Suffix";
	$strLost		= "Zapomenuté heslo";
	$strSent		= "Nové heslo bylo odesláno";
	$strMyLoggedIn		= "Pøihlášen/a do phpmyfamily";
	$strAdminUser		= "Jste <a href=\"admin.php\">administrátor</a>";
	$strMonitoring		= "Osoby, které monitorujete";
	$strChangeStyle		= "Zmìna stylu";
	$strChangeEmail		= "Zmìna e-mailu";
	$strGedCom		= "gedcom";

//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 - záznam byl zmìnìn";
	$eTrackBodyTop		= "Toto je automaticky generovaná zpráva.  Záznam o $1 v $2 byl zmìnìn uživatelem $3.  Pro zobrazení zmìnìného záznamu kliknìte na odkaz\n\n";
	$eTrackBodyBottom	= "Tato zpráva Vám byla odeslána, protože jste si nastavil monitorování záznamu o dané osobì.  Pro ukonèení monitorování kliknìte na odkaz\n\n";
	$eSubSubject		= "[phpmyfamily] požadavek na monitorování";
	$eSubBody		= "Toto je automaticky generovaná zpráva.  Tato zpráva Vám byla odeslána, protože jste si nastavil monitorování záznamu o osobì $1.  Požadavek potvrïte bìhem 24 hodin kliknutím na odkaz\n\n";
	$eUnSubBody		= "Toto je automaticky generovaná zpráva.  Tato zpráva Vám byla odeslána, protože jste ukonèil monitorování záznamu o osobì. $1.  Požadavek na ukonèení potvrïte bìhem 24 hodin kliknutím na odkaz\n\n";
	$eBBSubject		= "[phpmyfamily] Big Brother zaznamenal zmìnu v záznamu $1";
	$eBBBottom		= "Tato zpráva Vám byla odeslána, protože instalace phpmyfamily má zapnutý Big Brother.  Pro vypnutí je tøeba zásah do souboru config.php.\n\n";
	$ePwdSubject		= "[phpmyfamily] Nové heslo";
	$ePwdBody		= "Nìkdo, pravdìpodobnì Vy, požádal o vytvoøení nového pøístupového hesla pro phpmyfamily.  Vaše nové heslo je $1 \n\n";

//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	$err_listpeeps		= "Error listing people in database";
	$err_image_insert	= "Error inserting image into database";
	$err_list_enums		= "Error enumerating types on column";
	$err_list_census	= "Error listing available censuses";
	$err_keywords		= "Error retrieving names for keywords from database";
	$err_changed		= "Error retrieving list of last changed people";
	$err_father		= "Error retrieving father's details from database";
	$err_mother		= "Error retrieving mother's details from database";
	$err_spouse		= "Error retrieving spouse's details from database";
	$err_marriage		= "Error retrieving marriage details from database";
	$err_census_ret		= "Error retrieving census details from database";
	$err_children		= "Error retrieving childrens details from database";
	$err_siblings		= "Error retrieving sibling details from database";
	$err_transcript		= "Error inserting transcript into database";
	$err_trans		= "Error retrieving transcripts from database";
	$err_detail		= "Error inserting person details into database";
	$err_census		= "Error inserting census into database";
	$err_logon		= "Error logging on";
	$err_change		= "Error checking password change";
	$err_pwd_incorrect	= "Error - Incorrect password supplied";
	$err_pwd_match		= "Error - New passwords do not match";
	$err_update		= "Error updating new password";
	$err_pwd_success	= "Password successfully updated";
	$err_image		= "Error retrieving image from database";
	$err_images		= "Error retrieving images from database";
	$err_person		= "Error retrieving person from database";
	$err_new_user		= "Error inserting new user into database";
	$err_user_exist		= "Error - user already exists";
	$err_pwd		= "Error retrieving password from database";
	$err_delete_user	= "Error deleting user from database";
	$err_users		= "Error retrieving users from database";
	$err_census_delete	= "Error deleting census from database";
	$err_marriage_delete	= "Error deleting marriage from database";
	$err_trans_delete	= "Error deleting transcript from database";
	$err_person_delete	= "Error deleting person from database";
	$err_trans_file		= "Error deleting transcript file";
	$err_image_file		= "Error deleting image file";
	$err_child_update	= "Error updating childrens records";
	$err_person_update	= "Error updating person details";
	$err_marriage_insert	= "Error inserting marriage into database";

	// eof
?>
