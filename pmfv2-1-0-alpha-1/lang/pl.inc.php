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

	$charset			= "ISO-8859-2";
	$clang				= "pl";
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

	$strOnFile			= "osób w bazie";
	$strSelect			= "Wybierz osobê";
	$strUnknown			= "nieznane";
	$strLoggedIn		= "Jeste zalogowany jako ";
	$strAdmin			= "admin";
	$strLoggedOut		= "Nie jeste¶ zalogowany";
	$strYes				= "Tak";
	$strNo				= "Nie";
	$strSubmit			= "Wy¶lij";
	$strReset			= "Wyczy¶æ";
	$strLogout			= "Wyloguj";
	$strHome			= "pocz±tek";
	$strEdit			= "edytuj";
	$strAdd				= "dodaj";
	$strDetails			= "Szczegu³y";
	$strBorn			= "Urodzony";
	$strCertified		= "Certyfikat";
	$strFather			= "Ojciec";
	$strRestricted		= "Zabezpieczone";
	$strDied			= "Umar³";
	$strMother			= "Matka";
	$strChildren		= "Dzieci";
	$strSiblings		= "Rodzeñstwo";
	$strMarried			= "¿onaty";
	$strInsert			= "dodaj";
	$strNewMarriage		= "nowe ma³¿eñstwo";
	$strNotes			= "Uwagi";
	$strGallery			= "Galeria zdjêæ";
	$strUpload			= "wgraj";
	$strNewImage		= "nowe rysunek";
	$strNoImages		= "Brak rysunków dostêpnych";
	$strCensusDetails	= "Szczegu³y spisu ludzi";
	$strNewCensus		= "nowy spis ludzi";
	$strNoInfo			= "Brak informacji dostêpnych";
	$strYear			= "Rok";
	$strAddress			= "Adres";
	$strCondition		= "Stan cywilny";
	$strOf				= "z";
	$strAge				= "Wiek";
	$strProfession		= "Zawód";
	$strBirthPlace		= "Miejsce urodzenia";
	$strDocTrans		= "Dokumenty transkryptu";
	$strNewTrans		= "nowy transkrypt";
	$strTitle			= "Tytu³";
	$strDesc			= "Opis";
	$strDate			= "Data";
	$strRightClick		= "Naci¶nij na tytu³ dokumentu w celu pobrania go. (Mo¿liwe, ¿e bêdzie potrzebne klikniêcie prawym przyciskiem myszki i wybranie 'Zapisz jako..' w programie Internet Explorer)";
	$strStats			= "Statystyka serwisu";
	$strArea			= "Obszar";
	$strNo				= "Numer";
	$strCensusRecs		= "Wpisy w spisie ludzi";
	$strImages			= "Rysunki";
	$strLast20			= "Ostatnie 20 osób aktualizowane";
	$strPerson			= "Osoba";
	$strUpdated			= "Aktualizowana";
	$strEditing			= "Edytowana";
	$strName			= "Nazwisko";
	$strDOB				= "Data urodzin";
	$strDateFmt			= "Proszê u¿ywaæ formatu YYYY-MM-DD";
	$strDOD				= "Data ¶mierci";
	$strCauseDeath		= "Powód ¶mierci";
	$strMarriage		= "Ma³¿eñstwo";
	$strSpouse			= "Ma³¿onek";
	$strDOM				= "Data ma³¿eñstwa";
	$strMarriagePlace	= "Miejsce o¿enku";
	$strCensus			= "Lista osób";
	$strSchedule 		= "Harmonogram";
	$strDragons			= "Tu bêd± smoki!";
	$strGender			= "P³eæ";
	$strMale			= "Mê¿czyzna";
	$strFemale			= "Kobieta";
	$strNewPassword		= "Nowe has³o";
	$strOldPassword		= "Stare has³o";
	$strReOldPassword	= "Wprowad¼ ponownie stare has³o";
	$strChange			= "Zmiana";
	$strPwdChange		= "Zmiana has³a";
	$strPwdChangeMsg	= "Proszê u¿ywaæ tego formularza w celu zmiany has³a.";
	$strLogin			= "login";
	$strUsername		= "U¿ytkownik";
	$strPassword		= "Has³o";
	$strRePassword		= "Wprowad¼ ponownie has³o";
	$strForbidden		= "Zabroniony";
	$strForbiddenMsg	= "Nie masz uprawnieñ do strona, któr± chcesz ogl±daæ.  Proszê nie poprawiaæ tego ¿±dania.  Proszê klikn±æ <a href=\"index.php\">tutaj</a> w celu kontynuacji.";
	$strDelete			= "usuñ";
	$strFUpload			= "Plik do wgrania na serwer";
	$strFTitle			= "Tytu³ pliku";
	$strFDesc			= "Opis pliku";
	$strFDate			= "Data pliku";
	$strIUpload			= "Rysunek do wgrania";
	$strISize			= "tylko JPEG (maksymalna wielko¶æ to 1MB)";
	$strITitle			= "Tytu³ rysunku";
	$strIDesc			= "Opis rysunku";
	$strIDate			= "Data rysunku";
	$strOn				= "po";
	$strAt				= "w";
	$strAdminFuncs		= "Funkcje administratorskie";
	$strAction			= "akcja";
	$strUserCreate		= "Dodaj nowego u¿ytkownika";
	$strCreate			= "Doaj";
	$strBack			= "Wstecz";
	$strToHome			= "do strony domowej.";
	$strNewMsg			= "Proszê sprawdziæ czy ta osoba ju¿ nie istnieje w bazie danych przed jej dodaniem!";
	$strIndex			= "Wszystkie szczegó³y dla ludzi urodzonych po $currentRequest->dispdate s± zabezpieczone przed ich identyfikacj±.  Je¿eli jeste¶ zarejestrowanym u¿ytkownikiem bêdziesz móg³ zobaczyæ te dane i edytowaæ wpis.  Ka¿dy mo¿e przegl±daæ odbezpieczone dane.  Je¿eli ktokolwiek pasuje do Twojego drzewa rodzinnego, proszê <a href=\"$1\">daj mi znaæ</a>";
	$strNote			= "Uwaga";
	$strFooter			= "Wy¶lij list do <a href=\"$1\">webmastera</a> w razie jakichkolwiek problemów.";
	$strPowered			= "Wspierane przez";
	$strPedigreeOf		= "Genealogia dla";
	$strBirths			= "Urodziny";
	$strAnniversary		= "Rocznice";
	$strUpcoming		= "Nadchodz±ce rocznice";
	$strMarriages		= "Ma³¿eñstwa";
	$strDeaths			= "¦mierci";
	$strConfirmDelete	= "\"Czy jeste¶ pewien, ¿e chcesz usun±æ sekcjê \\n'\" + year + \"' ?\"";
	$strTranscript		= "transkrypcja";
	$strImage			= "rysunek";
	$strDoubleDelete	= "\"Czu napewno chcesz USUN¡Æ t± osobê \\nTen proces jest NIEODWRACALNY!!\"";
	$strBirthCert		= "Certyfikat urodzin?";
	$strDeathCert		= "Certyfikat ¶mierci?";
	$strMarriageCert	= "Certyfikat ma³¿eñstwa?";
	$strNewPerson		= "now± osobê";
	$strPedigree		= "genealogia";
	$strToDetails		= "szczegó³y";
	$strSurnameIndex	= "Indeks nazwisk";
	$strTracking		= "¦ledzenie";
	$strTrack			= "¶led¼";
	$strThisPerson		= "t± osobê";
	$strTrackSpeel		= "U¿yj tego formularza w celu ¶ledzenia tej osoby.  Automatycznie otrzymasz email ka¿dorazowao gdy ten wpis zostanie zmieniony";
	$strEmail			= "Email";
	$strSubscribe		= "zapisz";
	$strUnSubscribe		= "wypisz";
	$strMonAccept		= "Twoje ¿±danie monitorowanie zosta³o zaakceptowane<br />Bêdziesz teraz otrzymywa³ listy email ka¿dorazowo gdy wpis tej osoby zostanie zmieniony.<br />";
	$strMonCease		= "Twoje ¿±danie zaprzestania monitorowania zosta³o zaakceptowane<br />Nie bêdziesz otrzymywa³ wiêcej listów email.<br />";
	$strMonError		= "Wyst±pi³ b³±d podczas rozpatrywania Twojego ¿±dania.<br />Prosimy o kontakt z administratorem serwisu w celu uzyskania pomocy";
	$strMonRequest		= "Twoje ¿±danie monitorowania osoby jest przetwarzane.<br />List email potwierdzaj±cy zosta³ wys³any na Twój adres email, powiniene¶ postêpowaæ zgodnie z instrukcjami zawartymi w li¶cie.<br />";
	$strCeaseRequest	= "Twoje ¿±danie zaprzestania monitorowania tej osoby jest przetwarzane.<br />List email potwierdzaj±cy zosta³ wys³any na Twój adres email, powiniene¶ postêpowaæ zgodnie z instrukcjami zawartymi w li¶cie.<br />";
	$strAlreadyMon		= "Ju¿ monitorujesz t± osobê.<br />Nie jest wymagana ¿adna akcja.<br />";
	$strNotMon			= "Nie monitorujesz tej osoby.<br />Nie jest wymagana ¿adna akcja.<br />";
	$strRandomImage		= "Losowy rysunek";
	$strMailTo			= "Wy¶lij wiadomo¶æ";
	$strSubject			= "Tytu³";
	$strNoEmail			= "\"Musisz podaæ adres email\"";
	$strEmailSent		= "Twója wiadomo¶æ zosta³a wys³ana do administratora.";
	$strExecute			= "Czas wykonywania";
	$strSeconds			= "sekund";
	$strStyle			= "Styl";
	$strPreferences		= "ustawienia";
	$strRecoverPwd		= "odzyskaj has³o";
	$strStop			= "przerwij";
	$strRememberMe		= "Zapamiêtaj mnie";
	$strSuffix			= "Przyrostek";
	$strLost			= "Zagubi³e¶ has³o";
	$strSent			= "Nowe has³o zosta³o wys³ane";
	$strMyLoggedIn		= "Zalogowany do phpmyfamily";
	$strAdminUser		= "Jeste¶ <a href=\"admin.php\">administratorem</a>";
	$strMonitoring		= "Osoby, które monitorujesz";
	$strChangeStyle		= "Zmieñ styl serwisu";
	$strChangeEmail		= "Zmieñ adres email";
	$strGedCom			= "gedcom";

