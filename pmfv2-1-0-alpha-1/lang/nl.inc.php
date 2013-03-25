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
	
	// Translation by Kees Dommisse  mailto:dommisse@gmx.net

//=====================================================================================================================
//  global definitions
//=====================================================================================================================

	$charset			= "ISO-8859-1";
	$clang				= "nl";
	$dir				= "ltr";
	$datefmt 			= "'%d/%m/%Y'";
	// flags are from http://flags.sourceforge.net
	// I can't find a copyright to credit
	// but I'm sure somebody has it -- Dutch flag is selfmade so: GNU General Public License
	$flag				= "images/nl.gif";

//=====================================================================================================================
//=====================================================================================================================
	$currentRequest->setDateFormat($datefmt);

//=====================================================================================================================
// strings for translation
//=====================================================================================================================

    $strAncestors       = "Voorouders";
    $strDescendants     = "Afstammelingen";
    $strLivingPerson    = "Levend persoon";
    $strDeceasedPerson  = "Overleden Persoon";  // NL
	$strOnFile			= "Personen in de gegevensverzameling";
	$strSelect			= "Kies een persoon";
	$strUnknown			= "Onbekend";
	$strLoggedIn		= "U bent aangemeld als ";
	$strAdmin			= "Admin";
	$strLoggedOut		= "U bent niet ingelogd ";
	$strYes				= "Ja";
	$strNo				= "Neen";
	$strSubmit			= "Versturen";
	$strReset			= "Terugzetten";
	$strLogout			= "Afmelden";
	$strHome			= "Startpagina";
	$strEdit			= "Wijzigen";
	$strAdd				= "Toevoegen";
	$strDetails			= "Details";
	$strBorn			= "Geboren";
	$strCertified		= "Akte/certificaat";
	$strFather			= "Vader";
	$strRestricted		= "<a href=\"restricted.php\">Beperkt: Privacy beschermd</a>";
	$strDied			= "Gestorven";
	$strMother			= "Moeder";
	$strChildren		= "Kinderen";
	$strSiblings		= "Broers en zusters";
	$strMarried			= "Getrouwd";
	$strInsert			= "Tussenvoegen";
	$strNewMarriage		= "Nieuw huwelijk";
	$strNotes			= "Opmerkingen";
	$strGallery			= "Afbeeldingen";
	$strUpload			= "upload";
	$strNewImage		= "Nieuwe afbeelding";
	$strNoImages		= "Geen afbeeldingen beschikbaar";
	$strCensusDetails	= "Volkstellingsdetails";
	$strNewCensus		= "nieuwe volkstelling";
	$strNoInfo			= "Geen informatie beschikbaar";
	$strYear			= "Jaar";
	$strAddress			= "Adres";
	$strCondition		= "Toestand";
	$strOf				= " ";
	$strAge				= "Leeftijd";
	$strProfession		= "Beroep";
	$strBirthPlace		= "Geboorteplaats";
	$strDocTrans		= "Document afschift/copie";
	$strNewTrans		= "Nieuw afschrift/copie";
	$strTitle			= "Titel";
	$strDesc			= "Beschrijving";
	$strDate			= "Datum";
	$strRightClick		= "Klik op de dokument-titel om te downloaden. (eventueel met de rechter muisknop klikken en dan _Opslaan Als_ kiezen..... in Internet Explorer)";
	$strStats			= "Statistieken";
	$strArea			= "Bereik";
	$strNo				= "Aantal";
	$strCensusRecs		= "Tellingsgegevens";
	$strImages			= "Afbeeldingen";
	$strLast20			= "De laatste 20 bijgewerkte personen";
	$strPerson			= "Persoon";
	$strUpdated			= "Bijgewerkt";
	$strEditing			= "Wijzigen";
	$strName			= "Naam";
	$strDOB				= "Geboortedatum";
	$strDateFmt			= "Gebruik het format JJJJ-MM-DD";
	$strDOD				= "Sterfdag";
	$strCauseDeath		= "Overlijdensdetails";
	$strMarriage		= "Huwelijk";
	$strSpouse			= "Echtgeno(o)t(e)";
	$strDOM				= "Trouwdag";
	$strMarriagePlace	= "Plaats van het huwelijk";
	$strCensus			= "Telling";
	$strSchedule 		= "Verloop";
	$strDragons			= "Hier zijn de draken! Dit programma bied geen oplossing voor dit probleem!";
	$strGender			= "Geslacht";
	$strMale			= "Mannelijk";
	$strFemale			= "Vrouwelijk";
	$strNewPassword		= "Nieuw Wachtwoord";
	$strOldPassword		= "Oud Wachtwoord";
	$strReOldPassword	= "Herhaal Oud Wachtwoord";
	$strChange			= "Wijzig";
	$strPwdChange		= "Wachtwoord Veranderen";
	$strPwdChangeMsg	= "Gebruik dit formulier om uw Wachtwoord te veranderen.";
	$strLogin			= "Aanmelden";
	$strUsername		= "Gebruikersnaam";
	$strPassword		= "Wachtwoord";
	$strRePassword		= "Herhaal Wachtwoord";
	$strForbidden		= "Verboden";
	$strForbiddenMsg	= "U hebt niet de benodigde rechten om de gevraagde pagina in te zien. De aanvraag mag niet herhaald worden.  Klik  <a href=\"index.php\">hier</a> om verder te gaan.";
	$strDelete			= "Wissen";
	$strFUpload			= "Gegevens om te Uploaden";
	$strFTitle			= "Titel van de gegevens";
	$strFDesc			= "Beschrijving van de gegevens";
	$strFDate			= "Datum van de Gegevens ";
	$strIUpload			= "Afbeelding om te Uploaden";
	$strISize			= "JPEG uitsluitend (maximale grootte 1MB)";
	$strITitle			= "Titel van de Afbeelding";
	$strIDesc			= "Beschrijving van de Afbeelding";
	$strIDate			= "Datum van de Afbeelding";
	$strOn				= "op";
	$strAt				= "te";
	$strAdminFuncs		= "Admin Functies";
	$strAction			= "Aktie";
	$strUserCreate		= "nieuwe gebruiker aanmaken";
	$strCreate			= "Aanmaken";
	$strBack			= "Terug";
	$strToHome			= "Naar de Introbladzijde.";
	$strNewMsg			= "Wees, vóór het aanmaken, er zeker van dat de persoon niet al in de gegevensverzameling bestaat!";
	$strIndex			= "Alle details over mensen die na de $currentRequest->dispdate geboren zijn, zijn in toegang beperkt om hun identiteit te beschermen. Als geregistreerd gebruiker bent u gerechtigd die details in te zien en te veranderen.  Het is iedereen toegestaan de onbeschermde gegevens in te zien. Als u denkt dat iemand, die hier is opgenomen, in uw familiestamboom past, of als u een account wilt, <a href=\"$1\">laat het mij dan weten.</a><br><br><font color=\"#FF0000\">NB de emailfuncies in deze module werken niet of niet naar behoren. gebruik daarom het (eenvoudig) <a href=\"../contact/simpel/\">reactieformulier achter de contact-link!</a> - Zie ook de opmerking daarover op de home-page</font>";
	$strNote			= "Let op:";
	$strFooter			= "Stuur een email naar de <a href=\"$1\">webmaster</a> in het geval dat er problemen optreden.";
	$strPowered			= "Ondersteund door";
	$strPedigreeOf		= "Stamboom van";
	$strBirths			= "Geboren";
	$strAnniversary		= "Gedenkdagen";
	$strUpcoming		= "Aankomende gedenkdagen";
	$strMarriages		= "Getrouwd";
	$strDeaths			= "Overleden";
	$strConfirmDelete	= "\"Bent u er zeker van dat u de\\n'\" + year + \"' \" + section +\" wilt verwijderen?\"";
	$strTranscript		= "afschrift/copie";
	$strImage			= "Afbeelding";
	$strDoubleDelete	= "\"Bent u er zeker van dat u deze persoon wilt WISSEN?\\nDit proces is NIET OMKEERBAAR!!\"";
	$strBirthCert		= "Akte van geboorte?";
	$strDeathCert		= "Akte van overlijden?";
	$strMarriageCert	= "Trouw akte?";
	$strNewPerson		= "Nieuwe persoon";
	$strPedigree		= "Stamboom";
	$strToDetails		= "naar_details";
	$strSurnameIndex	= "Achternamen index";
	$strTracking		= "Volgen";
	$strTrack			= "volg";
	$strThisPerson		= "deze_persoon";
	$strTrackSpeel		= "Gebruik onderstaande formulier om (de gegevens van) deze persoon te volgen. U krijgt dan automatisch elke keer een email toegestuurd wanneer de gegevens van deze persoon veranderd/bijgewerkt worden.";
	$strEmail			= "Email";
	$strSubscribe		= "Aanmelden";
	$strUnSubscribe		= "Afmelden";
	$strMonAccept		= "Uw aanvraag voor berichtgeving wordt hiermee bevestigd<br />U krijgt automatisch een email, elke keer wanneer de gegevens van deze persoon veranderen.<br />";
	$strMonCease		= "Uw aanvraag om de berichtgeving te stoppen wordt hiermee bevestigd.<br />U zult geen emails meer ontvangen.<br />";
	$strMonError		= "Met uw aanvraag is een probleem opgetreden.<br />Meldt u zich voor hulp bij de beheerder van deze webstek";
	$strMonRequest		= "Uw observatieaanvraag is verwerkt.<br />Een bevestigingsemail is naar u toegestuurd. Gelieve de aanwijzingen in de email binnen 24 uur op te volgen.<br />";
	$strCeaseRequest	= "Uw aanvraag om de observatie te stoppen is verwerkt.<br />Een bevestigingsemail is naar u toegestuurd. Gelieve de aanwijzingen in de email binnen 24 uur op te volgen.<br />";
	$strAlreadyMon		= "Deze persoon wordt al door U gevolgd.<br /> Actie is niet nodig.<br />";
	$strNotMon			= "Deze persoon wordt niet door u gevolgd.<br />Actie is niet nodig.<br />";
	$strRandomImage		= "Willekeurige afbeelding";
	$strMailTo			= "Bericht verzenden";
	$strSubject			= "Onderwerp";
	$strNoEmail			= "\"U moet een geldig emailadres opgeven\"";
	$strEmailSent		= "Uw email is naar de webmaster toegestuurd.";
	$strExecute			= "Tijd voor de uitvoering";
	$strSeconds			= "seconden";
	$strStyle			= "Stijl";
	$strPreferences		= "Voorkeuren";
	$strRecoverPwd		= "Nieuw_wachtwoord_vragen";
	$strStop			= "Stop";
	$strRememberMe		= "Onthou me";
	$strSuffix			= "Achtervoegsel";
	$strLost			= "U bent uw wachtwoord kwijt";
	$strSent			= "Er is een nieuw wachtwoord opgestuurd";
	$strMyLoggedIn		= "Ingelogd bij phpmyfamily";
	$strAdminUser		= "U bent een <a href=\"admin.php\">admin</a> gebruiker";
	$strMonitoring		= "Personen die u monitort";
	$strChangeStyle		= "Verander uw stijl";
	$strChangeEmail		= "Verander uw emailadres";
	$strGedCom			= "Gedcom";
	
