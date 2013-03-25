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
	
	// Translation by Patrice Levesque

//=====================================================================================================================

//=====================================================================================================================
//  global definitions
//=====================================================================================================================

	$charset			= "UTF-8";
	$clang				= "fr";
	$dir				= "ltr";
	$datefmt 			= "'%d/%m/%Y'";
	// flags are from http://flags.sourceforge.net
	// I can't find a copyrigh to credit
	// but I'm sure somebody has it
	$flag				= "images/fr.gif";

//=====================================================================================================================
//=====================================================================================================================
	$currentRequest->setDateFormat($datefmt);

//=====================================================================================================================
// strings for translation
//=====================================================================================================================

    $strAncestors           = "Ancêstres";  
    $strDescendants         = "Decendants";     
    $strLivingPerson        = "Personne vivante"; 
    $strDeceasedPerson      = "Personne décès";    // FR
	$strOnFile			= "individus répertoriés";
	$strSelect			= "Choisir un individu";
	$strUnknown			= "inconnu";
	$strLoggedIn		= "Vous êtes authentifié sous ";
	$strAdmin			= "admin";
	$strLoggedOut		= "Vous n'êtes pas authentifié: ";
	$strYes				= "Oui";
	$strNo				= "Non";
	$strSubmit			= "Soumettre";
	$strReset			= "Réinitialiser";
	$strLogout			= "Sortie";
	$strHome			= "Départ";
	$strEdit			= "Modifier";
	$strAdd				= "Ajouter";
	$strDetails			= "Détails";
	$strBorn			= "Né(e)";
	$strCertified		= "Certifié";
	$strFather			= "Père";
	$strRestricted		= "<a href=\"restricted.php\">Privé</a>";
	$strDied			= "Décédé(e)";
	$strMother			= "Mère";
	$strChildren		= "Enfants";
	$strSiblings		= "Frères et soeurs";
	$strMarried			= "Marié(e)";
	$strInsert			= "Insérer";
	$strNewMarriage		= "nouveau mariage";
	$strNotes			= "Notes";
	$strGallery			= "Galerie d'images";
	$strUpload			= "Téléverser";
	$strNewImage		= "nouvelle image";
	$strNoImages		= "Aucune image disponible";
	$strCensusDetails	= "Détails de recensement";
	$strNewCensus		= "Nouveau recensement";
	$strNoInfo			= "Aucune information disponible";
	$strYear			= "Année";
	$strAddress			= "Adresse";
	$strCondition		= "Condition";
	$strOf				= "de";
	$strAge				= "Âge";
	$strProfession		= "Profession";
	$strBirthPlace		= "Lieu de naissance";
	$strDocTrans		= "Transcriptions de documents";
	$strNewTrans		= "nouvelle transcription";
	$strTitle			= "Titre";
	$strDesc			= "Description";
	$strDate			= "Date";
	$strRightClick		= "Cliquer sur le titre du document pour télécharger (Cliquer du bouton de droite &#38; Enregistrer sous... avec in Internet Explorer)";
	$strStats			= "Statistiques du site";
	$strArea			= "Zone";
	$strNo				= "Nombre";
	$strCensusRecs		= "Recensements";
	$strImages			= "Images";
	$strLast20			= "20 derniers individus mis à jour";
	$strPerson			= "Individu";
	$strUpdated			= "Mis à jour";
	$strEditing			= "Édition";
	$strName			= "Nom";
	$strDOB				= "Date de naissance";
	$strDateFmt			= "Utiliser le format AAAA-MM-JJ";
	$strDOD				= "Date de décès";
	$strCauseDeath		= "Cause du décès";
	$strMarriage		= "Mariage";
	$strSpouse			= "Époux(se)";
	$strDOM				= "Date du mariage";
	$strMarriagePlace	= "Lieu du mariage";
	$strCensus			= "Recensement";
	$strSchedule 		= "Horaire";
	$strDragons			= "Des dragons!";
	$strGender			= "Sexe";
	$strMale			= "Male";
	$strFemale			= "Femelle";
	$strNewPassword		= "Nouveau mot de passe";
	$strOldPassword		= "Ancien mot de passe";
	$strReOldPassword	= "Réinscrire l'ancien mot de passe";
	$strChange			= "Changer";
	$strPwdChange		= "Changement de mot de passe";
	$strPwdChangeMsg	= "Remplir ce formulaire pour changer de mot de passe.";
	$strLogin			= "Authentification";
	$strUsername		= "Nom d'utilisateur";
	$strPassword		= "Mot de passe";
	$strRePassword		= "Réinscrire le mot de passe";
	$strForbidden		= "Interdit";
	$strForbiddenMsg	= "Vous n'avez pas de permissions suffisantes pour voir la page demandée.  Cliquer <a href=\"index.php\">ici</a> pour poursuivre.";
	$strDelete			= "Effacer";
	$strFUpload			= "Fichier à téléverser";
	$strFTitle			= "Titre du fichier";
	$strFDesc			= "Description du fichier";
	$strFDate			= "Date du fichier";
	$strIUpload			= "Image à téléverser";
	$strISize			= "JPEG seulement (taille max 1MB)";
	$strITitle			= "Titre de l'image";
	$strIDesc			= "Description de l'image";
	$strIDate			= "Date de l'image";
	$strOn				= "le";
	$strAt				= "à";
	$strAdminFuncs		= "Fonctions d'administrateur";
	$strAction			= "action";
	$strUserCreate		= "Créer un nouvel usager";
	$strCreate			= "Créer";
	$strBack			= "Retour";
	$strToHome			= "au départ.";
	$strNewMsg			= "Assurez-vous que l'individu n'existe pas déjà dans la base de données!";
	$strIndex			= "Tous les détails pour les individus nées après $currentRequest->dispdate sont privées afin de protéger les identités.  Si vous êtes enregistré(e) vous pourrez voir et modifier les enregistrements.  Si vous croyez que votre arbre généalogique correspond à celui-ci, <a href=\"$1\">laissez-moi savoir</a>.";
	$strNote			= "Note";
	$strFooter			= "Communiquez avec le <a href=\"$1\">webmestre</a> s'il y a problème.";
	$strPowered			= "Propulsé par";
	$strPedigreeOf		= "Arbre de";
	$strBirths			= "Naissances";
	$strAnniversary		= "Anniversaire";
	$strUpcoming		= "Anniversaires à venir";
	$strMarriages		= "Mariages";
	$strDeaths			= "Décès";
	$strConfirmDelete	= "\"\\u00cates-vous certain de vouloir effacer\\n'\" + year + \"' \" + section +\"?\"";
	$strTranscript		= "transcription";
	$strImage			= "image";
	$strDoubleDelete	= "\"\\u00cates-vous vraiment certain de vouloir EFFACER cet individu\\nCe processus est IRR\\u00c9VERSIBLE!!\"";
	$strBirthCert		= "Naissance certifiée?";
	$strDeathCert		= "Décès certifié?";
	$strMarriageCert	= "Mariage certifié?";
	$strNewPerson		= "un individu";
	$strPedigree		= "Arbre";
	$strToDetails		= "détails";
	$strSurnameIndex	= "Index des noms de famille";
	$strTracking		= "de suivi de";
	$strTrack			= "Suivre";
	$strThisPerson		= "cet individu";
	$strTrackSpeel		= "Utiliser le formulaire plus bas pour suivre cet individu.  Vous recevrez un courriel à chaque fois que la fiche sera mise à jour";
	$strEmail			= "Courriel";
	$strSubscribe		= "s'inscrire";
	$strUnSubscribe		= "se désincrire";
	$strMonAccept		= "Votre requête de suivi a été acceptée.<br />Vous recevrez un courriel à chaque mise à jour de la fiche de cet individu.<br />";
	$strMonCease		= "Votre requête de cesser le suivi a été acceptée.<br />Vous ne recevrez plus de courriels.<br />";
    $strMonError		= "Un problème avec votre requête de suivi est survenu.<br />Contacter l'administrateur du site pour assistance";
	$strMonRequest		= "Votre reqwuête de suivi pour cet individu est en traitement.<br />Un courriel a été envoyé à votre adresse et vous devrez suivre les instructions qui y sont inscrites.<br />";
    $strCeaseRequest	= "Votre reqête de cessation de suivi de cet individu est en traitement.<br />Un courriel a été envoyé à votre adresse et vous devrez suivre les instructions qui y sont inscrites.<br />";
	$strAlreadyMon		= "Vous suivez déjà cet individu.<br />Aucune action entreprise.<br />";
	$strNotMon			= "Vous ne suivez pas encore cet individu.<br />Aucune action entreprise.<br />";
	$strRandomImage		= "Image au hasard";
	$strMailTo			= "Envoyer un message";
	$strSubject			= "Sujet";
	$strNoEmail			= "\"Vous devez fournir une adresse de courriel\"";
	$strEmailSent		= "Votre courriel a été envoyé au webmestre.";
	$strExecute			= "Temps d'exécution";
	$strSeconds			= "secondes";
	$strStyle			= "Style";
	$strPreferences		= "Préférences";
	$strRecoverPwd		= "Retrouver mot de passe";
	$strStop			= "Arrêt";
	$strRememberMe		= "Se rappeller des informations";
	$strSuffix			= "Suffixe";
	$strLost			= "Vous avez perdu votre mot de passe";
	$strSent			= "Un nouveau mot de passe a été envoyé";
	$strMyLoggedIn		= "Authentifié dans phpmyfamily";
	$strAdminUser		= "Vous êtes un <a href=\"admin.php\">administrateur</a>";
	$strMonitoring		= "Individus que vous surveillez";
	$strChangeStyle		= "Changer votre style";
	$strChangeEmail		= "Changer adresse de courriel";
	$strGedCom			= "gedcom";