//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 zosta³o zaktualizowane";
	$eTrackBodyTop		= "To jest automatyczna wiadomo¶æ.  $1 dnia $2 zosta³o zmienione przez $3.  Kliknij poni¿ej by sprawdziæ zmienione wpis\n\n";
	$eTrackBodyBottom	= "Ta wiadomo¶æ zosta³a wys³ana poniewa¿ uprzednio zapisa³e¶ siê do ¶ledzenia zmian wpisu dla tej osoby.  Naci¶nij poni¿szy odno¶nik w celu usuniêcia siê z tego monitorowania\n\n";
	$eSubSubject		= "[phpmyfamily] ¿±danie monitorowania";
	$eSubBody			= "To jest automatyczna wiadomo¶æ.  Otrzymujesz t± wiadomo¶æ poniewa¿ wybra³e¶ monitorowanie wpisów dla osoby $1.  W celu potwierdzenia monitorowania proszê klikn±æ poni¿szy odno¶nik w ci±gu najbli¿szych 24 godzin.\n\n";
	$eUnSubBody			= "To jest automatyczna wiadomo¶æ.  Otrzymujesz t± wiadomo¶æ poniewa¿ wybra³e¶ anulowanie monitorowania wpisów dla osoby $1.  W celu potwierdzenia anulowania monitorowania proszê klikn±æ poni¿szy odno¶nik w ci±gu najbli¿szych 24 godzin.\n\n";
	$eBBSubject			= "[phpmyfamily] Wielki brat zauwa¿y³ zmienê w $1";
	$eBBBottom			= "Ta wiadomo¶æ zosta³a wys³ana poniewa¿ instalacja phpmyfamily posiada w³±czonego Wielkiego brata.  Proszê sprawdziæ plik konfiguracyjny je¿eli chcesz wy³±czyæ t± opcjê.\n\n";
	$ePwdSubject		= "[phpmyfamily] Nowe has³o";
	$ePwdBody		= "Kto¶, najprawdopodobniej Ty, za¿±da³ nowe has³o dla phpmyfamily.  Twoje has³o to $1 \n\n";

