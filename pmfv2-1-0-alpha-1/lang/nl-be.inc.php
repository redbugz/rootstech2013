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
	$clang				= "nl";
	$dir				= "ltr";
	$datefmt 			= "'%d/%m/%Y'";
	// flags are from http://flags.sourceforge.net
	// I can't find a copyrigh to credit
	// but I'm sure somebody has it
	$flag				= "images/gb.gif";

//=====================================================================================================================
//=====================================================================================================================
	$currentRequest->setDateFormat($datefmt);

//=====================================================================================================================
// strings for translation
//=====================================================================================================================

$strAncestors           = "Voorouders";
$strDescendants         = "Afstammelingen";
$strLivingPerson        = "Levend persoon";
    $strDeceasedPerson  = "Overleden Persoon";  // NL-BE
	$strOnFile			= "mensen in de databank";
	$strSelect			= "Selecteer een persoon";
	$strUnknown			= "onbekend";
	$strLoggedIn		= "U bent ingelogged als ";
	$strAdmin			= "admin";
	$strLoggedOut		= "U bent niet ingelogged";
	$strYes				= "Ja";
	$strNo				= "Neen";
	$strSubmit			= "Doorsturen";
	$strReset			= "Leegmaken";
	$strLogout			= "uitloggen";
	$strHome			= "home";
	$strEdit			= "wijzig";
	$strAdd				= "een nieuwe persoon";
	$strDetails			= "Details";
	$strBorn			= "Geboren";
	$strCertified		= "Authentieke akte";
	$strFather			= "Vader";
	$strRestricted		= "<a href=\"restricted.php\">Voorbehouden</a>";
	$strDied			= "Overleden";
	$strMother			= "Moeder";
	$strChildren		= "Kinderen";
	$strSiblings		= "Brussen";
	$strMarried			= "Gehuwd";
	$strInsert			= "toevoegen";
	$strNewMarriage		= "nieuw huwelijk";
	$strNotes			= "Notities";
	$strGallery			= "Afbeeldingsgallerij";
	$strUpload			= "opladen";
	$strNewImage		= "nieuwe afbeelding";
	$strNoImages		= "Geen afbeeldingen beschikbaar";
	$strCensusDetails	= "Bevolkingstelling details";
	$strNewCensus		= "nieuwe bevolkingstelling";
	$strNoInfo			= "Geen informatie beschikbaar";
	$strYear			= "Jaar";
	$strAddress			= "Adres";
	$strCondition		= "Voorwaarde";
	$strOf				= "van";
	$strAge				= "Leeftijd";
	$strProfession		= "Beroep";
	$strBirthPlace		= "Geboorteplaats";
	$strDocTrans		= "Document Transcripties";
	$strNewTrans		= "nieuwe transcriptie";
	$strTitle			= "Titel";
	$strDesc			= "Beschrijving";
	$strDate			= "Datum";
	$strRightClick		= "Klik op de documentnaam om te downloaden. (Mogelijks moet je met de rechter muisknop klikken en &amp; Sla doel op als... in Internet Explorer)";
	$strStats			= "Site Statistieken";
	$strArea			= "Zone";
	$strNo				= "Aantal";
	$strCensusRecs		= "Gegevens bevolkingstellingen";
	$strImages			= "Afbeeldingen";
	$strLast20			= "Laatste 20 opgeladen personen";
	$strPerson			= "Persoon";
	$strUpdated			= "Bijgewerkt";
	$strEditing			= "Wijzigen";
	$strName			= "Naam";
	$strDOB				= "Geboortedatum";
	$strDateFmt			= "Gelieve het formaat JJJJ-MM-DD te gebruiken";
	$strDOD				= "Overlijdensdatum";
	$strCauseDeath		= "Reden van overlijden";
	$strMarriage		= "Huwelijk";
	$strSpouse			= "Echtgeno(o)t(e)";
	$strDOM				= "Huwelijksdatum";
	$strMarriagePlace	= "Huwelijksplaats";
	$strCensus			= "Officiële telling";
	$strSchedule 		= "Rooster";
	$strDragons			= "Hier zijn onuitstaanbare mensen!";
	$strGender			= "Geslacht";
	$strMale			= "Mannelijk";
	$strFemale			= "Vrouwelijk";
	$strNewPassword		= "Nieuw Paswoord";
	$strOldPassword		= "Oud Paswoord";
	$strReOldPassword	= "Voer Oud Paswoord opnieuw in";
	$strChange			= "Wijzig";
	$strPwdChange		= "Paswoord wijzigen";
	$strPwdChangeMsg	= "Gelieve dit formulier te gebruiken om uw paswoord te wijzigen.";
	$strLogin			= "login";
	$strUsername		= "Gebruikersnaam";
	$strPassword		= "Paswoord";
	$strRePassword		= "Paswoord nogmaals invoeren";
	$strForbidden		= "Verboden";
	$strForbiddenMsg	= "U hebt niet voldoende rechten om de pagina te bekijken die je hebt opgevraagd.. Gelieve deze opvraging niet te herhalen.  Gelieve <a href=\"index.php\">hier</a> te klikken om verder te gaan.";
	$strDelete			= "verwijder";
	$strFUpload			= "Op te laden bestand";
	$strFTitle			= "Bestandstitel";
	$strFDesc			= "Bestandsbeschrijving";
	$strFDate			= "Datum bestand";
	$strIUpload			= "Op te laden afbeelding";
	$strISize			= "enkel JPEG-formaat (max grootte 1MB)";
	$strITitle			= "Afbeeldingstitel";
	$strIDesc			= "Afbeeldingsbeschrijving";
	$strIDate			= "Afbeeldingsdatum";
	$strOn				= "op";
	$strAt				= "te";
	$strAdminFuncs		= "Administrator Functies";
	$strAction			= "actie";
	$strUserCreate		= "Creëer nieuwe gebruiker";
	$strCreate			= "Creëer";
	$strBack			= "Terug";
	$strToHome			= "naar de homepage.";
	$strNewMsg			= "Gelieve u er van te vergewissen dat de persoon die je wenst te creëren nog niet in de databank werd opgenomen!";
	$strIndex			= "Alle details van mensen geboren na $currentRequest->dispdate zijn vertrouwelijk. Indien je een geregistreerde gebruiker bent kan je deze details consulteren en de gegevens bijwerken.  Iedereen heeft toegang tot de onbeperkte gegevens. Indien je denkt dat iemand in je familiestamboom thuishoort, gelieve <a href=\"$1\">mij een seintje te geven</a>";
	$strNote			= "Notitie";
	$strFooter			= "Email de <a href=\"$1\">webmaster</a> indien je problemen tegenkomt.";
	$strPowered			= "Ondersteund door";
	$strPedigreeOf		= "Stamboom van";
	$strBirths			= "Geboortes";
	$strAnniversary		= "Verjaardag";
	$strUpcoming		= "Nakende verjaardagen";
	$strMarriages		= "Huwelijken";
	$strDeaths			= "Overlijdens";
	$strConfirmDelete	= "\"Bent u zeker dat je de volgende gegevens wenst te verwijderen : \\n'\" + year + \"' \" + section +\"?\"";
	$strTranscript		= "transcriptie";
	$strImage			= "afbeelding";
	$strDoubleDelete	= "\"Bent u echt zeker dat je deze persoon wil VERWIJDEREN\\nDit proces is ONOMKEERBAAR!!\"";
	$strBirthCert		= "Geboorte Officieel Verklaard?";
	$strDeathCert		= "Overlijden Officieel Verklaard?";
	$strMarriageCert	= "Huwelijk Officieel Verklaard?";
	$strNewPerson		= "toevoegen";
	$strPedigree		= "stamboom";
	$strToDetails		= "naar details";
	$strSurnameIndex	= "Achternamenindex";
	$strTracking		= "Volgen";
	$strTrack			= "volg";
	$strThisPerson		= "deze persoon";
	$strTrackSpeel		= "Gebruik onderstaand formulier om een persoon op te sporen. Je ontvangt een email wanneer de gegevens van deze persoon worden bijgewerkt.";
	$strEmail			= "Email";
	$strSubscribe		= "inschrijven";
	$strUnSubscribe		= "uitschrijven";
	$strMonAccept		= "Uw vraag tot monitoring werd geaccepteerd.<br />Je zal steeds een email ontvangen wanneer de gegevens van deze persoon worden bijgewerkt.<br />";
	$strMonCease		= "Uw vraag om de monitoring te staken werd geaccepteerd.<br />U zult niet langer emails ontvangen.<br />";
	$strMonError		= "Er is een probleem opgetreden bij uw monitoring verzoek.<br />Gelieve de site administrator te contacteren om assistentie te verlenen.";
	$strMonRequest		= "Uw vraag om deze persoon te monitoren wordt behandeld.<br />Een bevestigingsmail werd gestuurd naar uw email-adres. Gelieve de daarin medegedeelde instructies op te volgen.<br />";
	$strCeaseRequest	= "Uw vraag om de monitoring van deze persoon te staken wordt behandeld.<br />Een bevestigingsmail werd gestuurd naar uw email-adres. Gelieve de daarin medegedeelde instructies op te volgen.<br />";
	$strAlreadyMon		= "Het lijkt er op dat je deze persoon reeds controleert.<br />Er is geen actie vereist.<br />";
	$strNotMon			= "Het lijkt er op dat je deze persoon nog niet controleert.<br />Er is geen actie vereist.<br />";
	$strRandomImage		= "Willekeurige Afbeelding";
	$strMailTo			= "Stuur een bericht";
	$strSubject			= "Onderwerp";
	$strNoEmail			= "\"U moet een email adres ingeven\"";
	$strEmailSent		= "Uw email werd naar de webmaster gestuurd.";
	$strExecute			= "Uitvoertijd";
	$strSeconds			= "seconden";
	$strStyle			= "Stijl";
	$strPreferences		= "voorkeuren";
	$strRecoverPwd		= "paswoord recupereren";
	$strStop			= "stop";
	$strRememberMe		= "Vergeet mij niet";
	$strSuffix			= "Suffix";
	$strLost			= "U bent uw paswoord kwijt";
	$strSent			= "Een nieuw paswoord werd doorgestuurd";
	$strMyLoggedIn		= "Ingeloged op phpmyfamily";
	$strAdminUser		= "Je bent een <a href=\"admin.php\">admin</a> gebruiker";
	$strMonitoring		= "Mensen die je opvolgt (monitoring)";
	$strChangeStyle		= "Wijzig uw stijl";
	$strChangeEmail		= "Wijzig uw email adres";
	$strGedCom			= "gedcom";

