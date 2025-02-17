<?php
session_start();

if (isset($_SESSION["id"]) && $_SESSION["login"]){
    header("Location: index.php");
}


require_once ("includes/config-bdd.php");
require_once ("includes/constantes.php");
require_once ("php/functions-DB.php");
require_once ("php/functions_query.php");
require_once ("php/functions_structure.php");

include ("static/header.php");
include ("static/navbar.php");
include ("static/footer.php");


head("Connexion");
echo "<body>";
navbar("Connexion");


formulaire();


footer();


?>