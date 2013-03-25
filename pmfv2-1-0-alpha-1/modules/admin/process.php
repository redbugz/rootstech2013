<?php
set_include_path("../..");
include_once "modules/db/DAOFactory.php";

if ($_SESSION["admin"] == 0) {
	die(include "inc/forbidden.inc.php");
}

$dao = getAdminDAO();

$c = new Config();
$c->setFromPost();
if ($dao->updateConfig($c)) {
	$config = Config::getInstance();
	$config->setupConfig();
}
header('Location: ../../admin.php');

?>