//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 werd bijgewerkt";
	$eTrackBodyTop		= "Dit is een geautomatiseerd bericht.  $1 te $2 werd gewijzigd door $3.  Klik hieronder om het bijgewerkte record te consulteren\n\n";
	$eTrackBodyBottom	= "Dit bericht werd doorgestuurd omdat je vroeger hebt ingeschreven om deze persoon op te volgen. Klik hieronder om jezelf uit deze monitoring lijst te schrappen\n\n";
	$eSubSubject		= "[phpmyfamily] monitoring aanvraag";
	$eSubBody			= "Dit is een geautomatiseerd bericht. U ontvangt dit bericht omdat je ervoor koos de gegevens van $1 op te volgen. Om deze inschrijving te bevestigen, gelieve onderstaande link binnen de 24 uur te gebruiken.\n\n";
	$eUnSubBody			= "Dit is een geautomatiseerd bericht.  U ontvangt dit bericht omdat je ervoor koos de gegevens van $1 niet langer op te volgen. Om deze annulering te bevestingen, gelieve onderstaande link binnen de 24 uur te gebruiken.\n\n";
	$eBBSubject			= "[phpmyfamily] Big Brother heeft een wijziging in $1 vastgesteld";
	$eBBBottom			= "Dit bericht werd naar u gestuurd omdat uw phpmyfamily installatie Big Brother geactiveerd heeft. Gelieve het configuratiebestand aan te passen om dit te desactiveren.\n\n";
	$ePwdSubject		= "[phpmyfamily] Nieuw Paswoord";
	$ePwdBody		= "Iemand, hopelijk jij, heeft een nieuw paswoord aangevraagd voor phpmyfamily.  Uw paswoord is nu $1 \n\n";

