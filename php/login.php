<?php
session_start();

require_once ("../includes/config-bdd.php");
require_once ("../includes/constantes.php");
require_once ("functions-DB.php");
require_once ("functions_query.php");
require_once ("functions_structure.php");

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // echo $username;
    // echo "<br>";
    // echo $password;

    
    $mysqli = connectionDB();
    $result = login($mysqli, $username, $password);
    closeDB($mysqli);
    if (!empty($result)) {
        $_SESSION['id'] = $result[0]['id_dresseur'];
        $_SESSION['login'] = $result[0]['nom_dresseur'];
        $_SESSION['connected'] = true;

        header("Location: ../index.php");
    } else {
        header("Location: ../connection.php?error=1");
    }

} else {
    header("Location: ../connection.php");
}

?>