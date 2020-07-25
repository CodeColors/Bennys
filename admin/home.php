<?php
session_start();
if(!(isset($_SESSION['user']['id'])) || $_SESSION['user']['rank'] < 1){ header('Location: ../login.php'); }
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
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md rubberBand animated navigation-clean-search">
        <div class="container"><a class="navbar-brand" href="#" style="font-size: 25px;">Benny's - Administration</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#">Accueil</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="./users.php">Utilisateurs</a></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                </ul>
                <form class="form-inline mr-auto" target="_self">
                    <div class="form-group"><label for="search-field"></label></div>
                </form><a class="btn btn-light action-button" role="button" href="../home.php"><i class="fa fa-arrow-circle-left"></i>&nbsp;Retour au site</a></div>
        </div>
    </nav>
    <div class="features-boxed">
        <div class="container">
            <div class="intro">
                <h2 class="text-center">Accueil</h2>
                <p class="text-center">Retrouvez tous vos liens et pages d'administration ici même.</p>
            </div>
            <div class="row justify-content-center features">
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="fa fa-users icon"></i>
                        <h3 class="name">Utilisateurs</h3>
                        <p class="description">Pour gérer les utilisateurs, merci d'aller ci dessous.</p><a class="learn-more" href="users.php">Gestion utilisateurs »</a></div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="fa fa-clock-o icon"></i>
                        <h3 class="name">Always available</h3>
                        <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus.</p><a class="learn-more" href="#">Learn more »</a></div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="fa fa-list-alt icon"></i>
                        <h3 class="name">Customizable </h3>
                        <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus.</p><a class="learn-more" href="#">Learn more »</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="jello animated footer-basic">
        <footer>
            <div class="social" style="padding-bottom: 5px;"><a href="https://discord.gg/zufyAES"><i class="fab fa-discord"></i></a><a href="https://github.com/CodeColors"><i class="icon ion-social-github"></i></a></div>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Administration</a></li>
                <li class="list-inline-item"><a href="#" style="color: #4b4c4d;">Retour au site</a></li>
                <li class="list-inline-item"><a href="#">Déconnexion</a></li>
            </ul>
            <p class="copyright">piaf © 2020</p>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>