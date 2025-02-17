<?php
session_start();



require_once ("includes/config-bdd.php");
require_once ("includes/constantes.php");
require_once ("php/functions-DB.php");
require_once ("php/functions_query.php");
require_once ("php/functions_structure.php");

include ("static/header.php");
include ("static/navbar.php");
include ("static/footer.php");


head("Modification");
echo "<body>";
navbar("Modification");
$mysqli=connectionDB();
modificationFormulaire($mysqli);

closeDB($mysqli);
footer();


?>