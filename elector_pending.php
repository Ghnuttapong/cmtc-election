<?php 

include 'func/is_auth.php';
include 'func/is_elector.php';
include 'connect.php';
$page_name = 'Dashboard';
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
<body style="height: 100vh; width:100vw" class="d-flex justify-content-center align-items-center">
    
    <div class="container">
        <div class="card text-center p-5">
            <h3 class="text-danger">Status your is Pending</h3>
            <p class="my-2 text-muted"><?= $_SESSION['user_fullname'] ?></p>
            <hr>
            <div class="text-center">
                <a href="auth_logout.php" class="w-50 btn btn-outline-secondary">Logout</a>
            </div>
        </div>
    </div> 

    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.esm.js"></script>
</body>
</html>