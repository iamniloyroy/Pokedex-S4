<?php 

function navbar($currentPage) {
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
    <img src="images/logo.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
    Pokedex
  </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">';
    $head_links = array(
        "Acceuil" => "index.php",
    );
    if (isset($_SESSION["id"]) && $_SESSION["login"]){
      $head_links["Modification"] = "modification.php";
        $head_links["Deconnexion"] = "php/logout.php";
    } else {
        $head_links["Connexion"] = "connection.php";
    }
    
    foreach($head_links as $name => $link) {
        echo '<li class="nav-item">
        <a class="nav-link ' . ($currentPage == $name ? 'active' : '') . '" href="' . $link . '">' . $name . '</a>
      </li>';
    }
      echo '</ul>
    </div>
  </nav>';
}

?>