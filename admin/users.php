<?php

/*
 * Author: piaf
 * Description: users management (registering, ...)
 */

session_start();
require('../libs/Utils.php');

if(!(isset($_SESSION['user']['id'])) || $_SESSION['user']['rank'] < 1){ header('Location: ../login.php'); }



if(isset($_POST['mod'])){
    unset($_POST['mod']);

    $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

    header('Location: users_processing.php?action=modify&id='. $_GET['id'] . '&csrf='. $_SESSION['csrf'] . '&action_data=' . json_encode($_POST));
}

if(isset($_POST['add'])){
    unset($_POST['add']);

    $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

    header('Location: users_processing.php?action=create&id=0&csrf='. $_SESSION['csrf'] . '&action_data=' . json_encode($_POST));
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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
    </head>

    <body>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-search">
        <div class="container"><a class="navbar-brand" href="#" style="font-size: 25px;">Benny's - Administration</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                    class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="./home.php">Accueil</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="./users.php">Utilisateurs</a></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                </ul>
                <form class="form-inline mr-auto" target="_self">
                    <div class="form-group"><label for="search-field"></label></div>
                </form><a class="btn btn-light action-button" role="button" href="../home.php"><i class="fa fa-arrow-circle-left"></i>&nbsp;Retour au site</a></div>
        </div>
    </nav>
    <?php if(!(isset($_GET['action']))){ ?>
    <div class="row">
        <div class="col">
            <div class="container text-nowrap d-xl-flex justify-content-xl-center">
                <div class="col d-xl-flex justify-content-xl-start align-items-xl-center" style="min-width: 50%;max-width: 50%;padding: 1%;">
                    <h3 style="text-align: center;">Liste des utilisateurs</h3>
                </div>
                <div class="col text-center d-xl-flex justify-content-xl-end align-items-xl-center" style="min-width: 50%;max-width: 50%;padding: 1%;"><a href="users.php?action=create&id=0" class="btn btn-primary text-center" type="button" style="background-color: #56c6c6;border-radius: 100px;border-color: #56c6c6;"><i class="fa fa-pencil"></i>&nbsp;Ajouter un utilisateur</a></div>
            </div>
        </div>
    </div>
    <div class="row" style="background-color: #eef4f7;">
        <div class="clearfix"></div>
        <div class="col" style="margin-top: 15px;background-color: #eef4f7;">
            <div class="container">
                <div class="table-responsive">
                    <table class="table" id="users">
                        <thead>
                        <tr>
                            <th style="width: 2%;">#</th>
                            <th style="width: 15%;text-align: center;">Nom</th>
                            <th style="width: 2%;text-align: center;">Rang</th>
                            <th style="width: 10%;text-align: center;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user){ ?>
                            <tr>
                                <td><?= $user['id']; ?></td>
                                <td style="text-align: center;"><?= $user['username']; ?></td>
                                <?php if($user['rank'] == 0){ ?>
                                    <td style="text-align: center;">Utilisateur</td>
                                <?php }else{ ?>
                                    <td style="text-align: center;">Administrateur</td>
                                <?php } ?>
                                <td class="text-center d-xl-flex justify-content-xl-center align-items-xl-center"><a href="users.php?action=modify&id=<?= $user['id']; ?>" style="margin-right: 10px;"><i class="fa fa-pencil-square-o" style="font-size: 20px;"></i></a>   <a href="users_processing.php?action=delete&id=<?= $user['id']; ?>&csrf=<?php $_SESSION['csrf']; ?>"><i class="fa fa-trash" style="font-size: 20px;"></i></a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
        }elseif($_GET['action'] == "modify"){
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
            header('Location: users.php');
        }
        }else{
            $_ALERT['users'] = "Erreur: target not specified";
            header('Location: users.php');
        }
    }elseif($_GET['action'] == "create"){ ?>
        <div class="row">
            <div class="col">
                <div class="container text-nowrap d-xl-flex justify-content-xl-center">
                    <div class="col d-xl-flex justify-content-xl-start align-items-xl-center" style="min-width: 50%;max-width: 50%;padding: 1%;">
                        <h3 style="text-align: center;">Ajouter un utilisateur</h3>
                    </div>
                    <div class="col text-center d-xl-flex justify-content-xl-end align-items-xl-center" style="min-width: 50%;max-width: 50%;padding: 1%;"><a href="users.php" class="btn btn-primary text-center" type="button" style="background-color: #56c6c6;border-radius: 100px;border-color: #56c6c6;"><i class="fa fa-arrow-circle-left"></i>&nbsp;Retour à la liste</a></div>
                </div>
            </div>
        </div>
        <div class="row d-xl-flex justify-content-xl-center align-items-xl-center" style="background-color: #eef4f7;">
            <div class="clearfix"></div>
            <div class="col d-xl-flex justify-content-xl-center align-items-xl-center" style="margin-top: 15px;background-color: #eef4f7;">
                <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="margin-bottom: 15px;">
                    <div class="col-6 d-xl-flex justify-content-xl-center align-items-xl-center">
                        <form class="text-center" method="post">
                            <div class="form-group d-xl-flex justify-content-xl-center align-items-xl-center"><label style="margin-right: 10px;">Nom:</label><input class="form-control" type="text" name="username" required=""></div>
                            <div class="form-group d-xl-flex justify-content-xl-center align-items-xl-center"><label style="margin-right: 10px;">Mot de passe:</label><input class="form-control" type="password" name="password" required=""></div>
                            <div class="form-group d-xl-flex justify-content-xl-center align-items-xl-center"><label style="margin-right: 10px;">Rang:</label><select class="form-control" name="rank" required=""><option value="0" selected="">Utilisateur</option><option value="1">Administrateur</option></select></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1" required=""><label class="form-check-label" for="formCheck-1">Je certifie avoir vérifié les informations lors de la saisie</label></div>
                            <input class="btn btn-info" type="submit" name="add"></input></form>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }else{
        header('Location: users.php');
    }
    ?>
    <div class="footer-basic">
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
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#users').DataTable();
        } );
    </script>
    </body>
</html>









