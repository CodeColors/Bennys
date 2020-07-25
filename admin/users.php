<?php

/*
 * Author: piaf
 * Description: users management (registering, ...)
 */

session_start();
require('../libs/Utils.php');

if(!(isset($_SESSION['user']['id'])) || $_SESSION['user']['rank'] < 1){ header('Location: login.php'); }



if(isset($_POST['mod'])){
    unset($_POST['mod']);

    $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

    header('Location: users_processing.php?action=modify&id='. $_GET['id'] . '&csrf='. $_SESSION['csrf'] . '&action_data=' . json_encode($_POST));
}

require('../libs/Database.php');
$db = (new Database())->GetDatabase();

$req = $db->prepare("SELECT * FROM users");
$req->execute();
$users = $req->fetchAll();

if(isset($_ALERT['users'])){
    echo $_ALERT['users'];
    unset($_ALERT['users']);
}

if(!(isset($_GET['action']))){
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
        <tr>
            <th><?= $user['id']; ?></th>
            <th><?= $user['username']; ?></th>
            <th><?= $user['rank']; ?></th>
            <th><a href="users.php?action=modify&id=<?= $user['id']; ?>">Éditer</a> |-| <a href="users_processing.php?action=delete&id=<?= $user['id']; ?>&csrf=<?php $_SESSION['csrf']; ?>">Supprimer</a></th>
            </tr>
            <?php } ?>
    </tbody>
</table>

<?php
}else{
    if($_GET['action'] == "modify"){
        if(isset($_GET['id'])){

            $user = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
            $user->execute(array(
                    "id" => $_GET['id']
            ));
            if($user->rowCount() > 0){
                $user = $user->fetch();
            ?>
                <h2>Modifier l'utilisateur: <?= $user['username']; ?></h2>
                <form method="post">
                    <input type="text" name="username" placeholder="Nom d'utilisateur" value="<?= $user['username']; ?>">
                    <input type="password" name="password" placeholder="Mot de passe">
                    <input type="text" name="rank" placeholder="Rang (max 1)">
                    <input type="submit" name="mod" value="Modifier">
                </form>


            <?php
            }else{
                $_ALERT['users'] = "Erreur: target not found in database";
                //header('Location: users.php');
                die('ERR_TAR_N_FOUND: ' . var_dump($user->rowCount()));
            }
        }else{
            $_ALERT['users'] = "Erreur: target not specified";
            //header('Location: users.php');
            die('ERR_T_NSPEC');
        }


    }

}
?>



