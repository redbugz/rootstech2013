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
	
	//Spanish translation by Miguel Perez Subias <mps@aui.es>

//=====================================================================================================================

//=====================================================================================================================
//  global definitions
//=====================================================================================================================

	$charset			= "ISO-8859-1";
	$clang				= "es";
	$dir				= "ltr";
	$datefmt 			= "'%d/%m/%Y'";
	// flags are from http://flags.sourceforge.net
	// I can't find a copyrigh to credit
	// but I'm sure somebody has it
	$flag				= "images/es.gif";

//=====================================================================================================================
//=====================================================================================================================
	$currentRequest->setDateFormat($datefmt);

//=====================================================================================================================
// strings for translation
//=====================================================================================================================

	$strOnFile			= "personas en el registro";
	$strSelect			= "Seleccionar persona";
	$strUnknown			= "desconocido";
	$strLoggedIn			= "Has entrado como ";
	$strAdmin			= "administrados";
	$strLoggedOut			= "No has entrado (login): ";
	$strYes				= "Si";
	$strNo				= "No";
	$strSubmit			= "Actualizar";
	$strReset			= "Borrar";
	$strLogout			= "Salir";
	$strHome			= "Pagina de inicio";
	$strEdit			= "Editar";
	$strAdd				= "Añadir";
	$strDetails			= "Detalles";
	$strBorn			= "Nacido";
	$strCertified		= "Certificado";
	$strFather			= "Padre";
	$strRestricted		= "Restringido";
	$strDied			= "Fallecido";
	$strMother			= "Madre";
	$strChildren		= "Hijos";
	$strSiblings		= "Hermanos";
	$strMarried			= "Casado";
	$strInsert			= "Añadir";
	$strNewMarriage		= "nuevo matrimonio";
	$strNotes			= "Notas, comentarios";
	$strGallery			= "Galeria de imagenes";
	$strUpload			= "Cargar una imagen o un  documento";
	$strNewImage		= "Nueva imagen";
	$strNoImages		= "No hay imagenes disponibles";
	$strCensusDetails	= "Detalle del censo";
	$strNewCensus		= "nuevo censo";
	$strNoInfo			= "No hay informacion disponible";
	$strYear			= "Año";
	$strAddress			= "Dirección";
	$strCondition		= "Condicion";
	$strOf				= "en";
	$strAge				= "Edad";
	$strProfession		= "Profesion";
	$strBirthPlace		= "Lugar de nacimiento";
	$strDocTrans		= "Documentos aportados";
	$strNewTrans		= "Nuevo documento";
	$strTitle			= "Titulo";
	$strDesc			= "Descripcion";
	$strDate			= "Fecha";
	$strRightClick		= "Pulsa en el titulo del documento para descargarlo. (Necesita hacer click &amp; Salvar como.. en Internet Explorer)";
	$strStats			= "Estadísticas";
	$strArea			= "Area";
	$strNo				= "Numero";
	$strCensusRecs			= "Personas censadas";
	$strImages			= "Imagenes";
	$strLast20			= "Ultimas 20 Personas registradas";
	$strPerson			= "Persona";
	$strUpdated			= "Registrada";
	$strEditing			= "Editando";
	$strName			= "Nombre";
	$strDOB				= "Fecha de nacimiento";
	$strDateFmt			= "Utiliza este formato para la fecha DD-MM-AAAA";
	$strDOD				= "Fecha del fallecimiento";
	$strCauseDeath		= "Causa del fallecimiento";
	$strMarriage		= "Matrimonio";
	$strSpouse			= "Esposa";
	$strDOM				= "Fecha del Matrimonio";
	$strMarriagePlace	= "Lugar del Matrimonio";
	$strCensus			= "Censo";
	$strSchedule 		= "Schedule";
	$strDragons			= "Here be dragons!";
	$strGender			= "Sexo";
	$strMale			= "Hombre";
	$strFemale			= "Mujer";
	$strNewPassword		= "Nueva Clave de acceso";
	$strOldPassword		= "Clave anterior de acceso";
	$strReOldPassword	= "Teclear de nuevo la clave anterior ";
	$strChange			= "Cambiar";
	$strPwdChange		= "Cambio de clave";
	$strPwdChangeMsg	= "Utiliza este formulario para cambiar la clave de acceso.";
	$strLogin			= "Entrar";
	$strUsername		= "Usuario";
	$strPassword		= "Clave";
	$strRePassword		= "Teclea de nuevo la Clave de acceso";
	$strForbidden		= "Acceso protegido";
	$strForbiddenMsg	= "No tienes acceso al registro que has solicitado por motivos de privacidad.  Pulsa <a href=\"index.php\">aquí</a> para continuar.";
	$strDelete			= "borrar";
	$strFUpload			= "Fichero a cargar";
	$strFTitle			= "Titulo para este fichero";
	$strFDesc			= "Descripción del Fichero";
	$strFDate			= "Fecha del Fichero";
	$strIUpload			= "Imagen a cargar";
	$strISize			= "solo JPEG (tamaño max. 1MB)";
	$strITitle			= "Titulo de la Imagen";
	$strIDesc			= "Descripción de la imagen";
	$strIDate			= "Fecha de la imagen";
	$strOn				= "en";
	$strAt				= "de";
	$strAdminFuncs		= "Functiones de Administrador";
	$strAction			= "accion";
	$strUserCreate		= "Crear un usuario nuevo";
	$strCreate			= "Crear";
	$strBack			= "Volver atras";
	$strToHome			= "a la página inicial.";
	$strNewMsg			= "IMPORTANTE: Comprueba por favor que la persona no existe previamente en la base de datos antes de crear un nuevo registro!";
	$strIndex			= "Los detalles de las personas nacidas despues de $currentRequest->dispdate estan restringidas para proteger su intimidad. 
	                                   Si piensas que hay algun error o quieres proteger algun registro en particular, <a href=\"$1\">haznoslo saber</a>";
	$strNote			= "Nota";
	$strFooter			= "Envía un e-mail a<a href=\"$1\">webmaster</a> si tienes alguna duda o problema.";
	$strPowered			= "Este programa es";
	$strPedigreeOf		= "Arbol genealogico de";
	$strBirths			= "Nacimientos";
	$strAnniversary		= "Aniversarios";
	$strUpcoming		= "Aniversarios cercanos";
	$strMarriages		= "Matrimonios";
	$strDeaths			= "Defunciones";
	$strConfirmDelete	= "\"Estas seguro que quieres borrar la seccion del \\n'\" + year + \"' \" + section +\"?\"";
	$strTranscript		= "transcript";
	$strImage			= "imagen";
	$strDoubleDelete	= "\"¿Estás realmente seguro de que desea ELIMINAR esta persona \\nEste proceso es IRREVERSIBLE!!"";
	$strBirthCert		= "¿Nacimiento Certificado?";
	$strDeathCert		= "¿Defunción  Certificada?";
	$strMarriageCert	= "¿Matrimonio  Certificado?";
	$strNewPerson		= "un registro de persona nuevo";
	$strPedigree		= "arbol gen.";
	$strToDetails		= "para detalles";
	$strSurnameIndex	= "Indice de nombres";
	$strTracking		= "Mantenerme informado de este registro";
	$strTrack			= "infomarme";
	$strThisPerson		= "esta persona";
	$strTrackSpeel		= "Utiliza este formuario si quieres recibir información cada vez que haya un cambio en el registro de esta persona";
	$strEmail			= "E-mail";
	$strSubscribe		= "subscribir";
	$strUnSubscribe		= "cancelar suscripción";
	$strMonAccept		= "Petición aceptada<br />Recibiras un email cada vez que el registro de esta persona ambie.<br />";
	$strMonCease		= "Petición aceptada para NO recibir<br />màs email de este registro.<br />";
	$strMonError		= "Hay un problema con su solicitud.<br />contacta con el administrador del web";
	$strMonRequest		= "Petición procesada <br />Un correo con instrucciones para confirmar tu suscripción se ha enviado a tu email.<br />";
	$strCeaseRequest	= "Petición de cancelación para NO recibir más correos procesada.<br />Un correo con instrucciones para confirmar tu suscripción se ha enviado a tu email.<br />";
	$strAlreadyMon		= "Ya estas suscrito para recibir información de esta persona.<br />.<br />";
	$strNotMon			= "No estas suscrito para recibir información de esta persona.<br /><br />";
	$strRandomImage		= "Imagen al azar";
	$strMailTo			= "Enviar mensaje";
	$strSubject			= "Asunto";
	$strNoEmail			= "\"Debes dar una direccion de e-mail\"";
	$strEmailSent		= "Su e-mail se ha enviado al administrador del web.";
	$strExecute			= "Tiempo de ejecución";
	$strSeconds			= "segundos";

