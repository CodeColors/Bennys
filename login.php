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

<form method="post">
    <input type = "text" name="username" placeholder="Nom d'utilisateur">
    <input type = "password" name="password" placeholder="Password">
    <input type = "submit" name="log" value="Se connecter">
</form>

<form method="post">
    <input type = "password" name="enc_value" placeholder="Password">
    <input type = "submit" name="encrypt" value="Crypter">
</form>
