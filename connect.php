<?php 

    $server_host = 'localhost';
    $server_name = 'election';
    $server_user = 'skill';
    $server_pass = '4321';
    $root_name = 'Election';

    try {
        $conn = new PDO("mysql:host=$server_host;dbname=$server_name", $server_user, $server_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec('set names utf8');
    } catch(PDOException $e) {
        echo $e->getMessage();
    }


?>