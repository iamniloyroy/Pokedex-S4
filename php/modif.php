<?php

session_start();

require_once ("../includes/config-bdd.php");
require_once ("../includes/constantes.php");
require_once ("functions-DB.php");
require_once ("functions_query.php");

if (isset($_POST['pokemon']) && isset($_SESSION['id'])) {
    $idDresseur = $_SESSION['id'];
    $idDresseur = strval($idDresseur);
    $idPokemon = $_POST['pokemon'];
    $idPokemon = strval($idPokemon);
    $nbVue = $_POST['nbVue'];
    $nbAttrape = $_POST['nbAttrape'];

    $mysqli = connectionDB();

    $checkPokedex = checkPokedex($mysqli, $idDresseur, $idPokemon);
    if ($checkPokedex) {
        $requete = "UPDATE pokedex SET nbVue = $nbVue, nbAttrape = $nbAttrape WHERE id_pokemon = $idPokemon AND id_dresseur = $idDresseur;";
        $result = writeDB($mysqli, $requete);
    } else {
        $requete = "INSERT INTO pokedex (id_dresseur, id_pokemon, nbVue, nbAttrape) VALUES ($idDresseur, $idPokemon, $nbVue, $nbAttrape);";
        $result = writeDB($mysqli, $requete);
    }
    header("Location: ../pokemon.php?numero=$idPokemon");

}

?>