//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 a été mis à jour";
	$eTrackBodyTop		= "Ceci est un message automatique.  $1 à $2 a été alteré.  Cliquer ci-dessous pour voir la fiche modifiée\n\n";
	$eTrackBodyBottom	= "Ce message a été envoyé car vous avez demandé le suivi pour cet individu.  Cliquez plus bas pour vous retirer de ce suivi.\n\n";
	$eSubSubject		= "[phpmyfamily] requête de suivi";
	$eSubBody			= "Ceci est un message automatique.  Vous recevez ce message parce que vous avez choisi de suivre la fiche de $1.  Pour confirmer cette inscription, cliquez le lien plus bas d'ici les prochaines 24 heures.\n\n";
	$eUnSubBody			= "Ceci est un message automatique.  Vous recevez ce message parce que vous avez choisi de ne plus suivre la fichie de $1.  Pour confirmer cette désinscription, cliquez le lien plus bas d'ici les prochaines 24 heures.\n\n";
	$eBBSubject			= "[phpmyfamily] Big Brother a détecté une modification pour $1";
	$eBBBottom			= "Vous recevez ce message parce que votre installation de phpmyfamily a l'option Bog Brother d'allumée.  Voir le fichier de configuration si vous désirez cesser ces messages.\n\n";
	$ePwdSubject		= "[phpmyfamily] Nouveau mot de passe";
	$ePwdBody		= "Quelqu'un, vous on le souhaite, a demandé un nouveau mot de passe pour phpmyfamily.  Votre mot de passe est maintenant $1 \n\n";

