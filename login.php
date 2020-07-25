<?php

/*
 * Author: piaf
 * Description: login page for users
 */

session_start();

require('libs/Utils.php');

if(isset($_SESSION['user']['id'])){ header('Location: home.php'); }

require('libs/Database.php');

if(isset($_POST['log'])){
    if(isset($_POST['username']) AND !empty($_POST['username']) AND isset($_POST['password']) AND !empty($_POST['password'])){
        $db = (new Database())->GetDatabase();
        if(!($db)){
            die('Cannot retrieve account: error establishing database connection');
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $search_user = $db->prepare('SELECT * FROM users WHERE username = :username LIMIT 1');
        $search_user->execute(array( 'username' => $username ));

        if($search_user->rowCount() == 0){
            $_ALERT['login'] = "Erreur de login: compte inexistant";
            unset($_POST);
            header('Location: login.php');
        }else{
            $search_user = $search_user->fetch();
            if(password_verify($password, $search_user['password'])){
                require('libs/CSRF.php');
                $_SESSION['csrf'] = (new CSRF())->generateCSRF();
                $_SESSION['user'] = $search_user;
                $_ALERT['home'] = "Connexion réussie ! Bienvenue " . $username . " !";
                header('Location: home.php');
            }else{
                $_ALERT['login'] = "Erreur de login: pseudonyme ou mot de passe incorrects";
            }
        }
    }else{
        $_ALERT['login'] = "Erreur de login: pseudonyme ou mot de passe manquant";
    }
}

if(isset($_POST['encrypt'])){
    $_ALERT['login'] = password_hash($_POST['enc_value'], PASSWORD_BCRYPT);
}

if(isset($_ALERT['login'])){
    echo $_ALERT['login'];
    unset($_ALERT['login']);
}


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
<div class="text-center d-xl-flex justify-content-xl-center align-items-xl-end login-dark" style="background: url(assets/img/15098326611360_97eb27-20170617031540_1.jpg) left;">
    <form method="post" style="background-color: #ffffff;box-shadow: 0px 0px 11px #222222;">
        <h2 class="sr-only">Login Form</h2>
        <div class="illustration"><i class="icon ion-ios-locked-outline" style="color: #66d7d7;"></i></div>
        <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Nom d'utilisateur" required="" style="color: #222222;"></div>
        <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Mot de passe" required="" style="color: #222222;"></div>
        <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="log" style="background-color: #56c6c6;">Connexion</button></div>
    </form>
</div>
<div class="footer-basic" style="height: 2%;padding: 1%;background-color: #222222;">
    <footer>
        <div class="d-xl-flex justify-content-xl-center align-items-xl-center social" style="padding: 0px;"><a class="d-xl-flex justify-content-xl-center align-items-xl-center" href="https://discord.gg/zufyAES" style="color: #ffffff;"><i class="fab fa-discord" style="color: #ffffff;"></i></a><a class="d-xl-flex justify-content-xl-center align-items-xl-center"
                                                                                                                                                                                                                                                                                                        href="https://github.com/CodeColors" style="color: rgb(255,255,255);"><i class="icon ion-social-github" style="color: rgb(255,255,255);"></i></a></div>
        <p class="d-xl-flex justify-content-xl-center align-items-xl-center copyright" style="margin: 0px;margin-top: 5px;color: rgb(255,255,255);">piaf © 2020</p>
    </footer>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>

