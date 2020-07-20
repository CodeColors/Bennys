<?php

/*
Author: piaf
Description: index page for redirecting to connect/home pages
*/

session_start();
if(isset($_SESSION['id'])){
    header('Location: home.php');
}else{
    header('Location: login.php');
}
