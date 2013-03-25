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
	
	// Translation by Pål Engh

//=====================================================================================================================

//=====================================================================================================================
//  global definitions
//=====================================================================================================================

	$charset			= "ISO-8859-1";
	$clang				= "no";
	$dir				= "ltr";
	$datefmt 			= "'%d.%m.%Y'";
	// flags are from http://flags.sourceforge.net
	// I can't find a copyrigh to credit
	// but I'm sure somebody has it
	$flag				= "images/no.gif";

//=====================================================================================================================
//=====================================================================================================================
	$currentRequest->setDateFormat($datefmt);

//=====================================================================================================================
// strings for translation
//=====================================================================================================================

	$strOnFile			= "mennesker i arkivet";
	$strSelect			= "Velg person";
	$strUnknown			= "ukjent";
	$strLoggedIn		= "Du er innlogget som ";
	$strAdmin			= "admin";
	$strLoggedOut		= "Du er nå logget inn: ";
	$strYes				= "Ja";
	$strNo				= "Nei";
	$strSubmit			= "Lagre";
	$strReset			= "Tilbakestill";
	$strLogout			= "logg ut";
	$strHome			= "hjem";
	$strEdit			= "rediger";
	$strAdd				= "legg til";
	$strDetails			= "Detaljer";
	$strBorn			= "Født";
	$strCertified		= "Certified";
	$strFather			= "Far";
	$strRestricted		= "Restricted";
	$strDied			= "Døde";
	$strMother			= "Mor";
	$strChildren		= "Barn";
	$strSiblings		= "Søsken";
	$strMarried			= "Gift";
	$strInsert			= "sett inn";
	$strNewMarriage		= "nytt ekteskap";
	$strNotes			= "Notater";
	$strGallery			= "Fotoalbum";
	$strUpload			= "last opp";
	$strNewImage		= "nytt bilde";
	$strNoImages		= "Bilde inne tilgjengelig";
	$strCensusDetails	= "Detaljer fra folketelling";
	$strNewCensus		= "ny folketelling";
	$strNoInfo			= "Ingen informasjon tilgjengelig";
	$strYear			= "År";
	$strAddress			= "Address";
	$strCondition		= "Tilstand";
	$strOf				= "of";
	$strAge				= "Alder";
	$strProfession		= "Stilling";
	$strBirthPlace		= "Fødested";
	$strDocTrans		= "Dokumentavskrift";
	$strNewTrans		= "ny avskrift";
	$strTitle			= "Tittel";
	$strDesc			= "Beskrivelse";
	$strDate			= "Dato";
	$strRightClick		= "Klikk på dokumentet du vil laste ned. (Kan hende du må¨høyreklikke &amp; Lagre som... i Internett Explorer)";
	$strStats			= "Statistikk";
	$strArea			= "Område";
	$strNo				= "Nummer";
	$strCensusRecs		= "Notater fra folketelling";
	$strImages			= "Bilder";
	$strLast20			= "Siste 20 oppdaterte personer";
	$strPerson			= "Person";
	$strUpdated			= "Oppdatert";
	$strEditing			= "Redigering";
	$strName			= "Navn";
	$strDOB				= "Fødselsdato";
	$strDateFmt			= "Vennligst benytt formatet ÅÅÅÅ-MM-DD";
	$strDOD				= "Dødsdato";
	$strCauseDeath		= "Dødsårsak";
	$strMarriage		= "Giftemål";
	$strSpouse			= "Ektefelle";
	$strDOM				= "Bryllupsdato";
	$strMarriagePlace	= "Bryllupssted";
	$strCensus			= "Folketelling";
	$strSchedule 		= "Planlegg (schedule)";
	$strDragons			= "Here be dragons!";
	$strGender			= "Kjønn";
	$strMale			= "Mann";
	$strFemale			= "Kvinne";
	$strNewPassword		= "Nytt passord";
	$strOldPassword		= "Gammelt passord";
	$strReOldPassword	= "Gjenta det gamle passordet";
	$strChange			= "Endre";
	$strPwdChange		= "Bytt passord";
	$strPwdChangeMsg	= "Benytt dette skjemaet dersom du øsnker å endre passordet ditt.";
	$strLogin			= "Logg inn";
	$strUsername		= "Brukernavn";
	$strPassword		= "Passord";
	$strRePassword		= "Gjenta det nye passordet";
	$strForbidden		= "Forbudt";
	$strForbiddenMsg	= "Du har ikke tilstrekkelig med rettigheter til å se siden du ba om. Ikke gjenta forespørselen.  Vennligst klikk <a href=\"index.php\">her</a> for å fortsette.";
	$strDelete			= "slette";
	$strFUpload			= "Last opp fil";
	$strFTitle			= "Filnavn";
	$strFDesc			= "Filbeskrivelse";
	$strFDate			= "Fildato";
	$strIUpload			= "Last opp bilde";
	$strISize			= "Kun JPEG (max størrelse 1MB)";
	$strITitle			= "Bildetittel";
	$strIDesc			= "Bildebeskrivelse";
	$strIDate			= "Bildedato";
	$strOn				= "on";
	$strAt				= "i";
	$strAdminFuncs		= "Admin-funksjoner";
	$strAction			= "handling";
	$strUserCreate		= "Opprett ny bruker";
	$strCreate			= "Opprett";
	$strBack			= "Tilbake";
	$strToHome			= "til startsiden.";
	$strNewMsg			= "Vennligst påse at personen ikke er registrert tidligere før du oppretter!";
	$strIndex			= "Alle detaljer om personer født etter $currentRequest->dispdate kan beskytte sin identitet. Dersom du er en registrert bruker kan du se disse detaljene og redigere oppføringene.  Alle står fritt til å se på uinnskrenkede oppføringer.  Dersom du mener at noen her passer inn i ditt familietre, vær snill å <a href=\"$1\">gi meg beskjed</a>";
	$strNote			= "Notat";
	$strFooter			= "Send e-post til <a href=\"$1\">webmaster</a> ved eventuelle problemer.";
	$strPowered			= "Powered by";
	$strPedigreeOf		= "Slektstre til";
	$strBirths			= "Fødsler";
	$strAnniversary		= "Jubileum";
	$strUpcoming		= "Kommende jubileer";
	$strMarriages		= "Giftemål";
	$strDeaths			= "Dødsfall";
	$strConfirmDelete	= "\"Er du sikker på at du vil slette\\n'\" + year + \"' \" + section +\"?\"";
	$strTranscript		= "avskrift";
	$strImage			= "bilde";
	$strDoubleDelete	= "\"Er du sikker på at du vil SLETTE denne personen\\nDenne prosessen kan IKKE angres!!\"";
	$strBirthCert		= "Fødselsattest utstedt?";
	$strDeathCert		= "Dødsattest utstedt?";
	$strMarriageCert	= "Bryllupsattest utstedt?";
	$strNewPerson		= "en ny person";
	$strPedigree		= "stamtre";
	$strToDetails		= "til detaljer";
	$strSurnameIndex	= "Oversikt over slektsnavn";
	$strTopSurnames		= "Slektsnavn, topp-10";
	$strTracking		= "Spore";
	$strTrack			= "spor";
	$strThisPerson		= "denne personen";
	$strTrackSpeel		= "Benytt skjemaet under for å spore denne personen.  Du får automatisk tilsendt en e-post hver gang oppføringer på denne personen blir oppdatert.";
	$strEmail			= "E-post";
	$strSubscribe		= "abonner";
	$strUnSubscribe		= "Stopp abonnement";
	$strMonAccept		= "Du har fått godkjent overvåking av denne personen<br />Du vil nå motta en e-post hver gang oppføringer på denne personen blir oppdatert.<br />";
	$strMonCease		= "Du har stoppet overvåking av denne personen<br />Di vil ikke lenger motta e-post.<br />";
	$strMonError		= "Det har oppstått et problem med overvåkningsforespørselen din.<br />Vennligst ta kontakt med nettstedets administrator for avidere hjelp.";
	$strMonRequest		= "Forespørselen om å overvåke denne personen er ferdigbehandlet.<br />Bekreftelse er sendt deg på e-postadressen du oppga. Vennligst følg instruksjoner som beskrevet i e-posten.<br />";
	$strCeaseRequest	= "Din forespørsel om å stoppe overvåking av denne personen er ferdigbehandlet.<br />Bekreftelse er sendt deg på e-postadressen du oppga. Vennligst følg instruksjoner som beskrevet i e-posten.<br />";
	$strAlreadyMon		= "Det ser ut som du allerede overvåker denne personen.<br />Ingen handling er påkrevet.<br />";
	$strNotMon			= "Det ser ikke ut til at du overvåker dennepersonen.<br />Ingen handling er påkrevet.<br />";
	$strRandomImage		= "Tilfeldig bilde";
	$strMailTo			= "Send melding";
	$strSubject			= "Overskrift";
	$strNoEmail			= "\"Du må oppgi en e-postadresse\"";
	$strEmailSent		= "Din e-post er sendt til webmaster.";
	$strExecute			= "Prosesseringstid";
	$strSeconds			= "sekunder";

