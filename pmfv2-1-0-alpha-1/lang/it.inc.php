<?php

	//Hacked File by FaberK
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
	
	//Italian translation by Fabrizio Gatti aka FaberK - f.gatti@dms.it

//=====================================================================================================================

//=====================================================================================================================
//  global definitions
//=====================================================================================================================

	$charset			= "ISO-8859-1";
	$clang				= "it";
	$dir				= "ltr";
	$datefmt 			= "'%d/%m/%Y'";
	// flags are from http://flags.sourceforge.net
	// I can't find a copyrigh to credit
	// but I'm sure somebody has it
	$flag				= "images/it.gif";
        $strPhpMyFamily                 ="Albero Genealogico"; // MODIFICA 20120506 
        $strMsgDescendants                  ="Questo modulo è SPERIMENTALE - per favore segnala nel forum qualsiasi anomalia o eventuali migliorie."; // MODIFICA 20120506         
//=====================================================================================================================
//=====================================================================================================================
	$currentRequest->setDateFormat($datefmt);

//=====================================================================================================================
// strings for translation
//=====================================================================================================================

//=====================================================================================================================
// vecchia versione
//=====================================================================================================================

	// $strTreeOf		=    "Albero Genealogico";
	// $strDOM				= "Data del Matrimonio";
	// $strMarriagePlace	= "Luogo del Matrimonio";
	// $strScheda        = "scheda";
	// $strDoubleDelete	= "\"Sei sicuro di voler CANCELLARE questa persona\\nLa cancellazione sarà DEFINITIVA!!\"";
// $strConfirmDelete	= "\"Are you sure you wish to delete the\\n'\" + year + \"' \" + section +\"?\"";	
	// $strBirthCert		= "Nascita Certificata?";
	// $strDeathCert		= "Morte Certificata?";
	// $strMarriageCert	= "Matrimonio Certificato?";
        // $strYears         = "anni";	
