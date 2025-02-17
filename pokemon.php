<?php
session_start();


require_once("includes/config-bdd.php");
require_once("includes/constantes.php");
require_once("php/functions-DB.php");
require_once("php/functions_query.php");
require_once("php/functions_structure.php");

include("static/header.php");
include("static/navbar.php");
include("static/footer.php");

if (isset($_GET['numero'])) {
    $numero = $_GET['numero'];

    head("Pokemon");
    echo "<body>";
    navbar("Pokemon");
    $mysqli = connectionDB();
    
    $id = getIdPokemon($mysqli, $numero);
    $pokemonProfile = getPokemonProfile($mysqli, $id);
    $pokemonTypes = getTypes($mysqli, $id);
    $evolutions = getEvolution($mysqli, $id);
    $attacks = getAttacks($mysqli, $id);
    $pokemonImages = getPokemonImage($mysqli, $id);
    if (isset($_SESSION['id'])) {
    $vuOuAttrape = pokemonVuOuAttrape($mysqli, $_SESSION['id'], $id);
    }
    else {
        $vuOuAttrape = array();
    }
    displayPokemon($id, $pokemonImages, $pokemonProfile, $pokemonTypes, $evolutions, $attacks, $vuOuAttrape, $mysqli);




    footer();

    closeDB($mysqli);

} else {
    header("Location: index.php");
}

?>