<?php 

include 'func/is_auth.php';
include 'func/is_elector.php';
include 'connect.php';
$page_name = 'Home';

$stmt = $conn->prepare('SELECT * FROM electors LEFT JOIN users ON electors.user_id = users.id WHERE electors.user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$fetch = $stmt->fetch();
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
        <div class="col-12">
           <div class="row">
               <div class="col-8 text-center">
                   <div class="col-12">
                     <h4><?= $fetch['fullname'] ?></h4>
                   </div>
                   <div class="col-12">
                        <img src="<?= $fetch['path'] ?>" class="rounded-2 shadow-1" alt="" width="350px" height="400">
                   </div>
                   <div class="col-12 my-2">
                       <h3>MY SCORE : <span class="text-success"><?= $fetch['vote'] ?> </span> </h3>
                   </div>
               </div>
               <div class="col-4">
                 <div class="col-12 text-center">
                     <h5>Note</h5>
                 </div>
                 <p><?= $fetch['note'] == null ? '-': $fetch['note'] ?></p>
               </div>
           </div>

        </div>
    </div>
    </div>
    
    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.esm.js"></script>
</body>
</html>