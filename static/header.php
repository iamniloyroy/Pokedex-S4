<?php
function head($currentPage)
{
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>' . ucfirst($currentPage) . '</title>
        <meta name="description" content="Explorez un Pokédex complet proposant des informations sur les espèces de Pokémon, leurs types, leurs capacités, et bien plus encore. Attrapez-les tous grâce à notre base de données interactive. Rejoignez l\'aventure dès maintenant !">
        <meta name="keywords" content="pokédex, pokemon, jeu">
        <link rel="icon" href="images/logo.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>';
}
?>