//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	$err_listpeeps		= "Erreur lors du listage des individus dans la base de données";
	$err_image_insert	= "Erreur lors de l'insertion de l'image dans la base de données";
	$err_list_enums		= "Erreur lors de l'énumération des types sur la colonne";
	$err_list_census	= "Erreur lors du listage des recensements disponibles";
	$err_keywords		= "Erreur lors de la récupération dans la base de données des noms pour mots-clefs";
	$err_changed		= "Erreur lors de la récupération de la liste des derniers individus modifiés";
	$err_father			= "Erreur lors de la récupération des détails du père";
	$err_mother			= "Erreur lors de la récupération des détails de la mère";
	$err_spouse			= "Erreur lors de la récupération des détails de l'époux";
	$err_marriage		= "Erreur lors de la récupération des détails du mariage";
	$err_census_ret		= "Erreur lors de la récupération des détails du recensement";
	$err_children		= "Erreur lors de la récupération des détails des enfants";
	$err_siblings		= "Erreur lors de la récupération des détails des frères et soeurs";
	$err_transcript		= "Erreur lors de l'insertion de transcription dans la base de données";
	$err_trans			= "Erreur lors de la récupération des transcriptions";
	$err_detail			= "Erreur lors de l'insertion des détails de l'individu dans la base de données";
	$err_census			= "Erreur lors de l'insertion du recensement dans la base de données";
	$err_logon			= "Erreur d'authentification";
	$err_change			= "Erreur lors du changement de mot de passe";
	$err_pwd_incorrect	= "Erreur - Mot de passe incorrect";
	$err_pwd_match		= "Erreur - Les deux mots de passe ne concordent pas";
	$err_update			= "Erreur lors de la mise à jour du nouveau mot de passe";
	$err_pwd_success	= "Mot de passe mis à jour avec succès";
	$err_image			= "Erreur lors de la récupération de l'image dans la base de données";
	$err_images			= "Erreur lors de la récupération des images dans la base de données";
	$err_person			= "Erreur lors de la récupération de l'invididu dans la base de données";
	$err_new_user		= "Erreur lors de l'insertion du nouvel usager dans la base de données";
	$err_user_exist		= "Erreur - l'usager existe déjà";
	$err_pwd			= "Erreur lors de la récupération du mot de passe";
	$err_delete_user	= "Erreur lors de l'effacement de l'usager";
	$err_users			= "Erreur lors de la récupération des usagers dans la base de données";
	$err_census_delete	= "Erreur lors de l'effacement du recensement";
	$err_marriage_delete= "Erreur lors de l'effacement du mariage";
	$err_trans_delete	= "Erreur lors de l'effacement de la transcription";
	$err_person_delete	= "Erreur lors de l'effacement de l'individu";
	$err_trans_file		= "Erreur lors de l'effacement du fichier de transcription";
	$err_image_file		= "Erreur lors de l'effacement du fichier image";
	$err_child_update	= "Erreur lors de la mise à jour des fiches des enfants";
	$err_person_update	= "Erreur lors de la mise à jour des détails d'individus";
	$err_marriage_insert= "Erreur lors de l'insertion du mariage dans la base de données";

	// eof
?>
