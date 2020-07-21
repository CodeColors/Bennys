<?php

/*
 * Author: piaf
 * Description: logging out page
 */

session_start();
unset($_SESSION);
session_abort();

header('Location: login.php');

?>