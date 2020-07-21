<?php

/*
 * Author: piaf
 * Description: login page for users
 */

session_start();
require('libs/Database.php');

if(isset($_POST['log'])){
    if(isset($_POST['username']) AND !empty($_POST['username']) AND isset($_POST['password']) AND !empty($_POST['password'])){
        $db = (new Database())->GetDatabase();


        $username = $_POST['username'];
        $password = $_POST['password'];

        $search_user = $db->prepare('SELECT * FROM users WHERE mail = :mail LIMIT 1', array( 'mail' => $username ));

        if($search_user->rowCount() == 0){
            $_ALERT['login'] = "Erreur de login: compte inexistant";
            unset($_POST);
            header('Location: login.php');
        }else{
            $search_user->fetch();
            if(password_verify($password, $search_user['password'])){
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

if(isset($_ALERT['login'])){
    print($_ALERT['login']);
    unset($_ALERT['login']);
}