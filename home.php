<?php

/*
 * Author: piaf
 * Description: Homepage
 */

session_start();

if(!(isset($_SESSION['user']['id']))){
    header('Location: login.php');
}

?>

<h1>Page d'accueil</h1>
<hr>
<p>Bienvenue <?= $_SESSION['user']['username']; ?> sur l'espace de gestion du Benny's !</p>
<?php if($_SESSION['user']['rank'] >= 1){ ?>
<p>Appuie <a href="admin/home.php">ici</a> pour accéder à l'espace d'administration</p>
<?php } ?>

<div style="display: flex; justify-content: center;">
    <div style="border-color: black; border-style: solid; border: 0.5px 0.5px; padding: 0.5%; margin: 2%;">
        <form method="post">
            <h5>Chercher un modèle</h5>
            <input type="text" placeholder="Plaque du véhicule" name="plate">
            <input type="submit" value="Rechercher" name="search_plate">
        </form>
    </div>
    <div style="border-color: black; border-style: solid; border: 0.5px 0.5px; padding: 0.5%; margin: 2%;">
        <form method="post">
            <h5>Chercher un modèle</h5>
            <input type="text" placeholder="Plaque du véhicule" name="plate">
            <input type="submit" value="Rechercher" name="search_plate">
        </form>
    </div>
    <div style="border-color: black; border-style: solid; border: 0.5px 0.5px; padding: 0.5%; margin: 2%;">
        <form method="post">
            <h5>Chercher un modèle</h5>
            <input type="text" placeholder="Plaque du véhicule" name="plate">
            <input type="submit" value="Rechercher" name="search_plate">
        </form>
    </div>
    <div style="border-color: black; border-style: solid; border: 0.5px 0.5px; padding: 0.5%; margin: 2%;">
        <form method="post">
            <h5>Chercher un modèle</h5>
            <input type="text" placeholder="Plaque du véhicule" name="plate">
            <input type="submit" value="Rechercher" name="search_plate">
        </form>
    </div>

</div>

