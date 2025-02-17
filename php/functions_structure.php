<?php

function displayPokedex($mysqli, $pokedex)
{
    echo '<div class="container">';
    if (isset($_SESSION["id"]) && $_SESSION["login"]) {
        echo '<div class="row"><div class="col-12"><div class="card"><div class="card-header">';
        echo "Bienvenue <strong>" . $_SESSION["login"];
        echo '</strong></div></div></div></div><br>';
    }

    echo '<div class="row">';
    foreach ($pokedex as $pokemon) {
        echo '<div class="col-12 col-sm-6 col-md-3 col-lg-2">
            <a href="pokemon.php?numero=' . $pokemon['numero'] . '">
            <div class="card mb-4 card-pokemon" style="opacity: ';
        if (isset($_SESSION['id'])) {
            $pokemonVuOuAttrapeResult = pokemonVuOuAttrape($mysqli, $_SESSION['id'], getIdPokemon($mysqli, $pokemon['numero']));
            echo !empty($pokemonVuOuAttrapeResult) ? ($pokemonVuOuAttrapeResult[0]["nbAttrape"] > 0 || $pokemonVuOuAttrapeResult[0]["nbVue"] > 0) ? '1' : '0.3' : '0.3';
        } else {
            echo '1';
        }
        echo '" ><img src="images/pokemon/' . $pokemon['numero'] . '.png" class="card-img-top" alt="' . $pokemon['nom'] . '">';
        if (!empty($pokemonVuOuAttrapeResult) && $pokemonVuOuAttrapeResult[0]["nbAttrape"] > 0) {
            echo '<div class="corner-image"><img src="images/pokeball.png" alt="Pokemon"></div>';
        }
        echo '<div class="card-body">
                        <h5 class="card-title">' . $pokemon['nom'] . '</h5>
                        <p class="card-text">#' . $pokemon['numero'] . '</p>
                        ';
                        $pokemonTypes = getTypes($mysqli, getIdPokemon($mysqli, $pokemon['numero']));
                        echo "<div class='imagesTypes'>";
                        foreach ($pokemonTypes as $type) {
                            echo "<div class='inline-block'>";
                            echo "<img src='{$type['image']}' class='pokemonTypeSmall' alt='{$type['type']}'>";
                            echo "</div>";
                        }
                        echo "</div>";
                        echo '
                        </div>
                        </div>
                        </a>
                        </div>';
    }
    echo '</div></div>';
}

function displayPokemon($pokemonId, $pokemonImage, $pokemonProfile, $pokemonTypes, $evolutions, $attacks, $vuOuAttrape, $mysqli)
{
    echo "<div class='container'>";
    echo "<div class='row gx-2'>";
    echo "<div class='col-3'>";
    echoPokemonHeader($pokemonImage, $pokemonProfile, $pokemonTypes, $vuOuAttrape);
    echo "</div>";

    echo "<div class='col-9'>";
    echo "<div class='row g-2'>";
    echo "<div class='col-12'>";
    echoPokemonDescription($pokemonProfile);
    echo "</div>";
    echo "</div>";

    echo "<div class='col-12'>";
    echoPokemonAttacks($attacks);
    echo "</div>";
    echo "</div>";
    echo "</div>";

    echo "<div class='col-12'>";
    echoPokemonEvolutions($evolutions, $pokemonId, $mysqli);
    echo "</div>";

    echo "</div>";
}

function echoPokemonHeader($pokemonImage, $pokemonProfile, $pokemonTypes, $vuOuAttrape)
{

    echo "<div class='card'>";
    echo "<div class='pokemonAvatar'>";
    echo "<img class='card-img-top' src='{$pokemonImage['imageSugimori']}' alt='Card image cap'>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>#{$pokemonProfile['numero']} {$pokemonProfile['nom']}</h5>";
    echo "<div class='imagesTypes'>";
    foreach ($pokemonTypes as $type) {
        echo "<div class='inline-block'>";
        echo "<img src='{$type['image']}' class='pokemonType' alt='{$type['type']}'>";
        echo "</div>";
    }
    echo "</div>";
    if (isset($_SESSION['id'])) {
        echo "<hr>";
        echo "<div class='icon-container'>";
        echo "<p class='vuOuAttrapeText'><img src='images/seen.png' alt='Seen Icon' class='icon'>: " . (!empty($vuOuAttrape) ? $vuOuAttrape[0]['nbVue'] : '0') . "</p>";
        echo "<p class='vuOuAttrapeText'><img src='images/pokeball.png' alt='Pokeball Icon' class='icon'>: " . (!empty($vuOuAttrape) ? $vuOuAttrape[0]['nbAttrape'] : '0') . "</p>";
        echo "</div>";
        echo "<a href='modification.php?numero={$pokemonProfile['numero']}&nbVue=" . (!empty($vuOuAttrape) ? $vuOuAttrape[0]['nbVue'] : '0') . "&nbAttrape=" . (!empty($vuOuAttrape) ? $vuOuAttrape[0]['nbAttrape'] : '0') . "' class='btn btn-success btn-modif'>Modifier</a>";
    }
    echo "</div>";
    echo "</div>";
}

function echoPokemonDescription($pokemonProfile)
{
    echo "<div class='card'>";
    echo "<div class='card-header'>Description</div>";
    echo "<div class='card-body'>";
    echo "<p class='card-text'>{$pokemonProfile['description']}</p>";
    echo "</div>";
    echo "</div>";
}