//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 er oppdatert";
	$eTrackBodyTop		= "Dette er en automatisk e-post.  $1 i $2 er oppdatert.  Klikkunder for å se den oppdaterte oppføringen\n\n";
	$eTrackBodyBottom	= "Du mottar denne meldingen fordi du tidligere ba om overvåking av denne personen.  Klikk under for å fjerne deg fra leisten\n\n";
	$eSubSubject		= "[phpmyfamily] åvervåkingsforespørsel";
	$eSubBody			= "Dette er en automatisk e-post.  Du mottar denne meldingen fordi du tidligere ba om å overvåke nedtegningene til $1.  For å bekrefte dette abonnementet bes du klikke linken udner innen 24 timer.\n\n";
	$eUnSubBody			= "Dette er en automatisk e-post.  Du mottar denne meldingen fordi du har bedt om ikke lenger å overvåke nedtegningene til $1.  For å bekrefte dette abonnementet bes du klikke linken udner innen 24 timer.\n\n";

//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	$err_listpeeps		= "Feil ved listing av personer i databasen";
	$err_image_insert	= "Feil ved innlasting av bilde i databasen";
	$err_list_enums		= "Feil ved opptelling av kolonner";
	$err_list_census	= "FEil ved listing av folketellinger";
	$err_keywords		= "Feil ved henting av navn for nøkkelord fra databasen";
	$err_changed		= "Feil ved henting av lister over sist endrede personer";
	$err_father			= "Feil ved henting av fars detaljer fra datbasen";
	$err_mother			= "Feil ved henting av mors detaljer fra datbasen";
	$err_spouse			= "Feil ved henting av ektefelles detaljer fra datbasen";
	$err_marriage		= "Feil ved henting av bryllupsdetaljer fra datbasen";
	$err_census_ret		= "Feil ved henting av folketellingsdetaljer fra datbasen";
	$err_children		= "Feil ved henting av barns detaljer fra datbasen";
	$err_siblings		= "Feil ved henting av søskens detaljer fra datbasen";
	$err_transcript		= "Feil ved skriving av avskrifter til databasen";
	$err_trans			= "Feil ved henting av avskrifter fra databasen";
	$err_detail			= "Feil ved skriving av persondetaljer til databasen";
	$err_census			= "Feil ved skriving av folketellingsinformasjon til databasen";
	$err_logon			= "Feil ved pålogging";
	$err_change			= "Feil ved kontroll av passordbytte";
	$err_pwd_incorrect	= "Feil - Du har benyttet feil passord";
	$err_pwd_match		= "Feil - Det nye passordet passer ikke";
	$err_update			= "Feil ved oppdatering av nytt passord";
	$err_pwd_success	= "Password successfully updated";
	$err_image			= "Feil ved henting av bilde fra database";
	$err_images			= "Feil ved henting av bilder fra database";
	$err_person			= "Feil ved henting av person fra database";
	$err_new_user		= "Feil ved oppretting av ny bruker i database";
	$err_user_exist		= "Feil - Bruker finnes allerede";
	$err_pwd			= "Feil ved henting av passord fra database";
	$err_delete_user	= "Feil ved sletting av bruker fra database";
	$err_users			= "Feil ved henting av brukere fra database";
	$err_census_delete	= "Feil ved sletting av folketelling fra database";
	$err_marriage_delete= "Feil ved sletting av giftemål fra database";
	$err_trans_delete	= "Feil ved henting avskrift fra database";
	$err_person_delete	= "Feil ved sletting av person fra database";
	$err_trans_file		= "Feil ved sletting av avskriftsfil";
	$err_image_file		= "Feil ved sletting av bildefil";
	$err_child_update	= "Feil ved oppdatering av barns oppføringer";
	$err_person_update	= "Feil ved oppdatering av persondetaljer";
	$err_marriage_insert= "Feil ved skriving av giftemål til databasen";

	// eof
?>
