<?php 
include 'func/is_auth.php';
include 'func/is_admin.php';
include 'connect.php';
$id = $_GET['id']? $_GET['id']: header('location: admin_user.php');
$stmt = $conn->prepare('SELECT * FROM users WHERE  id = ?');
$stmt->execute([$id]);
$profile = $stmt->fetch();

$page_name = 'Update user';
$msg_err = '';


if(isset($_POST['btn-submit'])) {
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];
    $fullname = $firstname.' '.$lastname;
   
    if($msg_err == '') {
        if(empty($_FILES['picture']['name'])) {
            if($password == '') {
                $stmt = $conn->prepare('UPDATE users SET role = ?, firstname = ?, lastname = ?, fullname =? WHERE id = ?');
                $stmt->execute([$role, $firstname, $lastname, $fullname, $_SESSION['user_id']]);
            }else {
                $stmt = $conn->prepare('UPDATE users SET role = ?, password = ? , firstname =? , lastname = ?, fullname = ? WHERE id = ? ');
                $stmt->execute([$role, $password, $firstname, $lastname, $fullname, $_SESSION['user_id']]);
            }
            $msg_suc = 'Updated successfully.'; 
        }else {
            $file = $_FILES['picture']['tmp_name'];
            $type = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $path = 'assets/image/profile/'.date('ymdhis').rand(1,10).'.'.$type;
            if(!move_uploaded_file($file, $path)) {
                $msg_err = 'failed upload file';
            }else {
                if($password == '') {
                    $stmt = $conn->prepare('UPDATE users SET role = ?, path = ?, firstname = ?, lastname = ?, fullname = ? WHERE id = ?');
                    $stmt->execute([$role, $path, $firstname, $lastname, $fullname, $_SESSION['user_id']]);
                }else {
                    $stmt = $conn->prepare('UPDATE users SET role = ?, password = ?, path = ?, firstname = ?, lastname = ?, fullname = ? WHERE id = ?');
                    $stmt->execute([$role, $password, $path, $firstname, $lastname, $fullname, $_SESSION['user_id']]);
                }
                $msg_suc = 'Updated successfully.'; 
            }
        }
    }
}

$role_arr = [0 => 'user', 1 => 'elector', 2 => 'admin'];
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
    <div class="d-flex justify-content-center align-items-center mt-5 w-100 h-100">
        <div class="card">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <h1 class="text-center">profile </h1>
                <hr>
                <div class="text-center">
                    <img class="rounded-2" src="<?= $profile['path'] ?>" width="250" height="250" alt=""  >
                    <br>
                    <p class="mt-2 text-muted"><?= $profile['fullname'] ?></p>
                </div>
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
                        <label for="firstname">firstname</label>
                        <input type="text" value="<?= $profile['firstname'] ?>"  name="firstname" class="form-control" id="">
                    </div>

                    <div class="col-md-4 mb-1">
                        <label for="lastname">lastname</label>
                        <input type="text" value="<?= $profile['lastname'] ?>" name="lastname" class="form-control" id="">
                    </div>

                    

                    <div class="col-md-4 mb-1">
                        <label for="username">username</label>
                        <input type="text" value="<?= $profile['username'] ?>" disabled name="username" class="form-control" id="">
                    </div>

                    <div class="col-md-4 mb-1">
                        <label for="password">new password</label>
                        <input type="password" name="password" class="form-control" id="">
                    </div>

               
                    <div class="col-md-4 mb-1">
                        <label for="picture">picture</label>
                        <input type="file" name="picture" class="form-control" accept="image/jpeg, image/png" id="">
                    </div>

                    <div class="col-md-4 mb-1">
                        <label for="role">Role</label>
                        <select name="role" class="form-select" name="" id="">
                            <?php foreach($role_arr as $key => $value){ ?>
                                <option <?= $profile['role'] == $key? 'selected': '' ?> value="<?= $key ?>"><?= $value ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </div>

                <div class="my-3 text-center">
                    <input type="submit" value="submit" name="btn-submit" class="btn btn-primary my-2 w-50">
                </div>


                
                
            </div>
        </form>
        
    </div>
    </div>
    
 
    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.esm.js"></script>
</body>
</html>