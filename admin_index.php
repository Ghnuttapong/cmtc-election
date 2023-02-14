<?php 

include 'func/is_auth.php';
include 'func/is_admin.php';
include 'connect.php';
$page_name = 'Dashboard';

$stmt = $conn->prepare('SELECT * FROM users WHERE elected_id > ? ');
$stmt->execute([0]);
$fetch = $stmt->fetchAll();
$count_fetch = $stmt->rowCount();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $root_name ?> - <?= $page_name ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.js"></script>
</head>
<body>
    <?php include 'layouts/header.php' ?>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary">
                    <div class="card-body text-white">

    ผู้มาใช้สิทธิ                        <strong><?= $count_fetch ?></strong> คน
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.esm.js"></script>
</body>
</html>