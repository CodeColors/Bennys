<?php
session_start();

if(!(isset($_SESSION['user']['id']))){
    header('Location: login.php');
}

require('libs/Database.php');
require('libs/CSRF.php');
$csrf = new CSRF();
$db = (new Database())->GetDatabase();

if(isset($_POST['add'])){
    if($csrf->checkCSRF($_SESSION, [], $_POST)){
        $req = $db->prepare('INSERT INTO plate (name, owner, state) VALUES (:name, :owner, :state)');
        $req->execute(array(
            "name" => $_POST['plate'],
            "owner" => $_POST['owner'],
            "state" => $_POST['state']
        ));
        header('Location: plates.php');
    }else{
        header('Location: logout.php');
    }
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>


</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-search">
        <div class="container"><a class="navbar-brand" href="#" style="font-size: 25px;">Benny's</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="home.php">Accueil</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#">Gestion des plaques</a></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                </ul>
                <form class="form-inline mr-auto" target="_self">
                    <div class="form-group"><label for="search-field"></label></div>
                </form><?php if($_SESSION['user']['rank'] > 0) { ?> <a class="btn btn-light action-button" role="button" href="admin/home.php"><i class="fa fa-gear"></i>&nbsp;Administration</a><?php } ?></div>
        </div>
    </nav>
    <?php
        if(!(isset($_GET['action']))){


            $statement = $db->prepare('SELECT * FROM plate');
            $statement->execute();
            $statement = $statement->fetchAll();



    ?>

    <div class="row">
        <div class="col">
            <div class="container text-nowrap d-xl-flex justify-content-xl-center">
                <div class="col d-xl-flex justify-content-xl-start align-items-xl-center" style="min-width: 50%;max-width: 50%;padding: 1%;">
                    <h3 style="text-align: center;">Liste des véhicules</h3>
                </div>
                <div class="col text-center d-xl-flex justify-content-xl-end align-items-xl-center" style="min-width: 50%;max-width: 50%;padding: 1%;"><a href="plates.php?action=create" class="btn btn-primary text-center" type="button" style="background-color: #56c6c6;border-radius: 100px;border-color: #56c6c6;"><i class="fa fa-pencil"></i>&nbsp;Ajouter une plaque</a></div>
            </div>
        </div>
    </div>
    <div class="row" style="background-color: #eef4f7;">
        <div class="clearfix"></div>
        <div class="col" style="margin-top: 15px;background-color: #eef4f7;">
            <div class="container">
                <div class="table-responsive">
                    <table class="table" id="plates">
                        <thead>
                            <tr>
                                <th style="width: 2%; text-align: center;">#</th>
                                <th style="width: 15%; text-align: center;">Plaque</th>
                                <th>Dernière entrée</th>
                                <th style="width: 13%; text-align: center;">Statut</th>
                                <th style="width: 5%; text-align: center;">Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($statement as $plate){ ?>
                            <tr>
                                <td><?= $plate['id']; ?></td>
                                <td style="text-align: center;"><?= $plate['name']; ?></td>
                                <td><?= $plate['last_title']; ?></td>
                                <?php if($plate['state'] == 0){ ?>
                                        <td style="text-align: center;"><span><span class="badge badge-success" style="margin-right: 5px;"><i class="fa fa-check"></i></span></span>Valide</td>
                                <?php } elseif($plate['state'] == 1) { ?>
                                        <td style="text-align: center;"><span><span class="badge badge-warning" style="margin-right: 5px;"><i class="fa fa-check"></i></span></span>Vidange</td>
                                <?php } elseif($plate['state'] == 2) { ?>
                                        <td style="text-align: center;"><span><span class="badge badge-warning" style="margin-right: 5px;"><i class="fa fa-check"></i></span></span>Révision</td>
                                <?php } elseif($plate['state'] == 3) { ?>
                                        <td style="text-align: center;"><span><span class="badge badge-danger" style="margin-right: 5px;"><i class="fa fa-check"></i></span></span>HS</td>
                                <?php }
                                    $score = 100 - ($plate['n_entry'] * 4);
                                    if($score < 0){ $score = 0; }
                                    if($score >= 66){
                                ?>
                                        <td style="text-align: center;"><span class="badge badge-success" style="margin-right: 5px;"><i class="fa fa-trophy"></i><?= $score; ?></span></td>
                                <?php } elseif($score < 66 AND $score >= 33) { ?>
                                        <td style="text-align: center;"><span class="badge badge-warning" style="margin-right: 5px;"><i class="fa fa-trophy"></i><?= $score; ?></span></td>
                                <?php } elseif($score < 33) { ?>
                                        <td style="text-align: center;"><span class="badge badge-danger" style="margin-right: 5px;"><i class="fa fa-trophy"></i><?= $score; ?></span></td>
                                <?php } ?>

                                <td class="text-center"><a href="plates.php?action=view&id=<?= $plate['id']; ?>"><i class="fa fa-chevron-right" style="font-size: 20px;"></i></a> <?php if($_SESSION['user']['rank'] > 0){ ?><a href="plates.php?action=delete&id=<?= $plate['id']; ?>&csrf=<?php $_SESSION['csrf']; ?>"><i class="fa fa-trash" style="font-size: 20px;"></i></a><?php } ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php }else{
        if($_GET['action'] == "create"){ ?>
            <div class="row">
                <div class="col">
                    <div class="container text-nowrap d-xl-flex justify-content-xl-center">
                        <div class="col d-xl-flex justify-content-xl-start align-items-xl-center" style="min-width: 50%;max-width: 50%;padding: 1%;">
                            <h3 style="text-align: center;">Ajouter un véhicule</h3>
                        </div>
                        <div class="col text-center d-xl-flex justify-content-xl-end align-items-xl-center" style="min-width: 50%;max-width: 50%;padding: 1%;"><a href="plates.php" class="btn btn-primary text-center" type="button" style="background-color: #56c6c6;border-radius: 100px;border-color: #56c6c6;"><i class="fa fa-arrow-circle-left"></i>&nbsp;Retour à la liste</a></div>
                    </div>
                </div>
            </div>
            <div class="row d-xl-flex justify-content-xl-center align-items-xl-center" style="background-color: #eef4f7;">
                <div class="clearfix"></div>
                <div class="col d-xl-flex justify-content-xl-center align-items-xl-center" style="margin-top: 15px;background-color: #eef4f7;">
                    <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="margin-bottom: 15px;">
                        <div class="col-6 d-xl-flex justify-content-xl-center align-items-xl-center">
                            <form class="text-center" method="post">
                                <div class="form-group d-xl-flex justify-content-xl-center align-items-xl-center"><label style="margin-right: 10px;">Plaque:</label><input class="form-control" type="text" name="plate" required=""></div>
                                <div class="form-group d-xl-flex justify-content-xl-center align-items-xl-center"><label style="margin-right: 10px;">Propriétaire:</label><input class="form-control" type="text" name="owner" required=""></div>
                                <div class="form-group d-xl-flex justify-content-xl-center align-items-xl-center"><label style="margin-right: 10px;">Statut:</label><select class="form-control" name="state" required=""><option value="0" selected="">Valide</option><option value="1">Vidange</option><option value="2">Révision</option><option value="3">HS</option></select></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1" required=""><label class="form-check-label" for="formCheck-1">Je certifie avoir vérifié les informations lors de la saisie</label></div>
                                <?php echo $csrf->addHiddenCSRFButton($_SESSION['csrf']); ?>
                                <input class="btn btn-info" type="submit" name="add"></input></form>
                        </div>
                    </div>
                </div>
            </div>
        <?php }elseif(isset($_GET['id']) AND $_GET['action'] == "view"){
            $statement = $db->prepare('SELECT * FROM plate WHERE id = :id LIMIT 1');
            $statement->execute(array('id' => $_GET['id']));
            $plate = $statement->fetch();
        ?>
            <div class="row">
                <div class="col">
                    <div class="container text-nowrap d-xl-flex justify-content-xl-center">
                        <div class="col d-xl-flex justify-content-xl-start align-items-xl-center" style="min-width: 50%;max-width: 50%;padding: 1%;">
                            <h3 style="text-align: center;">Plaque: <?= $plate['name']; ?></h3>
                        </div>
                        <div class="col text-center d-xl-flex justify-content-xl-end align-items-xl-center" style="min-width: 50%;max-width: 50%;padding: 1%;"><a href="plates.php" class="btn btn-primary text-center" type="button" style="background-color: #56c6c6;border-radius: 100px;border-color: #56c6c6;"><i class="fa fa-arrow-circle-left"></i>&nbsp;Retour à la liste</a></div>
                    </div>
                </div>
            </div>
            <div class="row" style="background-color: #eef4f7;">
                <div class="col d-xl-flex justify-content-xl-center align-items-xl-center" style="margin-top: 15px;">
                    <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="margin-bottom: 15px;">
                        <div class="col-xl-2 d-xl-flex justify-content-xl-center align-items-xl-center" style="padding-top: 15px;">
                            <ul class="list-unstyled" style="padding: 15px;background-color: #ffffff;border-radius: 15px;">
                                <li><strong>Plate: </strong><?= $plate['name']; ?></li>
                                <li><strong>Owner: </strong><?= $plate['owner']; ?></li>
                                <?php if($plate['state'] == 0){ ?>
                                    <li><strong>State: </strong><span class="badge badge-success" style="margin-right: 5px;padding-right: 3px;"><i class="fa fa-check"></i>&nbsp;</span>Valide</li>
                                <?php } elseif($plate['state'] == 1) { ?>
                                    <li><strong>State: </strong><span class="badge badge-warning" style="margin-right: 5px;padding-right: 3px;"><i class="fa fa-check"></i>&nbsp;</span>Vidange</li>
                                <?php } elseif($plate['state'] == 2) { ?>
                                    <li><strong>State: </strong><span class="badge badge-warning" style="margin-right: 5px;padding-right: 3px;"><i class="fa fa-check"></i>&nbsp;</span>Révision</li>
                                <?php } elseif($plate['state'] == 3) { ?>
                                    <li><strong>State: </strong><span class="badge badge-danger" style="margin-right: 5px;padding-right: 3px;"><i class="fa fa-check"></i>&nbsp;</span>HS</li>
                                <?php }
                                $score = 100 - ($plate['n_entry'] * 4);
                                if($score < 0){ $score = 0; }
                                if($score >= 66){
                                    ?>
                                    <li><strong>Score:</strong>&nbsp;<span class="badge badge-success" style="margin-right: 5px;"><i class="fa fa-trophy"></i><?= $score; ?></span></li>
                                <?php } elseif($score < 66 AND $score >= 33) { ?>
                                    <li><strong>Score:</strong>&nbsp;<span class="badge badge-warning" style="margin-right: 5px;"><i class="fa fa-trophy"></i><?= $score; ?></span></li>
                                <?php } elseif($score < 33) { ?>
                                    <li><strong>Score:</strong>&nbsp;<span class="badge badge-danger" style="margin-right: 5px;"><i class="fa fa-trophy"></i><?= $score; ?></span></li>
                                <?php } ?>


                                <li><strong>Entries: </strong><?= $plate['n_entry']; ?></li>
                            </ul>
                        </div>
                        <div class="col" style="background-color: #ffffff;border-radius: 15px;padding: 15px;">
                            <article>
                                <h4 class="d-xl-flex align-items-xl-center" style="border-radius: 15px;background-color: rgba(255,255,255,0);">Heading&nbsp;<span class="badge badge-success"><i class="fa fa-check"></i>&nbsp;Excellent</span></h4>
                                <p>Paragraph</p>
                            </article>
                            <hr>
                            <article>
                                <h4 class="d-xl-flex align-items-xl-center" style="border-radius: 15px;background-color: rgba(255,255,255,0);">Heading&nbsp;<span class="badge badge-success"><i class="fa fa-check"></i>&nbsp;Excellent</span></h4>
                                <p>Paragraph</p>
                            </article>
                            <hr>
                            <article>
                                <h4 class="d-xl-flex align-items-xl-center" style="border-radius: 15px;background-color: rgba(255,255,255,0);">Heading&nbsp;<span class="badge badge-success"><i class="fa fa-check"></i>&nbsp;Excellent</span></h4>
                                <p>Paragraph</p>
                            </article>
                            <hr>
                            <nav class="d-xl-flex justify-content-xl-center align-items-xl-center">
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        <?php }elseif(isset($_GET['id']) AND $_GET['action'] == 'delete'){
            if($_SESSION['user']['rank'] > 0){
                $check = $csrf->checkCSRF($_SESSION, $_GET, []);
                if(!($check)) { header('Location: logout.php'); }

                $req_1 = $db->prepare('DELETE FROM plate WHERE id = :id');
                $req_2 = $db->prepare('DELETE FROM plate_notes WHERE plate_id = :id');

                $req_1->execute(array('id' => $_GET['id']));
                $req_2->execute(array('id' => $_GET['id']));

                header('Location: plates.php');
            }
        } }  ?>
    <div class="footer-basic">
        <footer>
            <div class="social"><a href="https://discord.gg/zufyAES"><i class="fab fa-discord"></i></a><a href="https://github.com/CodeColors"><i class="icon ion-social-github"></i></a></div>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="home.html">Accueil</a></li>
                <li class="list-inline-item"><a href="#">Plaques</a></li>
                <li class="list-inline-item"><a href="#">Administration</a></li>
                <li class="list-inline-item"><a href="#">Déconnexion</a></li>
                <li class="list-inline-item"></li>
            </ul>
            <p class="copyright">piaf © 2020</p>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#plates').DataTable();
        } );
    </script>
</body>

</html>