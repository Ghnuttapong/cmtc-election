<?php 

session_start();
include 'connect.php';
$page_name = 'Home';
$msg_err = '';

if(isset($_POST['btn-login'])) {
    foreach($_POST as $value) {
        if($value == '') {
            $msg_err = 'Please compleate all.';
        }
    }
    if($msg_err == '') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
        $stmt->execute([$username, $password]);
        $chk = $stmt->rowCount();
        $fetch = $stmt->fetch();
        if($chk < 1){
            $msg_err = 'Invalid '. $username .'.';
        }else {
            $msg_suc = 'Welcome '.$username.'.';
            $_SESSION['user_id'] = $fetch['id'];
            $_SESSION['user_role'] = $fetch['role'];
            $_SESSION['user_fullname'] = $fetch['fullname'];

            if($fetch['role'] == 0) {
                header('refresh:1; url = user_index.php');
            }
            if($fetch['role'] == 1) {
                $stmt = $conn->prepare('SELECT * FROM electors WHERE user_id = ?');
                $stmt->execute([$fetch['id']]);
                $chk_disabled = $stmt->fetch();
                if($chk_disabled['disabled']) {
                    header('refresh:1; url = elector_pending.php');
                }else{
                    header('refresh:1; url = elector_index.php');
                }
            }
            if($fetch['role'] == 2) {
                header('refresh:1; url = admin_index.php');
            }
        }
    }
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
    <script src="assets/js/bootstrap.bundle.js"></script>
</head>
<body style="height: 100vh; width:100vw" class="d-flex justify-content-center align-items-center">


    <div class="card">
        <form action="" method="post">
            <div class="card-body">
                <h1 class="text-center">Login</h1>
                <hr>
                <?php if($msg_err != '') { ?>
                    <div class="alert alert-danger">
                        <strong><?= $msg_err ?></strong>
                    </div>
                <?php } ?>
                <?php if(isset($msg_suc)) { ?>
                    <div class="alert alert-success">
                        <strong><?= $msg_suc ?></strong>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="">
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="">
                </div>

                <div class="mb-3">
                    <input type="submit" value="Login" name="btn-login" class="btn btn-primary w-100">
                </div>


                <div class="mb-3">
                    <a href="auth_register.php">Register Now.</a>
                    <br>
                    <a href="auth_forgot.php">Forgot password?</a>
                </div>
                
            </div>
        </form>
        
    </div>

    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.esm.js"></script>
</body>
</html>