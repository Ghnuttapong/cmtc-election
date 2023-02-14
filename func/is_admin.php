<?php 
    if($_SESSION['user_role'] != 2) {
        header('location: auth_login.php');
    }

?>