//=====================================================================================================================

 // MODIFICA 20120506
	$strDivorce = "Divorzio";
	$strFirstNames = "Nome/i";
	$strLinkNames = "Iniziale Cognome";
	$strLastName = "Cognome";
	$strAKA = "Nomignolo";
	$strLocations = "Residenza";
	$strReport = "Rapporto";
	$strMissing = "Mancante";
	$strDescendants     = "Discendenti";
	$strLivingPerson    = "Persona vivente";
	$strAncestors       = "Antenati";  
	$strDateDescr[0]    = "";    // Default for old entries without details
	$strDateDescr[1]    = "prima del"; // dev < 1 year
	$strDateDescr[2]    = "dopo del"; // dev <5 years
	$strDateDescr[3]    = "stimato"; // dev. < 15 years
	$strDateDescr[4]    = "circa"; // dev > 15 years
	$strDateDescr[5]    = "calcolato"; // Gedcom compatible
	$strDateDescr[6]    = "prima del"; // Gedcom compatible
	$strDateDescr[7]    = "dopo del"; // Gedcom compatible
	$strDateDescr[8]    = "il"; // exact date
	$strDateDescr[9]    = "nel"; // day not known
	$strDateDescr[10]   = "forse il"; // source inconclusive
	
	$strDateExplain[0]    = "Predefinito";
	$strDateExplain[1]    = "entro 1 anno";
	$strDateExplain[2]    = "entro 5 anni";
	$strDateExplain[3]    = "entro 15 anni";
	$strDateExplain[4]    = "oltre 15 anni";
	$strDateExplain[5]    = "calcolato"; // Gedcom compatible
	$strDateExplain[6]    = "prima del"; // Gedcom compatible
	$strDateExplain[7]    = "dopo del"; // Gedcom compatible
	$strDateExplain[8]    = "data esatta";
	$strDateExplain[9]    = "nel";
	$strDateExplain[10]   = "forse il";
	
	$strDate = "Data";
	$strPlace = "Luogo";
	$strCert = "Certificato";
	$strSource = "Fonte";
	$strReference = "Referenza";
	$strURL = "URL";
	
	$strFaB = "Dettagli del padre alla nascita";
	$strSon = "Figlio";
	$strDaughter = "Figlia";
	$strWith = "con";
	
	$strPlace = "Luogo";
	$strLatitude = "Latitudine";
	$strLongitude = "Longitudine";
	$strCentre = "Centro della mappa";
	
	$strCertainty = array("Prova inaffidabile o data presunta","Affidabilità discutibile della prova (interviste, census, genealogie orali, o potenziale imparzialità: es. autobiografia)","Prova secondaria, dati ufficialmente registrati qualche tempo dopo l'evento","Prova diretta e primaria usata, o per prevalenza della prova");

	$strInvalidPerson   = "Nome della persona non valido";
	$strDeceasedPerson  = "Persona deceduta";    // EN-UK
        
 // FINE MODIFICA 20120506
 
	$strOnFile			= "persone registrate";
	$strSelect			= "Seleziona la persona";
	$strUnknown			= "sconosciuto/a"; // MODIFICA 20120506
	$strLoggedIn		        = "Utente: "; // MODIFICA 20120506
	$strAdmin			= "Ammin."; // MODIFICA 20120506
	$strLoggedOut		        = "Ospite"; // MODIFICA 20120506
	$strYes				= "Si";
	$strNo				= "No";
	$strSubmit			= "Invia";
	$strReset			= "Resetta";
	$strLogout			= "Esci";
	$strHome			= "PrimaPagina"; // MODIFICA 20120506
	$strEdit			= "Edita";
	$strAdd				= "Aggiungi";
	$strDetails			= "Dettagli";
	$strBorn			= "Nato/a"; // MODIFICA 20120506
	$strBornAbbrev			= "n."; // MODIFICA 20120506	
	$strCertified		        = "Certificato";
	$strFather			= "Padre";
	$strRestricted		        = "Dati protetti"; // MODIFICA 20120506
	$strDied			= "Morte";
	$strMother			= "Madre";
	$strChildren		= "Figli e Figlie"; // MODIFICA 20120506
	$strSiblings		= "Fratelli e Sorelle"; // MODIFICA 20120506
	$strMarried			= "Sposato/a"; // MODIFICA 20120506
	$strInsert			= "Inserisci";
	$strNewMarriage		= "nuovo matrimonio";
	$strNotes			= "Note";
	$strGallery			= "Galleria d'immagini";
	$strUpload			= "Carica";
	$strNewImage		= "nuova immagine";
	$strNoImages		= "Nessuna immagine disponibile";
	$strCensusDetails	= "Dettagli Censiti";
	$strNewCensus		= "nuovo censimento"; // MODIFICA 20120506
	$strNoInfo			= "Nessuna informazione disponibile";
	$strYear			= "Anno";
	$strAddress			= "Indirizzo";
	$strCondition		= "Condizione";
	$strOf				= "di";
	$strAnd				= "e"; // MODIFICA 20120506
	$strAge				= "Età";
	$strProfession		= "Professione";
	$strBirthPlace		= "Luogo di nascita";
	$strDocTrans		= "Documenti trascritti"; // MODIFICA 20120506
	$strNewTrans		= "nuova trascrizione"; // MODIFICA 20120506
	$strTitle			= "Titolo";
	$strDesc			= "Descrizione";
	$strDate			= "Data";
	$strRightClick		= "Clicca il titolo del documento da scaricare. (Potrebbe richiedere il click destro &amp; Salva Oggetto come.. in Internet Explorer)";
	$strStats			= "Statistiche sito";
	$strArea			= "Area";
	$strNo				= "Numero";
	$strCensusRecs		= "Schede Census"; // MODIFICA 20120506
	$strImages			= "Immagini";
	$strLast20			= "Ultime 20 Persone Aggiornate";
	$strPerson			= "Persona";
	$strUpdated			= "Aggiornata";
	$strEditing			= "Editando";
	$strName			= "Nome";
	$strDOB				= "Data di Nascita";
	$strDateFmt			= "Si prega di usare il formato AAAA-MM-GG"; // MODIFICA 20120506
	$strDOD				= "Data di Morte";
	$strCauseDeath		= "Causa della Morte";
	$strMarriage		= "Sposato/a"; // MODIFICA 20120506
	$strSpouse			= "Moglie";
	$strCensus			= "Censimento";
	$strSchedule 		= "Programma";
	$strDragons			= "Here be dragons!";
	$strGender			= "Sesso";
	$strMale			= "Maschile";
	$strFemale			= "Femminile";
	$strNewPassword		= "Nuova Password";
	$strOldPassword		= "Vecchia Password";
	$strReOldPassword	= "Re-inserisci Vecchia Password";
	$strChange			= "Cambia";
	$strPwdChange		= "Cambia Password";
	$strPwdChangeMsg	= "Usa questo modulo se vuoi cambiare password."; // MODIFICA 20120506
	$strLogin			= "Accesso"; // MODIFICA 20120506
	$strUsername		= "Utente"; // MODIFICA 20120506
	$strPassword		= "Password";
	$strRePassword		= "Re-inserisci Password";
	$strForbidden		= "Proibito";
	$strForbiddenMsg	= "Non hai i permessi necessari a visualizzare la pagina richiesta.  Per favore clicca <a href=\"index.php\">quì</a> per continuare."; // MODIFICA 20120506
	$strDelete			= "Cancella";
	$strFUpload			= "File da caricare"; // MODIFICA 20120506
	$strFTitle			= "Titolo File"; // MODIFICA 20120506
	$strFDesc			= "Descrizione File"; // MODIFICA 20120506
	$strFDate			= "Data File"; // MODIFICA 20120506
	$strIUpload			= "Immagine da Caricare"; // MODIFICA 20120506
	$strISize			= "Solo JPEG (dimensione massima 1MB)";
	$strITitle			= "Titolo Immagine"; // MODIFICA 20120506
	$strIDesc			= "Descrizione Immagine"; // MODIFICA 20120506
	$strIDate			= "Data Immagine"; // MODIFICA 20120506
	$strOn				= "il";
	$strAt				= "a";
	$strAdminFuncs		= "Funzioni Amministrative";
	$strAction			= "azione";
	$strUserCreate		= "Crea nuovo utente";
	$strCreate			= "Crea";
	$strBack			= "Indietro";
	$strToHome			= "Prima pagina"; // MODIFICA 20120506
	$strNewMsg			= "Accertati che la persona non sia già presente nel database prima di crearla!"; // MODIFICA 20120506
	$strIndex			= "Tutti i dati delle persone nate dopo il $currentRequest->dispdate sono riservati.  Se sei un utente registrato puoi vedere i loro dati e modificarli. Chiunque è libero di consultare i dati non confidenziali.<br /><b>Se desideri inserire i dati della tua famiglia in questo albero genealogico, per favore <a href=\"$1\">contattami</a></b> oppure inviami questa "; // MODIFICA 20120508
	$strScheda                      = "scheda.";
	$strNote			= "Note";
	$strFooter			= "Scrivi al <a href=\"$1\">webmaster</a> senza problema.";
	$strPowered			= "Powered by";
	$strPedigreeOf		= "Albero genealogico di";
	$strBirths			= "Nascite";
	$strAnniversary		= "Anniversario";
	$strYears               = "anni";
	$strUpcoming		= "Prossimi Anniversari";
	$strMarriages		= "Matrimoni";
	$strDeaths			= "Morti";
	$strConfirmDelete	= "\"Sei sicuro di voler CANCELLARE\\n'\" + year + \"' \" + section +\"?\"";
	$strTranscript		= "trascrizione";
	$strImage			= "immagine";
	$strNewPerson		= "una nuova persona";
	$strPedigree		= "Albero genealogico"; // MODIFICA 20120506
	$strToDetails		= "Dettagli"; // MODIFICA 20120506
	$strSurnameIndex	= "Indice dei Cognomi";
	$strTopSurnames		= "I 10 cognomi più frequenti"; // MODIFICA 20120506
        $strFounders            = "Capostipiti";	
	$strTracking		= "Seguire"; // MODIFICA 20120506
	$strTrack			= "Segui"; // MODIFICA 20120506
	$strThisPerson		= "questa persona";
	$strTrackSpeel		= "Usa il modulo sottostante per seguire questa scheda. Ti verrà inviata automaticamente una e-mail ogni volta che la scheda sarà aggionata"; // MODIFICA 20120506
	$strEmail			= "Email";
	$strSubscribe		= "iscriviti";
	$strUnSubscribe		= "cancellati";
	$strMonAccept		= "La tua richiesta di monitoraggio è stata accettata<br />Riceverai un messaggio ad ogni aggiornamento dei dati di questa persona.<br />"; // MODIFICA 20120506
	$strMonCease		= "La tua richiesta di fermare il monitoraggio è stata accettata<br />Non riceverai più notifiche di aggiornamenti.<br />"; // MODIFICA 20120506
	$strMonError		= "C'è stato un problema con la tua richiesta di monitoraggio.<br />Per favore contattare l'amministratore per un aiuto"; // MODIFICA 20120506
	$strMonRequest		= "La tua richiesta di monitoraggio di questa persona è stata ricevuta.<br />Riceverai una richiesta di conferma al tuo indirizzo.<br />"; // MODIFICA 20120506
	$strCeaseRequest	= "La tua richiesta di fermare il monitoraggio di questa persona è stata ricevuta.<br />Riceverai una richiesta di conferma al tuo indirizzo.<br />"; // MODIFICA 20120506
	$strAlreadyMon		= "Stai già monitorando questa persona.<br />"; // MODIFICA 20120506
	$strNotMon			= "Non stai monitorando questa persona.<br />"; // MODIFICA 20120506
	$strRandomImage	= "Immagine Casuale";
	$strMailTo			= "Invia Messaggio";
	$strSubject			= "Argomento"; // MODIFICA 20120506
	$strNoEmail			= "\"Devi inserire un indirizzo e-mail\"";
	$strEmailSent		= "La tua e-mail, è stata inviata al Webmaster.";
	$strExecute			= "Tempo di esecuzione";
	$strSeconds			= "secondi";
	$strStyle			= "Stile";
 // MODIFICA 20120506	
	$strPreferences		= "Preferenze";
	$strRecoverPwd		= "Recupera password";
	$strStop			= "stop";
	$strRememberMe		= "Ricordami";
	$strSuffix			= "Suffisso";
	$strLost			= "Hai dimenticato la password";
	$strSent			= "Ti è stata spedita una nuova password";
	$strMyLoggedIn		= "Collegato";
	$strAdminUser		= "Sei un <a href=\"admin.php\">amministratore</a>";
	$strMonitoring		= "Persone che stai monitorando";
	$strChangeStyle		= "Cambia lo stile";
	$strChangeEmail		= "Cambia il tuo indirizzo elettronico";
	$strGedCom			= "Gedcom";
        $strCompleteGedcom	= "Completa Gedcom";	
	$strCreateFamily	= "Registrazione di un nuovo familiare";
	$strCreatePerson	= "Registrazione di una nuova persona";

	$strEvent[0] = "Nascita";
	$strEvent[1] = "Battesimo";
	$strEvent[2] = "Morte";
	$strEvent[3] = "Funerale";
	$strEvent[4] = "Banns read";
	$strEvent[5] = "Matrimonio";
	$strEvent[6] = "Census";
	$strEvent[7] = "Altro";
	$strEvent[8] = "Immagine";
	$strEvent[9] = "Trascrizione";
	
	$strEventVerb = array($strBorn,"Battezzato/a",$strDied,"Sepolto/a",$strEvent[4],$strMarried,"Census","Altro", "Immagine", "Trascrizione");
 // FINE MODIFICA 20120506
