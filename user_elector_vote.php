<?php 

include 'connect.php';
$id = $_GET['id'] ? $_GET['id']: header('location: user_index.php');
$elector = $_GET['elector_id'] ? $_GET['elector_id']: header('location: user_index.php');

$stmt = $conn->prepare('UPDATE users SET elected_id = ? WHERE id = ?');
$stmt->execute([$elector, $id]);

$stmt = $conn->prepare('SELECT * FROM electors WHERE id = ?');
$stmt->execute([$elector]);
$vote = $stmt->fetch();
$new_score = $vote['vote'] + 1;

$stmt = $conn->prepare('UPDATE electors SET vote = ? WHERE id = ?');
$stmt->execute([$new_score, $elector]);

header('location: user_index.php');
?>