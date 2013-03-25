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

// Swedish translation: Torkel Danielsson, torkel@toften.se

//=====================================================================================================================

//=====================================================================================================================
//  global definitions
//=====================================================================================================================

	$charset			= "ISO-8859-1";
	$clang				= "se";
	$dir				= "ltr";
	$datumfmt 			= "'%d/%m/%Y'";
	// flags are from http://flags.sourceforge.net
	// I can't find a copyrigh to credit
	// but I'm sure somebody has it
	$flag				= "images/se.gif";

//=====================================================================================================================
//=====================================================================================================================
	$currentRequest->setDateFormat($datefmt);

//=====================================================================================================================
// strings for translation
//=====================================================================================================================

	$strDivorce = "Skilsmässa";
	$strFirstNames = "Förnamn";
	$strLinkNames = "Prefix efternamn";
	$strLastName = "Efternamn";
	$strAKA = "Alias";
	$strLocations = "Platser";
	$strReport = "Sammanställning";
	$strMissing = "Saknas";
	$strDescendants     = "Ättlingar";
	$strLivingPerson    = "Levande person";
	$strAncestors       = "Anfäder";  
	$strDateDescr[0]    = "";    // Default for old entries without details
	$strDateDescr[1]    = "omkring"; // dev < 1 year
	$strDateDescr[2]    = "cirka"; // dev <5 år
	$strDateDescr[3]    = "skattad"; // dev. < 15 år
	$strDateDescr[4]    = "grovt"; // dev > 15 år
	$strDateDescr[5]    = "beräknad"; // Gedcom compatible
	$strDateDescr[6]    = "innan"; // Gedcom compatible
	$strDateDescr[7]    = "efter"; // Gedcom compatible
	$strDateDescr[8]    = "den"; // exact datum
	$strDateDescr[9]    = "vid"; // day not known
	$strDateDescr[10]   = "trolig"; // source inconclusive
	
	$strDateExplain[0]    = "Förvalt värde";
	$strDateExplain[1]    = "inom 1 år";
	$strDateExplain[2]    = "om 5 år";
	$strDateExplain[3]    = "om 15 år";
	$strDateExplain[4]    = "mer än 15 år";
	$strDateExplain[5]    = "beräknad"; // Gedcom compatible
	$strDateExplain[6]    = "innan"; // Gedcom compatible
	$strDateExplain[7]    = "efter"; // Gedcom compatible
	$strDateExplain[8]    = "exakt datum";
	$strDateExplain[9]    = "dag okänd";
	$strDateExplain[10]   = "säker källa";
	
	$strDate = "Datum";
	$strPlace = "Ort";
	$strCert = "Certifierad";
	$strSource = "Källa";
	$strReference = "Referens";
	$strURL = "URL";
	
	$strFaB = "Detaljer om fader vid födelse";
	$strSon = "Son";
	$strDaughter = "Dotter";
	$strWith = "med";
	
	$strPlace = "Ort";
	$strLatitude = "Latitud";
	$strLongitude = "Longitud";
	$strCentre = "Kartcentrum";
	
	$strCertainty = array("Osäkra belägg eller skattade data", "Ifrågasatt korrekthet (intervjuer, folkräkning, muntlig släkthistoria eller möjlig partsinlaga, t. ex. en självbiografi)", "Andrahandsuppgifter, uppteckningar gjorda en tid efter händelsen", "Användande av direkta förstahandsuppgifter eller uppgifter med starka belägg");

	$strInvalidPerson   = "Felaktigt personnamn";
	$strDeceasedPerson  = "Avliden person";    
  	$strOnFile			= "Registrerade personer";
	$strSelect			= "Välj person";
	$strUnknown			= "okänd";
	$strLoggedIn		= "Du är inloggad som ";
	$strAdmin			= "admin";
	$strLoggedOut		= "Du är inte inloggad";
	$strYes				= "Ja";
	$strNo				= "Nej";
	$strSubmit			= "Sänd";
	$strReset			= "Återställ";
	$strLogout			= "Logga ut";
	$strHome				= "Hem";
	$strEdit				= "Ändra";
	$strAdd				= "Addera";
	$strDetails			= "Detaljer";
	$strBorn				= "Född";
	$strBperiod			= "f.";
	$strCertified		= "Bekräftad";
	$strFather			= "Fader";
	$strRestricted		= "<a href=\"restricted.php\">Restricted</a>";
	$strDied				= "Död";
	$strMother			= "Moder";
	$strChildren		= "Barn";
	$strSiblings		= "Syskon";
	$strMarried			= "Gift";
	$strInsert			= "Infoga";
	$strNewMarriage	= "Nytt gifte";
	$strNotes			= "Noteringar";
	$strGallery			= "Bildgalleri";
	$strUpload			= "Hämta upp";
	$strNewImage		= "Ny bild";
	$strNoImages		= "Inga bilder tillgängliga";
	$strCensusDetails	= "Folkräkningsdetaljer";
	$strNewCensus		= "Ny folkräkning";
	$strNoInfo			= "Ingen information tillgänglig";
	$strYear				= "År";
	$strAddress			= "Adress";
	$strCondition		= "Förutsättning";
	$strOf				= "till";
	$strAnd				= "och";
	$strAge				= "Ålder";
	$strProfession		= "Yrke";
	$strBirthPlace		= "Födelseort";
	$strDocTrans		= "Dokumentavskrifter";
	$strNewTrans		= "Ny avskrift";
	$strTitle			= "Titel";
	$strDesc				= "Beskrivning";
	$strDate				= "datum";
	$strRightClick		= "Klicka på dokumenttiteln för nerladdning. (Kan krävas högerklick &amp; Spara som.. för Internet Explorer)";
	$strStats			= "Site-statistik";
	$strArea				= "Area";
	$strNumber			= "Nummer";
	$strCensusRecs		= "Folkräkningsposter";
	$strImages			= "Bilder";
	$strLast20			= "Senaste 20 uppdaterade personerna";
	$strPerson			= "Person";
	$strUpdated			= "Uppdaterad";
	$strEditing			= "Editering";
	$strName				= "Namn";
	$strDOB				= "Födelsedatum";
	$strDateFmt			= "Använd formatet YYYY-MM-DD";
	$strDOD				= "Dödsdatum";
	$strCauseDeath		= "Dödsorsak";
	$strMarriage		= "Giftemål";
	$strSpouse			= "Make/maka";
	$strCensus			= "Folkräkning";
	$strSchedule 		= "Förteckning";
	$strDragons			= "Se upp för drakar!";
	$strGender			= "Kön";
	$strMale				= "Man";
	$strFemale			= "Kvinna";
	$strNewPassword	= "Nytt lösenord";
	$strOldPassword	= "Gammalt lösenord";
	$strReOldPassword	= "Gammalt lösenord igen";
	$strChange			= "Ändra";
	$strPwdChange		= "Lösenordsändring";
	$strPwdChangeMsg	= "Var vänlig använd detta formulär vid lösenordsändring!";
	$strLogin			= "login";
	$strUsername		= "Användarnamn";
	$strPassword		= "Lösenord";
	$strRePassword		= "Lösenord igen";
	$strForbidden		= "Förbjuden";
	$strForbiddenMsg	= "Du har inte behörighet till begärd sida. Försök inte igen. Var vänlig klicka <a href=\"index.php\">här</a> för att fortsätta.";
	$strDelete			= "Radera";
	$strFUpload			= "Fil för uppladdning";
	$strFTitle			= "Filnamn";
	$strFDesc			= "Filbeskrivning";
	$strFDate			= "Fildatum";
	$strIUpload			= "Bild att ladda upp";
	$strISize			= "Endast JPEG (maxstorlek 1MB)";
	$strITitle			= "Bildtitel";
	$strIDesc			= "Bildbeskrivning";
	$strIDate			= "Bilddatum";
	$strOn				= "den";
	$strAt				= "i";
	$strAdminFuncs		= "Admin Funktioner";
	$strAction			= "åtgärd";
	$strUserCreate		= "Skapa ny användare";
	$strCreate			= "Skapa";
	$strBack				= "Åter";
	$strToHome			= "till hemsidan.";
	$strNewMsg			= "Var god och kontrollera att personen inte redan finns i databasen innan du gör registreringen!";
	$strIndex			= "Alla detaljer om personer födda efter $currentRequest->dispdate kan skydda sin identitet.  Om du är en registrerad användare så kan du se dessa detaljer och uppdatera informationen.  Alla kan se icke skyddad information.  Om du tror att någon här passar in i ditt failjeträd, var vänlig <a href=\"$1\">låt mig få veta detta!</a>";
	$strNote				= "Notering";
	$strFooter			= "Sänd email till <a href=\"$1\">webmaster</a> om problem uppstår.";
	$strPowered			= "Baserat på";
	$strPedigreeOf		= "Släkträd till";
	$strBirths			= "Födslar";
	$strAnniversary	= "Åminnelsedag";
	$strUpcoming		= "Kommande åminnelsedagar";
	$strMarriages		= "Giftemål";
	$strDeaths			= "Dödsfall";
	$strConfirmDelete	= "\"Är du säker på att du vill radera\\n'\" + year + \"' \" + section +\"?\"";
	$strTranscript		= "avskrift";
	$strImage			= "bild";
	$strNewPerson		= "en ny person";
	$strPedigree		= "Släktträd";
	$strToDetails		= "till detaljer";
	$strSurnameIndex	= "Släktnamnsindex";
	$strTopSurnames	= "Släktnamn, topp-10";
	$strTracking		= "Spårning";
	$strTrack			= "Spåra";
	$strThisPerson		= "denna person";
	$strTrackSpeel		= "Använd formuläret nedan för att spåra denna person. Du kommer att få ett mail varje gång uppdatering sker.";
	$strEmail			= "Email";
	$strSubscribe		= "Abonnera";
	$strUnSubscribe		= "Avbeställ abonnemang";
	$strMonAccept		= "Din begäran om uppföljning har registrerats.<br />Du kommer nu att få email varje gång denna person uppdateras.<br />";
	$strMonCease		= "Din begäran om att avsluta uppföljning har godkänts<br />Du kommer inte längre att få email när denna person uppdateras.<br />";
	$strMonError		= "Din uppföljningsbegäran har stött på problem.<br />Var vänlig kontakta systemets administratör för hjälp!";
	$strMonRequest		= "Din begäran om uppföljning är under registrering.<br />Ett bekräftande email har sänts till dig och du bör följa instruktionerna däri.<br />";
	$strCeaseRequest	= "Din begäran om avslutad uppföljning är under registrering.<br />Ett bekräftande email har sänts till dig och du bör följa instruktionerna däri.<br />";
	$strAlreadyMon		= "Det verkar som du redan har uppföljning på denna person.<br />Ingen åtgärd vidtas.<br />";
	$strNotMon			= "Det verkar som du inte har uppföljning på denna person.<br />Ingen åtgärd vidtas.<br />";
	$strRandomImage	= "Slumpad bild";
	$strMailTo			= "Sänd meddelande";
	$strSubject			= "Ämne";
	$strNoEmail			= "\"Du måste ange en email-adress\"";
	$strEmailSent		= "Ditt email har sänts till webmaster.";
	$strExecute			= "Processtid";
	$strSeconds			= "sekunder";
	$strStyle			= "Utseende";
	$strPreferences	= "Preferenser";
	$strRecoverPwd		= "Återställ lösenord";
	$strStop				= "Stopp";
	$strRememberMe		= "Kom ihåg mig";
	$strSuffix			= "Suffix";
	$strLost				= "Du har förlorat ditt lösenord";
	$strSent				= "Ett nytt lösenord har sänts till dig";
	$strMyLoggedIn		= "Inloggad tillphpmyfamily";
	$strAdminUser		= "Du är en <a href=\"admin.php\">admin</a> användare";
	$strMonitoring		= "Personer du följer upp:";
	$strChangeStyle	= "Ändra din stil";
	$strChangeEmail	= "Ändra din email";
	$strGedCom			= "Gedcom";
	$strCompleteGedcom	= "Avsluta gedcom";
	$strCreateFamily	= "Skapa ny familjemedlem";
	$strCreatePerson	= "Skapa ny person";

	$strEvent[0] = "Födelse";
	$strEvent[1] = "Dop";
	$strEvent[2] = "Död";
	$strEvent[3] = "Begravning";
	$strEvent[4] = "Lysning";
	$strEvent[5] = "Giftemål";
	$strEvent[6] = "Folkbokförd";
	$strEvent[7] = "Annat";
	$strEvent[8] = "Bild";
	$strEvent[9] = "Avskrift";
	
	$strEventVerb = array($strBorn,"Döpt",$strDied,"Begraven",$strEvent[4],$strMarried,"Folkbokförd","Annat", "Bild", "Avskrift");
