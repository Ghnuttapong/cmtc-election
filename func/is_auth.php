<?php 

    session_start();
    if($_SESSION['user_id'] == '') {
        header('location: auth_login.php');
    }

?>