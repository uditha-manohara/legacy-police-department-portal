<?php
session_start();
// Auto logout after 30 minutes (1800 seconds)
$timeout_duration = 1800;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();     // Unset $_SESSION
    session_destroy();   // Destroy session
    header("Location: index.php?timeout=1");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1)
    header("Location: index.php");

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: dashboard.php");
exit;