//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 har uppdaterats";
	$eTrackBodyTop		= "Detta är ett automatiskt genererat mail.  $1 i $2 har ändrats av $3.  Klicka nedan för att se den uppdaterade posten\n\n";
	$eTrackBodyBottom	= "Du får detta meddelande därför att du begärt uppföljning av denna person. Klicka nedan om du vill avsluta uppföljningen\n\n";
	$eSubSubject		= "[phpmyfamily] uppföljningsbegäran";
	$eSubBody			= "Detta är ett automatiskt genererat mail.  Du får detta meddelande därför att du begärt ändrings-uppföljning för $1. För att bekräfta uppföljningen, klicka på länken nedan inom 24 timmar.\n\n";
	$eUnSubBody			= "Detta är ett automatiskt genererat mail.  Du får detta meddelande därför att du begärt att avsluta ändrings-uppföljning för $1.  För att bekräfta avbeställningen,  klicka på länken nedan inom 24 timmar.\n\n";
	$eBBSubject			= "[phpmyfamily] Big Brother har upptäckt en ändring i $1";
	$eBBBottom			= "Detta meddelande får du därför att din phpmyfamily-installation har Big-Brother-switchen påslagen. Vänligen ändra i konfigureringsfilen om du vill slå av den.\n\n";
	$ePwdSubject		= "[phpmyfamily] Nytt lösenord";
	$ePwdBody			= "Någon, förhoppningsvis du, har begärt ett nytt lösenord för phpmyfamily.  Ditt användarnamn/lösenord är nu $1 \n\n";

