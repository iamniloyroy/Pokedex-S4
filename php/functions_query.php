<?php


function getPokedex($mysqli)
{
    $requete = "SELECT * FROM pokemon;";
    $result = readDB($mysqli, $requete);
    return $result;
}


function getIdPokemon($mysqli, $numero)
{
    $sqlIdPokemon = "SELECT id_pokemon FROM pokemon WHERE numero = $numero";
    $resultIdPokemon = readDB($mysqli, $sqlIdPokemon);
    return $resultIdPokemon[0]['id_pokemon'];
}

function getPokemonProfile($mysqli, $id)
{
    $sqlPokemonProfil = "SELECT nom,numero,description FROM pokemon WHERE pokemon.id_pokemon = $id";
    $resultPokemonProfil = readDB($mysqli, $sqlPokemonProfil);
    return $resultPokemonProfil[0];
}
function getTypes($mysqli, $id)
{
    $sqlTypesPokemon = "SELECT libelle as type FROM type INNER JOIN esttype ON type.id_type=esttype.id_type WHERE esttype.id_pokemon = $id";
    $resultTypesPokemon = readDB($mysqli, $sqlTypesPokemon);
    $types = [];
    foreach ($resultTypesPokemon as $type) {
        $types[] = [
            'type' => $type['type'],
            'image' => "images/types/Miniature_Type_{$type['type']}_EV.png",
        ];
    }
    return $types;
}

function getPokemonImage($mysqli, $id)
{
    $sqlImagePokemon = "SELECT chemin FROM image INNER JOIN pokemon on pokemon.id_pokemon=image.id_pokemon WHERE pokemon.id_pokemon = $id";
    $resultImagePokemon = readDB($mysqli, $sqlImagePokemon);
    return array("image" => $resultImagePokemon[0]['chemin'],
"imageSugimori" => "images/pokemon_sugimori/{$id}.png",
"imageShiny" => "images/pokemon_sugimori_shiny/{$id}.png",
"imageMiniature" => "images/pokemon_miniature/{$id}.png");
}

function getProchainEvolution($mysqli, $id)
{
    $sqlProchainEvolutionPokemon = "SELECT id_pokemon_evolue,niveau FROM evolue WHERE evolue.id_pokemon_base = $id";
    $resultProchainEvolutionPokemon = readDB($mysqli, $sqlProchainEvolutionPokemon);
    if (isset($resultProchainEvolutionPokemon[0]['id_pokemon_evolue'])) {
        return array(
            'id_pokemon_evolue' => $resultProchainEvolutionPokemon[0]['id_pokemon_evolue'],
            'niveau' => $resultProchainEvolutionPokemon[0]['niveau']
        );
    } else {
        return -1;
    }
}

function getEvolution($mysqli, $id)
{
    $ids = [];
    $prochainEvolutionId = getProchainEvolution($mysqli, $id);
    while ((int) $prochainEvolutionId != -1) {
        $ids[] = $prochainEvolutionId;
        $prochainEvolutionId = getProchainEvolution($mysqli, $prochainEvolutionId['id_pokemon_evolue']);
    }
    return $ids;
}


function getAttacks($mysqli, $id)
{
    $sqlAttaquesPokemon = "SELECT libelle_capacite,pp_capacite,puissance_capacite,precision_capacite FROM capacite INNER JOIN lance ON lance.id_capacite=capacite.id_capacite WHERE lance.id_pokemon = $id";
    $resultAttaquesPokemon = readDB($mysqli, $sqlAttaquesPokemon);
    return $resultAttaquesPokemon;
}

function login($mysqli, $login, $password)
{
    $sqlLogin = "SELECT * FROM dresseur WHERE nom_dresseur = '$login' AND mdp_dresseur = '$password'";
    $resultLogin = readDB($mysqli, $sqlLogin);
    return $resultLogin;
}

function pokemonVuOuAttrape($mysqli, $idDresseur, $idPokemon)
{
    $sqlPokemonVuOuAttrape = "SELECT nbVue,nbAttrape FROM pokedex WHERE id_dresseur = $idDresseur AND id_pokemon = $idPokemon";
    $resultPokemonVuOuAttrape = readDB($mysqli, $sqlPokemonVuOuAttrape);
    return $resultPokemonVuOuAttrape;
}

function checkPokedex($mysqli, $idDresseur, $idPokemon)
{
    $sqlCheckPokedex = "SELECT * FROM pokedex WHERE id_pokemon = $idPokemon AND id_dresseur = $idDresseur";
    $resultCheckPokedex = readDB($mysqli, $sqlCheckPokedex);
    return !empty($resultCheckPokedex);
}


?>