//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 è stato aggiornato";
	$eTrackBodyTop		= "Questo è un messaggio automatico.  $1 a $2 è stato aggiornato.  Clicca quì sotto per vedere il record aggiornato\n\n";
	$eTrackBodyBottom	= "Questo messaggio è stato inviato perché hai precedentemente richiesto di monitorare questa persona.  Clicca quì sotto per rimuovere da solo questo monitoraggio\n\n"; // MODIFICA 20120506
	$eSubSubject		= "[phpmyfamily] richiesta monitoraggio";
	$eSubBody			= "Questo è un messaggio automatico.  Hai ricevuto questo messaggio perché hai scelto di monitorare il record di $1.  Per confermare la sottoscrizione, clicca il collegamente quì sotto nella prossime 24 ore.\n\n";
	$eUnSubBody			= "Questo è un messaggio automatico.  Hai ricevuto questo messaggio perché hai scelto di cessare di monitorare il record di $1.  Per confermare la cancellazione, clicca il collegamente quì sotto nella prossime 24 ore.\n\n";
	$eBBSubject			= "[phpmyfamily] Il Grande Fratello ha rilevato un cambiamento in $1"; // MODIFICA 20120506
	$eBBBottom			= "Questo messaggio è stato inviato perché la tua installazione ha il Grande Fratello attivato. Per favore vedi il file di configurazione se vuoi disattivarlo.\n\n"; // MODIFICA 20120506
	$ePwdSubject		= "[phpmyfamily] Nuova Password"; // MODIFICA 20120506
	$ePwdBody		= "Qualcuno, forse tu, ha richiesto una nuova password.  La tua coppia nome-utente/password ora è $1 \n\n"; // MODIFICA 20120506
	