//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 is bijgewerkt";
	$eTrackBodyTop		= "Dit is een automatisch aangemaakt bericht.  $1 is om $2 is gewijzigd door $3.  Klik hieronder om de bijgewerkte gegevens te bekijken\n\n";
	$eTrackBodyBottom	= "Dit bericht is naar u gestuurd omdat u zich aangemeld hebt voor het volgen van deze persoon. Klik hieronder als u zich van deze dienst wil afmelden\n\n";
	$eSubSubject		= "[phpmyfamily] Observatieverzoek";
	$eSubBody			= "Dit is een automatisch aangemaakt bericht. U hebt dit bericht ontvangen omdat u de gegevens van persoon $1 wilde volgen. Om deze aanmelding te bevestigen dient u binnen 24 uur de link hieronder aan te klikken.\n\n";
	$eUnSubBody			= "Dit is een automatisch aangemaakt bericht. U hebt dit bericht gekregen omdat u zich heeft afgemeld voor de observatiedienst voor de gegevens van $1  Om deze afmelding te bevestigen dient u binnen 24 uur de link hieronder aan te klikken.\n\n";
	$eBBSubject			= "[phpmyfamily] Big Brother heeft een wijziging geconstateerd in $1";
	$eBBBottom			= "Dit bericht is verzonden omdat u in uw phpmyfamily installatie Bog Brother op aan hebt staan.  Bekijk de config file als u wilt dat het wordt uitgezet.\n\n";
	$ePwdSubject		= "[phpmyfamily] Nieuw Wachtwoord";
	$ePwdBody		= "Iemand en laten we hopen U, heeft een nieuw wachtwoord aangevraagd voor phpmyfamily.  Uw wachtwoord is nu $1 \n\n";

