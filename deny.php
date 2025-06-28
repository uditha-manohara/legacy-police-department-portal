<?php
session_start();
include 'db.php';
$user = $_SESSION['user'];
$id = (int)$_GET['id'];

$conn->query("UPDATE applications SET status='Denied', reviewer_id={$user['id']}, reviewed_at=NOW() WHERE id=$id");
echo "Application Denied. <a href='review_applications.php'>Go Back</a>";
?>
