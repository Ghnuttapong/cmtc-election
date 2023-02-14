<?php 

include 'func/is_auth.php';
include 'func/is_admin.php';
include 'connect.php';
$page_name = 'Add User';
$msg_err = '';
if(isset($_POST['btn-add'])) {
     foreach($_POST as $value) {
            if($value == '') {
                $msg_err = 'Please compleate all!';
            }
            continue;
        }
        if(empty($_FILES['picture'])) {
            $msg_err = 'Empty picture';
        }else {
            if($msg_err == '') {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $password_con = $_POST['password_con'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $role = $_POST['role'];
                $fullname = $firstname.' '.$lastname;
                if($password != $password_con) {
                    $msg_err = 'Password your don\' match';
                }else {
                    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
                    $stmt->execute([$username]);
                    $chk_exists = $stmt->rowCount();
                    if($chk_exists > 0){
                        $msg_err = 'Username already exists';
                    }else {
                        $file = $_FILES['picture']['tmp_name'];
                        $type = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                        $path = 'assets/image/profile/'.date('YmdHis').rand(1,10).'.'.$type;
                        if(!move_uploaded_file($file, $path)) {
                            $msg_err = 'Fail upload file';
                        }else {

                            $stmt = $conn->prepare('INSERT INTO users(username, password, firstname, lastname, fullname, path, role) VALUE(?, ?, ?, ?, ?, ?, ?)');
                            $result = $stmt->execute([$username, $password, $firstname, $lastname, $fullname, $path, $role]);
                            if($result) {
                                $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
                                $stmt->execute([$username]);
                                $fetch= $stmt->fetch();
                                if($role == 1) {
                                    $stmt = $conn->prepare('INSERT INTO electors(user_id) VALUE(?)');
                                    $stmt->execute([$fetch['id']]);
                                }
                                $msg_suc = '<a href="auth_login.php">Login Now.</a>'; 
                            } 
                        }
                    }
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
<body>
    <?php include 'layouts/header.php' ?>
    
    <div class="container mt-5">
    <div class="card">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <h1 class="text-center">Add User</h1>
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
                <div class="row">

                    <div class="col-md-4 mb-1">
                        <label for="firstname">Firstname</label>
                        <input type="text" name="firstname" class="form-control" id="">
                    </div>

                    <div class="col-md-4 mb-1">
                        <label for="lastname">Lastname</label>
                        <input type="text" name="lastname" class="form-control" id="">
                    </div>

                    

                    <div class="col-md-4 mb-1">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="">
                    </div>

                    <div class="col-md-4 mb-1">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="">
                    </div>

                    <div class="col-md-4 mb-1">
                        <label for="password_con">Confirm password</label>
                        <input type="password" name="password_con" class="form-control" id="">
                    </div>

                    <div class="col-md-4 mb-1">
                        <label for="role">Role</label>
                        <select name="role" id="" class="form-select">
                            <option value="0">User</option>
                            <option value="1">Elector</option>
                            <option value="2">Admin</option>
                        </select> 
                    </div>

                    <div class="col-md-4 mb-1">
                        <label for="picture">Profile</label>
                        <input type="file" name="picture" class="form-control" accept="image/jpeg, image/png" id="">
                    </div>

                </div>

                <div class="my-3 text-center">
                    <input type="submit" name="btn-add" class="btn btn-primary my-2 w-50">
                    <br>
                </div>


                
                
            </div>
        </form>
        
    </div>
    </div>

    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.esm.js"></script>
</body>
</html>