<?php

/*
 * Author: piaf
 * Description: logging out page
 */

session_start();
unset($_SESSION);
session_destroy();

header('Location: login.php');

?>