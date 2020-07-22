<?php

/*
 * Author: piaf
 * Description: users management (registering, ...)
 */

session_start();
require('../libs/Utils.php');

if(!(isset($_SESSION['user']['id'])) || $_SESSION['user']['rank'] < 1){ header('Location: login.php'); }

require('../libs/Database.php');
$db = (new Database())->GetDatabase();

$req = $db->exec("SELECT * FROM users");
$users = $req->fetchAll();

if(isset($_ALERT['users'])){
    echo $_ALERT['users'];
    unset($_ALERT['users']);
}
?>


<h2>Liste des utilisateurs</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Rank</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user){ ?>
            <th><?= $user['id']; ?></th>
            <th><?= $user['name']; ?></th>
            <th><?= $user['rank']; ?></th>
            <th><a href="users_processing.php?action=modify&id=<?php $user['id']; ?>&csrf=<?php $_SESSION['csrf']; ?>&action_data=[]">Éditer</a> |-| <a href="users_processing.php?action=delete&id=<?php $user['id']; ?>&csrf=<?php $_SESSION['csrf']; ?>">Supprimer</a></th>
        <?php } ?>
    </tbody>
</table>