function echoPokemonAttacks($attacks)
{
    if (!empty($attacks)) {
        echo "<div class='row g-2 margin-t5'>";
        foreach ($attacks as $attack) {
            echo "<div class='col-6'>";
            echo "<li class='list-group-item'>";
            echo "<strong>{$attack['libelle_capacite']}</strong><br>";
            echo "Puissance: {$attack['puissance_capacite']}";
            echo "<div class='progress'>";
            echo "<div class='progress-bar' role='progressbar' style='width: {$attack['puissance_capacite']}%;' aria-valuenow='{$attack['puissance_capacite']}' aria-valuemin='0' aria-valuemax='100'></div>";
            echo "</div>";

            echo "PP: {$attack['pp_capacite']}";
            echo "<div class='progress'>";
            echo "<div class='progress-bar' role='progressbar' style='width: {$attack['pp_capacite']}%;' aria-valuenow='{$attack['pp_capacite']}' aria-valuemin='0' aria-valuemax='100'></div>";
            echo "</div>";

            echo "Précision: {$attack['precision_capacite']}";
            echo "<div class='progress'>";
            echo "<div class='progress-bar' role='progressbar' style='width: {$attack['precision_capacite']}%;' aria-valuenow='{$attack['precision_capacite']}' aria-valuemin='0' aria-valuemax='100'></div>";
            echo "</div>";
            echo "</li>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<div class='card margin-t5'><div class='card-header'>Pas d'attaque</div></div>";
    }
}

function echoPokemonEvolutions($evolutions,$currentPokemon, $mysqli)
{
    $bgColors = ['bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info'];
    echo "<div class='card margin-t5'>";
    echo "<div class='card-header'>Evolutions</div>";
    if (!empty($evolutions)) {
        echo '<div class="horizontal-timeline">';
        echo '<ul class="list-inline items">';
        array_unshift($evolutions, array(
            'id_pokemon_evolue' => $currentPokemon,
            'niveau' => "actuel"
        ));
        foreach ($evolutions as $evolution) {
            $evolutionProfile = getPokemonProfile($mysqli, $evolution['id_pokemon_evolue']);
            $evolutionImage = getPokemonImage($mysqli, $evolution['id_pokemon_evolue']);
            echo '<li class="list-inline-item items-list">
            <div class="px-4">';
            echo "<div class='event-date badge " . $bgColors[rand(0, count($bgColors) - 1)] . "'>Niveau {$evolution['niveau']}</div>";
            echo "<h5 class='pt-2'>{$evolutionProfile['nom']}</h5>";
            echo "<img src='{$evolutionImage['image']}' alt='Evolution image'>";
            echo "</div></li>";
        }
        echo "</ul>";
        echo "</div>";
    } else {
        echo "<div class='card-body'>Pas d'évolution</div>";
    }
    echo "</div>";
}



function formulaire()
{
    echo '<div class="container mt-5">
        <div class="row justify-content-center">
        <div class="col-md-6">
        <div class="card card-form">
            <div class="card-body">
                <form action="php/login.php" method="post">
                <h5 class="card-title">Connexion</h5>
                <hr>
                    <div class="form-group">
                        <label for="username">Nom d\'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>';
    if (isset($_GET['error'])) {
        echo "<p class='text-danger'>Mot de passe ne correspond pas</p>";
    }

    echo '
                    <br>
                    <button type="submit" class="btn btn-success btn-modif">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>';
}




function modificationFormulaire($mysqli)
{
    echo '<div class="container mt-5">
        <div class="row justify-content-center">
        <div class="col-md-10">
        <div class="card card-form">
            <div class="card-body">
                <form action="php/modif.php" method="post">
                <h5 class="card-title">Modifier votre Pokédex</h5>
                <hr>
                    <div class="form-group">
                    <label for="pokemon">Choisir votre pokémon :</label>
                    <select class="form-control" id="pokemon" name="pokemon">
                        ';
    if (isset($_GET['numero'])) {
        $numero = $_GET['numero'];
        $id = getIdPokemon($mysqli, $numero);
        $id = strval($id);
        $pokemonProfile = getPokemonProfile($mysqli, $id);
        $pokemons = getPokedex($mysqli);
        foreach ($pokemons as $pokemon) {
            if ($pokemon['id_pokemon'] == $id) {
                echo "<option value='{$pokemon['id_pokemon']}' selected>{$pokemonProfile['nom']}</option>";
            } else {
                echo "<option value='{$pokemon['id_pokemon']}'>{$pokemonProfile['nom']}</option>";
            }
        }
    } else {
        $pokemons = getPokedex($mysqli);
        foreach ($pokemons as $pokemon) {
            echo "<option value='{$pokemon['id_pokemon']}'>{$pokemon['nom']}</option>";
        }
    }
    echo '
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="nbVue">Nombre de fois vue :</label>
                    <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-outline-secondary btnCustom" onclick="document.getElementById(\'nbVue\').value--;">-</button>
                    </div>
                    <input type="number" class="form-control text-center" id="nbVue" name="nbVue" min="0" max="100" step="1" value="'.(isset($_GET['nbVue'])?strval($_GET['nbVue']):"1").'" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary btnCustom" onclick="document.getElementById(\'nbVue\').value++;">+</button>
                    </div>
                    </div></div>
                    
                    
                    <div class="form-group">
                    <label for="nbAttrape">Nombre de fois Attrapé :</label>
                    <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-outline-secondary btnCustom" onclick="document.getElementById(\'nbAttrape\').value--;">-</button>
                    </div>
                    <input type="number" class="form-control text-center" id="nbAttrape" name="nbAttrape" min="0" max="100" step="1" value="'.(isset($_GET['nbAttrape'])?strval($_GET['nbAttrape']):"1").'" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary btnCustom" onclick="document.getElementById(\'nbAttrape\').value++;">+</button>
                    </div>
                    </div>
                </div>
                    ';

    echo '
                    <br>
                    <button type="submit" class="btn btn-success btn-modif">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>';
}
?>