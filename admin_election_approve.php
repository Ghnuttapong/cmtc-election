<?php 

include 'connect.php';
$id = $_GET['id']? $_GET['id'] : header('location: admin_election.php');
$action = $_GET['action']? $_GET['action'] : header('location: admin_election.php');

if($action == 'approve') {
    $stmt = $conn->prepare('UPDATE electors SET disabled = ? WHERE user_id = ?');
    $stmt->execute([0, $id]);
}else {
    $stmt = $conn->prepare('UPDATE electors SET disabled = ? WHERE user_id = ?');
    $stmt->execute([1, $id]);
}

header('location: admin_election.php');
?>