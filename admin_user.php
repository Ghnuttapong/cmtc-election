<?php 

include 'func/is_auth.php';
include 'func/is_admin.php';
include 'connect.php';
$page_name = 'Management User';

$stmt = $conn->prepare('SELECT * FROM users WHERE deleted_at is null');
$stmt->execute();
$user_arr = $stmt->fetchAll();
$count_user_arr = $stmt->rowCount();

$stmt = $conn->prepare('SELECT * FROM users WHERE deleted_at is not null');
$stmt->execute();
$user_arr_del = $stmt->fetchAll();
$count_user_arr_del = $stmt->rowCount();

if(isset($_POST['btn-del'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare('UPDATE users SET deleted_at = ? WHERE id = ?');
    $stmt->execute([date('YmdHis'), $id]);
    $msg_suc_del = 'Deleted successful';
    header('refresh:0;');
}
if(isset($_POST['btn-recover'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare('UPDATE users SET deleted_at = ? WHERE id = ?');
    $stmt->execute([null, $id]);
    $msu_suc_recover = 'Recover successful';
    header('refresh:0;');
}

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
        <div class="text-end">
            <a href="admin_user_add.php">
                <img src="assets/image/Add.png" width="50" height="50" alt="">
            </a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3>All</h3>
                <hr>
                    <?php if(isset($msg_suc)) { ?>
                        <div class="alert alert-success">
                            <strong><?= $msg_suc ?></strong>
                        </div>
                    <?php } ?>
                <?php if($count_user_arr == 0) { ?>
                <!-- empty data -->
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
                <!-- empty data -->
                <?php } else {?>

                    <!-- loop unremove -->
                    <div class="row">
                        <?php foreach($user_arr as $value){ ?>
                            <?php if($value['id'] == $_SESSION['user_id']) continue; ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img src="<?= $value['path'] ?>" width="100%" height="150" alt="">
                                    <div class="card-body">
                                    <h5><?= $value['fullname'] ?></h5>
                                    <p class="text-muted">User: <?= $value['username'] ?></p>
                                    <hr class="mt-5">
                                    <p>Role: 
                                        <?php if($value['role'] == 0){ ?>
                                        <span class="text-muted">User</span>
                                        <?php } ?>
                                        <?php if($value['role'] == 1){ ?>
                                        <span class="text-success">Elector</span>
                                        <?php } ?>
                                        <?php if($value['role'] == 2){ ?>
                                        <span class="text-primary">Admin</span>
                                        <?php } ?>
                                    </p>
                                    <form action="" method="post">
                                        <div class="btn-group w-100">
                                                <a href="admin_user_update.php?id=<?= $value['id'] ?>" class="btn btn-outline-secondary">Edit</a>
                                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                <input type="submit" name="btn-del" onclick="return confirm('Are you sure you delete a <?= $value['fullname'] ?>')" value="Del" class="btn btn-outline-danger">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                    <!-- end loop -->
            </div>
        <div class="col-md-6">
                <h3>Deleted</h3>
                <hr>
                <?php if(isset($msg_suc)) { ?>
                    <div class="alert alert-success">
                        <strong><?= $msg_suc ?></strong>
                    </div>
                <?php } ?>
                <?php if($count_user_arr_del == 0) { ?>  
                <!-- empty data -->
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
                <!-- empty data -->
                <?php } else {?>
                <!-- loop unremove -->
                <div class="row">
                    <?php foreach($user_arr_del as $value){ ?>
                        <?php if($value['id'] == $_SESSION['user_id']) continue; ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?= $value['path'] ?>" width="100%" height="150" alt="">
                                <div class="card-body">
                                <h5><?= $value['fullname'] ?></h5>
                                <p class="text-muted">User: <?= $value['username'] ?></p>
                                <hr class="mt-5">
                                <p>Role: 
                                    <?php if($value['role'] == 0){ ?>
                                    <span class="text-muted">User</span>
                                    <?php } ?>
                                    <?php if($value['role'] == 1){ ?>
                                    <span class="text-success">Elector</span>
                                    <?php } ?>
                                    <?php if($value['role'] == 2){ ?>
                                    <span class="text-primary">Admin</span>
                                    <?php } ?>
                                </p>
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                    <input type="submit" name="btn-recover" value="Recover" class="btn btn-outline-success">
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
                <!-- end loop -->
            </div>
        </div>
    </div>
    

    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.esm.js"></script>
</body>
</html>