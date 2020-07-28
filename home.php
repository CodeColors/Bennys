<?php

/*
 * Author: piaf
 * Description: Homepage
 */

session_start();

if(!(isset($_SESSION['user']['id']))){
    header('Location: login.php');
}
require('libs/Database.php');

$db = (new Database())->GetDatabase();
$statement = $db->prepare('SELECT * FROM plate LIMIT 5');
$statement->execute();
$statement = $statement->fetchAll();

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Bennys</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
</head>

<body>
<nav class="navbar navbar-light navbar-expand-md navigation-clean-search">
    <div class="container"><a class="navbar-brand" href="#" style="font-size: 25px;">Benny's</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div
                class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav">
                <li class="nav-item" role="presentation"><a class="nav-link active" href="#">Accueil</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="plates.php">Gestion des plaques</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="logout.php">Déconnexion</a></li>
                <li class="nav-item" role="presentation"></li>
                <li class="nav-item" role="presentation"></li>
            </ul>
            <form class="form-inline mr-auto" target="_self">
                <div class="form-group"><label for="search-field"></label></div>
            </form><?php if($_SESSION['user']['rank'] > 0) { ?> <a class="btn btn-light action-button" role="button" href="./admin/home.php"><i class="fa fa-gear"></i>&nbsp;Administration</a><?php } ?></div>
    </div>
</nav>
<div class="row" style="background-color: #eef4f7;">
    <div class="col" style="margin-top: 15px;background-color: #eef4f7;">
        <div class="container">
            <h2 style="margin-bottom: 10px;">Dernières plaques</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th style="width: 2%;">#</th>
                        <th style="width: 15%;">Plaque</th>
                        <th>Dernière entrée</th>
                        <th style="width: 13%;">Statut</th>
                        <th style="width: 5%;">Score</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($statement as $plate){ ?>
                        <tr>
                            <td><?= $plate['id']; ?></td>
                            <td style="text-align: center;"><?= $plate['name']; ?></td>
                            <td><?= $plate['last_title']; ?></td>
                            <?php if($plate['state'] == 0){ ?>
                                <td style="text-align: center;"><span><span class="badge badge-success" style="margin-right: 5px;"><i class="fa fa-check"></i></span></span>Valide</td>
                            <?php } elseif($plate['state'] == 1) { ?>
                                <td style="text-align: center;"><span><span class="badge badge-warning" style="margin-right: 5px;"><i class="fa fa-check"></i></span></span>Vidange</td>
                            <?php } elseif($plate['state'] == 2) { ?>
                                <td style="text-align: center;"><span><span class="badge badge-warning" style="margin-right: 5px;"><i class="fa fa-check"></i></span></span>Révision</td>
                            <?php } elseif($plate['state'] == 3) { ?>
                                <td style="text-align: center;"><span><span class="badge badge-danger" style="margin-right: 5px;"><i class="fa fa-check"></i></span></span>HS</td>
                            <?php }
                            $score = 100 - ($plate['n_entry'] * 4);
                            if($score < 0){ $score = 0; }
                            if($score >= 66){
                                ?>
                                <td style="text-align: center;"><span class="badge badge-success" style="margin-right: 5px;"><i class="fa fa-trophy"></i><?= $score; ?></span></td>
                            <?php } elseif($score < 66 AND $score >= 33) { ?>
                                <td style="text-align: center;"><span class="badge badge-warning" style="margin-right: 5px;"><i class="fa fa-trophy"></i><?= $score; ?></span></td>
                            <?php } elseif($score < 33) { ?>
                                <td style="text-align: center;"><span class="badge badge-danger" style="margin-right: 5px;"><i class="fa fa-trophy"></i><?= $score; ?></span></td>
                            <?php } ?>

                            <td class="text-center"><a href="plates.php?action=view&id=<?= $plate['id']; ?>"><i class="fa fa-chevron-right" style="font-size: 20px;"></i></a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="features-boxed">
    <div class="container">
        <div class="intro"></div>
        <div class="row justify-content-center features">
            <div class="col-sm-6 col-md-5 col-lg-4 item">
                <div class="box"><i class="fa fa-car icon" style="color: #66d7d7;"></i>
                    <h3 class="name">Enregistrer un véhicule</h3>
                    <p class="description">Afin d'enregistrer un nouveau véhicule, cliquez sur le bouton ci dessous.</p><a class="learn-more" href="plates.php?action=create">Enregistrer une plaque »</a></div>
            </div>
            <div class="col-sm-6 col-md-5 col-lg-4 item">
                <div class="box"><i class="fa fa-list-alt icon" style="color: #56c6c6;"></i>
                    <h3 class="name">Liste des véhicules</h3>
                    <p class="description">Afin d'accéder à la liste des véhicules, cliquez sur le bouton ci dessous.</p><a class="learn-more" href="plates.php">Voir les véhicules »</a></div>
            </div>
        </div>
    </div>
</div>
<div class="footer-basic">
    <footer>
        <div class="social"><a href="https://discord.gg/zufyAES"><i class="fab fa-discord"></i></a><a href="https://github.com/CodeColors"><i class="icon ion-social-github"></i></a></div>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Accueil</a></li>
            <li class="list-inline-item"><a href="plates.php">Plaques</a></li>
            <li class="list-inline-item"><a href="#">Administration</a></li>
            <li class="list-inline-item"><a href="#">Déconnexion</a></li>
            <li class="list-inline-item"></li>
        </ul>
        <p class="copyright">piaf © 2020</p>
    </footer>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>