//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	$err_listpeeps		= "Fout bij rangschikken van mensen in de databank";
	$err_image_insert	= "Fout bij toevoegen van afbeelding in de databank";
	$err_list_enums		= "Fout bij opsommen van types op kolom";
	$err_list_census	= "Fout bij rangschikken van beschikbare volkstellingen";
	$err_keywords		= "Fout bij terugvinden van namen voor sleutelwoorden uit de databank";
	$err_changed		= "Fout bij het opmaken van de lijst met laatst gewijzigde personen";
	$err_father			= "Fout bij het terugvinden van vader\s' details uit de databank";
	$err_mother			= "Fout bij het terugvinden van moeders\' details uit de databank";
	$err_spouse			= "Fout bij het terugvinden van gegevens van echtgeno(o)t(e) uit de databank";
	$err_marriage		= "Fout bij het terugvinden van huwelijksgegevens uit de databank";
	$err_census_ret		= "Fout bij het terugvinden van gegevens bevolkingstellingen uit de databank";
	$err_children		= "Fout bij het terugvinden van gegevens over kinderen uit de databank";
	$err_siblings		= "Fout bij het terugvinden van gegevens over brussen in de databank";
	$err_transcript		= "Fout bij het inbrengen van een transcriptie in de databank";
	$err_trans			= "Fout bij het terugvinden van een transcriptie in de databank";
	$err_detail			= "Fout bij het invoeren van persoonsdetails in de databank";
	$err_census			= "Fout bij het invoeren van bevolkingstellingsgegevens in de databank";
	$err_logon			= "Fout bij inloggen";
	$err_change			= "Fout bij controle op paswoordwijziging";
	$err_pwd_incorrect	= "Fout - Foutief paswoord meegegeven";
	$err_pwd_match		= "Fout - Nieuwe paswoorden komen niet overeen";
	$err_update			= "Fout bij bijwerken van het nieuwe paswoord";
	$err_pwd_success	= "Paswoàrd successvol bijgewerkt";
	$err_image			= "Fout bij het terugvinden van een afbeelding uit de databank";
	$err_images			= "Fout bij het terugvinden van afbeeldingen uit de databank";
	$err_person			= "Fout bij terugvinden van een persoon in de databank";
	$err_new_user		= "Fout bij het invoegen van een nieuwe gebruiker in de databank";
	$err_user_exist		= "Fout - Deze gebruiker bestaat reeds";
	$err_pwd			= "Fout bij het terugvinden van een paswoord uit de databank";
	$err_delete_user	= "Fout bij verwijderen van een gebruiker uit de databank";
	$err_users			= "Fout bij terugvinden van gebruiker in de databank";
	$err_census_delete	= "Fout bij verwijderen van volkstelling uit de databank";
	$err_marriage_delete= "Fout bij verwijderen van een huwelijk uit de databank";
	$err_trans_delete	= "Fout bij verwijderen van transcriptie uit de databank";
	$err_person_delete	= "Fout bij verwijderen van een persoon uit de databank";
	$err_trans_file		= "Fout bij verwijderen van transcriptiebestand";
	$err_image_file		= "Fout bij verwijderen van een afbeeldingsbestand";
	$err_child_update	= "Fout bij het bijwerken van gegevens over kinderen";
	$err_person_update	= "Fout bij het bijwerken van details van een persoon";
	$err_marriage_insert= "Fout bij invoegen van een huwelijk in de databank";

	// eof
?>
