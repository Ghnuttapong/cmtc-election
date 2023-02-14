<?php 

include 'func/is_auth.php';
include 'func/is_admin.php';
include 'connect.php';
$page_name = 'Election';
$stmt = $conn->prepare('SELECT * FROM electors LEFT JOIN users ON electors.user_id = users.id WHERE electors.disabled = ?');
$stmt->execute([1]);
$inapprove_arr = $stmt->fetchAll();
$count_inapprove_arr = $stmt->rowCount();

$stmt = $conn->prepare('SELECT * FROM electors LEFT JOIN users ON electors.user_id = users.id WHERE electors.disabled = ?');
$stmt->execute([0]);
$approved_arr = $stmt->fetchAll();
$count_approved_arr = $stmt->rowCount();
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
        <div class="row">
            <!-- approve -->
            <div class="col-md-6">
                <h4>Approved</h4>
                <hr>
                <?php if($count_approved_arr < 1) { ?>
                <div class="row">
                    <div class="card">
                        <div class="col-md-12">
                            <div class="card-body text-center">
                                <img src="assets/image/empty.png" width="100" height="100" alt="" srcset="">
                                <p class="mt-5 text-muted">Empty Data.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }else{ ?>
                <?php foreach($approved_arr as $value) { ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card rounded-top">
                                <div class="overflow-hidden">
                                    <img src="<?= $value['path'] ?>" width="200" height="200" alt="" srcset="">
                                </div>
                                <div class="card-body">
                                        <span class="text-success">Approved</span>
                                        <p class="my-1"><?= $value['fullname'] ?></p>
                                        <hr>
                                        <span class="text-muted">Username <?= $value['username'] ?></span>
                                        <div class="overflow-hidden">
                                            <a href="admin_election_approve.php?action=unapprove&id=<?= $value['id'] ?>">
                                                <img src="assets/image/cancel.jpg" width="20" height="20"  alt="" srcset="">
                                                <span>Unapprove</span>
                                            </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php } ?>
            </div>
            <!-- inapprove -->
            <div class="col-md-6">  
                <h4>Pending</h4>
                <hr>
                <?php if($count_inapprove_arr < 1) { ?>
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
                <?php }else{ ?>
                <?php foreach($inapprove_arr as $value) { ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card rounded-top">
                                    <div class="overflow-hidden">
                                        <img src="<?= $value['path'] ?>" width="200" height="200" alt="" srcset="">
                                    </div>
                                    <div class="card-body">
                                            <span class="text-warning">Pending</span>
                                            <p class="my-1"><?= $value['fullname'] ?></p>
                                            <hr>
                                            <span class="text-muted">Username <?= $value['username'] ?></span>
                                            <div class="overflow-hidden">
                                                <a href="admin_election_approve.php?action=approve&id=<?= $value['id'] ?>">
                                                    <img src="assets/image/corrate.jpg" width="20" height="20"  alt="" srcset="">
                                                    <span>Approve</span>
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    
    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.esm.js"></script>
</body>
</html>