//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	$err_listpeeps		= "Fel vid listning personer i databas";
	$err_image_insert	= "Fel skrivning bild i databas";
	$err_list_enums	= "Fel enumeringstyper i kolumn";
	$err_list_census	= "Fel listning tillgängliga folkräkningar";
	$err_keywords		= "Fel sökning nyckelnamn i databas";
	$err_changed		= "Fel sökning lista över senaste personändringar";
	$err_father			= "Fel sökning fadersdetaljer i databas";
	$err_mother			= "Fel sökning modersdetaljer i databas";
	$err_spouse			= "Fel sökning syskondetaljer i databas";
	$err_marriage		= "Fel sökning giftemålsdetaljer i databas";
	$err_census_ret	= "Fel sökning folkräkningsdetaljer i databas";
	$err_children		= "Fel sökning barndetaljer i databas";
	$err_siblings		= "Fel sökning syskondetaljer i databas";
	$err_transcript	= "Fel upplägg avskrifter i databas";
	$err_trans			= "Fel sökning avksrift i databas";
	$err_detail			= "Fel upplägg persondetaljer i databas";
	$err_census			= "Fel upplägg folkräkning i databas";
	$err_logon			= "Fel påloggning";
	$err_change			= "Fel kontroll av lösenordsändring";
	$err_pwd_incorrect	= "Fel - Felaktigt lösenord";
	$err_pwd_match		= "Fel - Nya lösenord stämmer inte";
	$err_update			= "Fel uppdatering nytt lösenord";
	$err_pwd_success	= "Lösenordsändring lyckades";
	$err_image			= "Fel sökning bild från databas";
	$err_images			= "Fel sökning bilder från databas";
	$err_person			= "Fel sökning person från databas";
	$err_new_user		= "Fel upplägg av ny användare i databas";
	$err_user_exist	= "Fel - användare finns redan";
	$err_pwd				= "Fel sökning löseord från databas";
	$err_delete_user	= "Fel radering användare från databas";
	$err_users			= "Fel sökning users från databas";
	$err_census_delete	= "Fel radering folkräkning från databas";
	$err_marriage_delete	= "Fel radering giftemål från databas";
	$err_trans_delete		= "Fel radering avskrift från databas";
	$err_person_delete	= "Fel radering person från databas";
	$err_trans_file		= "Fel radering avskriftsfil";
	$err_image_file		= "Fel radering bildfil";
	$err_child_update		= "Fel uppdatering barnfil";
	$err_person_update	= "Fel uppdatering persondetaljer";
	$err_marriage_insert	= "Fel upplägg giftemål i databas";

	// eof
?>
