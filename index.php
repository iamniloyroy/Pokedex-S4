<?php
session_start();


// if (isset($_SESSION["connected"]) && $_SESSION["login"]){
//     echo $_SESSION["login"]." est connecté";
//     echo "<br>";
// }


require_once("includes/config-bdd.php");
require_once("includes/constantes.php");
require_once("php/functions-DB.php");
require_once("php/functions_query.php");
require_once("php/functions_structure.php");

include("static/header.php");
include("static/navbar.php");
include("static/footer.php");

//affichage des erreurs côté PHP et côté MYSQLI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


head("Acceuil");
?>
<body>
<?php
navbar("Acceuil");

$mysqli=connectionDB();

// $requete="SELECT numero,nom FROM pokemon;";
// $result=readDB($mysqli,$requete);
// foreach($result as $pokemon){
//     echo "<p>".$pokemon['numero']." - ".$pokemon['nom']."</p>";
// }

$pokedex=getPokedex($mysqli);

// echo "<pre>";
// print_r($pokedex);
// echo "</pre>";

displayPokedex($mysqli,$pokedex);

footer();

closeDB($mysqli);
?>
</body>