<?php 

include 'func/is_auth.php';
include 'connect.php';
$page_name = 'Home';
$stmt = $conn->prepare('SELECT electors.*,  users.* FROM electors LEFT JOIN users ON electors.user_id = users.id WHERE electors.disabled = ?');
$stmt->execute([0]);
$approve_arr = $stmt->fetchAll();
$count_approve_arr = $stmt->rowCount();

$stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
$chk_voted = $user['elected_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $root_name ?> - <?= $page_name ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/bootstrap.bundle.js"></script>
</head>
<body>
    <?php include 'layouts/header.php' ?>
    
    <div class="container mt-5">

    <!-- selected -->
    <?php if($chk_voted < 1)  { ?>
    <?php if($count_approve_arr < 1)  { ?>
            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body text-center">
                            <img src="assets/image/empty.png" width="100" height="100" alt="" srcset="">
                            <p class="mt-5 text-muted">Empty Data.</p>
                        </div>
                    </div>
                </div>
            </div>
    <?php }else { ?>
        <?php foreach($approve_arr as $value) { ?>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="row">
                        
                        <div class="col-md-7">
                            <div class="card-body">
                                <h2><?= $value['fullname'] ?></h2>
                                <p class="text-muted"><?= $value['note'] ?></p>
                                <hr class="mt-5">
                                <p>score: <span class="text-muted"><?= $value['vote'] ?></span></p>
                                <div class="btn-group">
                                    <a href="user_elector_vote.php?elector_id=<?= $value['id'] ?>&id=<?= $_SESSION['user_id'] ?>" class="btn btn-outline-success">vote</a>
                                    <a href="user_elector_detail.php?id=<?= $value['user_id'] ?>" class="btn btn-outline-secondary">detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 overflow-hidden">
                            <img src="<?= $value['path']  ?>" width="100%" height="250" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    <?php }else{ ?>
    <!-- end selected -->
        <div class="row">
            <div class="col-md-8">
                <?php
                    $stmt = $conn->prepare('SELECT electors.*,  users.* FROM electors LEFT JOIN users ON electors.user_id = users.id WHERE electors.user_id = ?');
                    $stmt->execute([$chk_voted]);
                    $voted = $stmt->fetch();
                ?>
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body text-center">
                                <img src="<?= $voted['path'] ?>" class="rounded-2" width="400" height="400" alt="" srcset="">
                                <h2><?= $voted['fullname'] ?></h2>
                                <p class="text-muted"><?= $voted['note'] ?></p>
                                <hr class="mt-5">
                                <p>score: <span class="text-muted"><?= $voted['vote'] ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php foreach($approve_arr as $value) {?>
            <div class="col-md-4">
                <div class="card">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card-body">
                                <h2><?= $value['fullname'] ?></h2>
                                <p class="text-muted"><?= $value['note'] ?></p>
                                <hr class="mt-5">
                                <p>score: <span class="text-muted"><?= $value['vote'] ?></span></p>
                            </div>
                        </div>
                        <div class="col-md-5 overflow-hidden">
                            <img src="<?= $value['path']  ?>" width="100%" height="250" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    <?php } ?>
    </div>

    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.esm.js"></script>
</body>
</html>