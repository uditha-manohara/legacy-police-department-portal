<?php
session_start();
include 'db.php';
$user = $_SESSION['user'];
$id = (int)$_GET['id'];

$app = $conn->query("SELECT * FROM applications WHERE id = $id")->fetch_assoc();
if (!$app) die("Not found");

$conn->query("UPDATE applications SET status='Accepted', reviewer_id={$user['id']}, reviewed_at=NOW() WHERE id=$id");

// Create user account
$stmt = $conn->prepare("INSERT INTO users (ingame_name, username, password, rank, is_admin, callsign) VALUES (?, ?, ?, 'Cadet', 0, '')");
$stmt->bind_param("sss", $app['full_name_ic'], $app['username'], $app['password']);
$stmt->execute();

echo "Application Accepted and User Created. <a href='review_applications.php'>Go Back</a>";
?>