//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 ha sidoactualizado";
	$eTrackBodyTop		= "Mensaje automático.La información en el registro de:  $1 de $2 ha cambiado. \n Sigue este enlace para ver el registro: \n";
	$eTrackBodyBottom	= "Este mensaje se lo enviamos desde Quinto de ebro.com- Genealogía de Familias.\n Siga este enlace si quiere cancelar y NO recibir más información de este registro\n\n";
	$eSubSubject		= "[Familias y Genealogías de Quinto - Zaragoza - Spain] informacion de seguimiento";
	$eSubBody		= "Mensaje automático que se envia porque has solicitado que te informemos cuando se produzcan cambios en el registro personal de $1.\nPara confirmar la suscripción, simplemente haz click en el siguiente enlace en las proximas 24 horas:\n";
	$eUnSubBody		= "Mensaje automático que se envia porque has cancelado la recepción de información de esta persona $1.  Para confirmar la cancellation, simplemente haz click en el siguiente enlace en las proximas 24 horas:\n";

//=====================================================================================================================
//  error definitions
//=====================================================================================================================
//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	
	$err_listpeeps		= "Error listando personas en la base de datos";
	$err_image_insert	= "Error insertando imagenes en la base de datos";
	$err_list_enums		= "Error enumerando los tipos en las columnas";
	$err_list_census	= "Error listando censo disponible";
	$err_keywords		= "Error buscando nombres para las claves en la base de datos";
	$err_changed		= "Error buscando listado de las personas con cambios";
	$err_father			= "Error buscando detalles de padres en la base de datos";
	$err_mother			= "Error buscando detalles de madres en la base de datos";
	$err_spouse			= "Error buscando detalles de esposos en la base de datos";
	$err_matrimonio		= "Error buscando detalles de matrimonios en la base de datos";
	$err_census_ret		= "Error buscando detalles del censos en la base de datos";
	$err_children		= "Error buscando detalles de hijos en la base de datos";
	$err_siblings		= "Error buscando detalles de hermanos en la base de datos";
	$err_transcript		= "Error insertando documento en database";
	$err_trans			= "Error buscando documentos en la base de datos";
	$err_detail			= "Error insertando detalles de persona en la base de datos";
	$err_census			= "Error insertando censo en la base de datos";
	$err_logon			= "Error al entrar";
	$err_change			= "Error al comprobar el cambio de Clave";
	$err_pwd_incorrect	= "Error - Clave tecleada no es correcta";
	$err_pwd_match		= "Error - Nueva clave no coincide con la anteriormente tecleada";
	$err_update			= "Error actualizando la clave nueva";
	$err_pwd_success	= "Clave de acceso actualizada correctamente";
	$err_image			= "Error buscando imagen en la base de datos";
	$err_images			= "Error buscando imagenes en la base de datos";
	$err_person			= "Error buscando persona en la base de datos";
	$err_new_user		= "Error insertando nuevo usuario en la base de datos";
	$err_user_exist		= "Error - este usuario ya existe";
	$err_pwd			= "Error buscando Clave de acceso en la base de datos";
	$err_delete_user	= "Error borrando usuario en la base de datos";
	$err_users			= "Error buscando usuarios en la base de datos";
	$err_census_delete	= "Error borrando census en la base de datos";
	$err_marriage_delete= "Error borrando matrimonio en la base de datos";
	$err_trans_delete	= "Error borrando documento en la base de datos";
	$err_person_delete	= "Error borrando persona en la base de datos";
	$err_trans_file		= "Error borrando fichero con documento";
	$err_image_file		= "Error borrando imagen";
	$err_child_update	= "Error actualizando registro de hijos";
	$err_person_update	= "Error actualizando detalles de la persona";
	$err_marriage_insert= "Error insertando matrimonio en la base de datos";


	// eof
	// eof
?>