//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	$err_listpeeps		= "Errore mostrando le persone nel database";
	$err_image_insert	= "Errore inserendo l'immagine nel database";
	$err_list_enums		= "Errore enumerando i tipi in colonna";
	$err_list_census	= "Errore mostrandi i censimenti disponibili";
	$err_keywords		= "Errore richiamando i nomi per parole chiave dal database";
	$err_changed		= "Errore richiamando lista delle ultime persone cambiate";
	$err_father			= "Errore richiamando i dettagli del padre dal database";
	$err_mother			= "Errore richiamando i dettagli della madre dal database";
	$err_spouse			= "Errore richiamando i dettagli della moglie dal database";
	$err_marriage		= "Errore richiamando i dettagli del matrimonio dal database";
	$err_census_ret		= "Errore richiamando i dettagli del censimento from database";
	$err_children		= "Errore richiamando i dettagli dei figli dal database";
	$err_siblings		= "Errore richiamando i dettagli sibling dal database";
	$err_transcript		= "Errore inserendo transcript nel database";
	$err_trans			= "Errore richiamando transcripts dal database";
	$err_detail			= "Errore inserendo dettagli della persona nel database";
	$err_census			= "Errore inserendo il censimento nel database";
	$err_logon			= "Errore loggandoti";
	$err_change			= "Errore controllando il cambio password";
	$err_pwd_incorrect	= "Errore - Fornita password non corretta";
	$err_pwd_match		= "Errore - La nuova password non combacia";
	$err_update			= "Errore aggiornando la nuova password";
	$err_pwd_success	= "Password aggiornata con successo";
	$err_image			= "Errore richiamando immagine dal database";
	$err_images			= "Errore richiamando immagini dal database";
	$err_person			= "Errore richiamando la persona dal database";
	$err_new_user		= "Errore inserendo il nuovo utente nel database";
	$err_user_exist		= "Errore - l'utente già esiste";
	$err_pwd			= "Errore richiamando la password dal database";
	$err_delete_user	= "Errore cancellando l'utente dal database";
	$err_users			= "Errore richiamando gli utenti dal database";
	$err_census_delete	= "Errore cancellando il censimento dal database";
	$err_marriage_delete= "Errore cancellando il matrimonio dal database";
	$err_trans_delete	= "Errore cancellando transcript dal database";
	$err_person_delete	= "Errore cancellando la persona dal database";
	$err_trans_file		= "Errore cancellando transcript file";
	$err_image_file		= "Errore cancellando il file dell'immagine";
	$err_child_update	= "Errore aggiornando i records dei figli";
	$err_person_update	= "Errore aggiornando i dettagli della persona";
	$err_marriage_insert= "Errore inserendo il matrimonio nel database";

	// eof
?>