//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	$err_listpeeps		= "Fout bij het uitlijsten van personen in de gegevensverzameling";
	$err_image_insert	= "Fout bij het invoegen van een afbeelding in de gegevensverzameling";
	$err_list_enums		= "Fout bij het opsommen van kolomtypen";
	$err_list_census	= "Fout bij het uitlijsten van de beschikbare tellingen";
	$err_keywords		= "Fout bij het ophalen van namen als steekwoorden uit de gegevensverzameling";
	$err_changed		= "Fout bij het ophalen van de lijst van de laatst veranderde personengegevens";
	$err_father			= "Fout bij het ophalen van de vader-details uit de gegevensverzameling";
	$err_mother			= "Fout bij het ophalen van de moeder-details uit de gegevensverzameling";
	$err_spouse			= "Fout bij het ophalen van de echtgeno(o)t(e)-details uit de gegevensverzameling";
	$err_marriage		= "Fout bij het ophalen van de huwelijks-details uit de gegevensverzameling";
	$err_census_ret		= "Fout bij het ophalen van de volkstellings-details uit de gegevensverzameling";
	$err_children		= "Fout bij het ophalen van de kinderen-details uit de gegevensverzameling";
	$err_siblings		= "Fout bij het ophalen van de broers/zusters-details uit de gegevensverzameling";
	$err_transcript		= "Fout bij het invoegen van afschriften/copieen in de gegevensverzameling";
	$err_trans			= "Fout bij het ophalen van de afschriften/copieen uit de gegevensverzameling";
	$err_detail			= "Fout bij het invoegen van persoonsgegevens in de gegevensverzameling";
	$err_census			= "Fout bij het invoegen van de volkstellingsgegevens in de gegevensverzameling";
	$err_logon			= "Fout bij het aanmelden";
	$err_change			= "Fout bij de controle van de wachtwoordverandering";
	$err_pwd_incorrect	= "Fout - Fout wachtwoord ingegeven";
	$err_pwd_match		= "Fout - de nieuwe (dubbel) ingegeven wachtwoorden zijn niet identiek.";
	$err_update			= "Fout bij het bijwerken van het nieuwe wachtwoord";
	$err_pwd_success	= "Het wachtwoord is succesvol bijgewerkt";
	$err_image			= "Fout bij het ophalen van een afbeelding uit de gegevensverzameling";
	$err_images			= "Fout bij het ophalen van afbeeldingen uit de gegevensverzameling";
	$err_person			= "Fout bij het ophalen van persoonsgegevens uit de gegevensverzameling";
	$err_new_user		= "Fout bij het invoegen van een nieuwe gebruiker in de gegevensverzameling";
	$err_user_exist		= "Fout - Gebruiker bestaat al";
	$err_pwd			= "Fout bij het ophalen van een wachtwoord uit de gegevensverzameling";
	$err_delete_user	= "Fout bij het wissen van een gebruiker uit de gegevensverzameling";
	$err_users			= "Fout bij het ophalen van gebruikersgegevens uit de gegevensverzameling";
	$err_census_delete	= "Fout bij het wissen van volkstellingsgegevens uit de gegevensverzameling";
	$err_marriage_delete= "Fout bij het wissen van huwelijksgegevens uit de gegevensverzameling";
	$err_trans_delete	= "Fout bij het wissen van een afschrift/copie uit de gegevensverzameling";
	$err_person_delete	= "Fout bij het wissen van een persoon uit de gegevensverzameling";
	$err_trans_file		= "Fout bij het wissen van afschrift/copie gegevens";
	$err_image_file		= "Fout bij het wissen van gegevens over afbeeldingen";
	$err_child_update	= "Fout bij het bijwerken van gegevens van kinderen";
	$err_person_update	= "Fout bij het aktualiseren van gegevens van personen";
	$err_marriage_insert= "Fout bij het invoeren van gegevens over huwelijken in de gegevensverzameling";

	// eof
?>