//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	$err_listpeeps		= "B³±d podczas listowania ludzi z bazy danych";
	$err_image_insert	= "B³±d dodawania rysunku do bazy danych";
	$err_list_enums		= "B³±d enumeracji typów kolmn";
	$err_list_census	= "B³±d listowania dostêpnych spisów osób";
	$err_keywords		= "B³±d pobierania nazwisk dla s³ów kluczy z bazy danych";
	$err_changed		= "B³±d pobierania listy ostatnio zmienianych wpisów osób";
	$err_father			= "B³±d pobierania inforamcji o ojcu z bazy danych";
	$err_mother			= "B³±d pobierania inforamcji o matce z bazy danych";
	$err_spouse			= "B³±d pobierania inforamcji o ma³¿onku z bazy danych";
	$err_marriage		= "B³±d pobierania inforamcji o ma³¿eñstwie z bazy danych";
	$err_census_ret		= "B³±d pobierania inforamcji o spisie osób z bazy danych";
	$err_children		= "B³±d pobierania inforamcji o dzieciach z bazy danych";
	$err_siblings		= "B³±d pobierania inforamcji o rodzeñstwie z bazy danych";
	$err_transcript		= "B³±d dodawnia transkryptu do bazy danych";
	$err_trans			= "B³±d pobierania inforamcji o transkrypcie z bazy danych";
	$err_detail			= "B³±d dodawnia informacji o osobie do bazy danych";
	$err_census			= "B³±d dodawnia spisu osób do bazy danych";
	$err_logon			= "B³±d logowania";
	$err_change			= "B³±d sprawdzania zmiany has³a";
	$err_pwd_incorrect	= "B³±d - podano niepoprawne has³o";
	$err_pwd_match		= "B³±d - nowe has³a nie zgadzaj± siê";
	$err_update			= "B³±d aktualizacji has³a";
	$err_pwd_success	= "Has³o porawnie zmieniono";
	$err_image			= "B³±d pobierania rysunku z bazy danych";
	$err_images			= "B³±d pobierania rysunków z bazy danych";
	$err_person			= "B³±d pobierania osoby z bazy danych";
	$err_new_user		= "B³±d dodawania nowej osoby do bazy danych";
	$err_user_exist		= "B³±d - osoba ju¿ istnieje";
	$err_pwd			= "B³±d pobierania has³a z bazy danych";
	$err_delete_user	= "B³±d usuwania osoby z bazy danych";
	$err_users			= "B³±d pobierania osób z bazy danych";
	$err_census_delete	= "B³±d usuwania spisu osób z bazy danych";
	$err_marriage_delete= "B³±d usuwania ma³¿eñstwa z bazy danych";
	$err_trans_delete	= "B³±d usuwania transkryptu z bazy danych";
	$err_person_delete	= "B³±d usuwania osoby z bazy danych";
	$err_trans_file		= "B³±d usuwania pliku transkryptu";
	$err_image_file		= "B³±d usuwania pliku rysunku";
	$err_child_update	= "B³±d aktualizacji wpisów dla dzieci";
	$err_person_update	= "B³±d aktualizacji informacji o osobie";
	$err_marriage_insert= "B³±d dodawania ma³¿eñstwa do bazy danych";

	// eof
?>
