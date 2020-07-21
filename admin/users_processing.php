<?php

/*
 * Author: piaf
 * Description: backend page for users management
 */
session_start();

if(!(isset($_SESSION['user']['id'])) || $_SESSION['user']['rank'] < 1){ header('Location: login.php'); }
if(!(isset($_GET['action'])) AND !(isset($_GET['id'])) AND !(isset($_GET['csrf']))){ header('Location: users.php'); }

require('../libs/Database.php');

$db = (new Database())->GetDatabase();

if($_GET['action'] == "modify"){
    if(isset($_GET['action_data'])){
        $data = json_decode($_GET['action_data']);
        $target = $_GET['id'];
        $column = array_keys($data);

        $sqlModifiedCol = array();
        foreach($column as $item){
            array_push($sqlModifiedCol, $item . ' = :' . $item);
        }
        $sqlModifiedCol .= implode(',', $sqlModifiedCol);

        $req = $db->prepare("UPDATE users SET $sqlModifiedCol WHERE id = $target LIMIT 1");
        $req->execute($data);
        $_ALERT['users'] = "Modification réussie: $sqlModifiedCol";
        header('Location: users.php');
    }else {
        $_ALERT['users'] = "Erreur lors de la modification: data cannot be provide.";
    }
}