<?php
session_start();
include 'db.php';

$user = $_SESSION['user'] ?? null;
if (!$user) die("❌ You must be logged in.");

$id = intval($_GET['id']);
if ($id <= 0) die("❌ Invalid application ID.");

$stmt = $conn->prepare("SELECT * FROM applications WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$app = $stmt->get_result()->fetch_assoc();
if (!$app) die("❌ Application not found.");

$conn->begin_transaction();

try {
    // Insert into backup table
    $backup = $conn->prepare("
        INSERT INTO applications_reviewed 
        SELECT *, 'Accepted' AS action FROM applications WHERE id = ?");
    $backup->bind_param("i", $id);
    $backup->execute();

    // Create new user
    $create = $conn->prepare("INSERT INTO users (ingame_name, username, password, rank, is_admin, callsign) VALUES (?, ?, ?, 'Cadet', 0, '')");
    $create->bind_param("sss", $app['full_name_ic'], $app['username'], $app['password']);
    if (!$create->execute()) throw new Exception("User creation failed");

    // Delete original application
    $del = $conn->prepare("DELETE FROM applications WHERE id = ?");
    $del->bind_param("i", $id);
    $del->execute();

    $conn->commit();

    echo "✅ Application Accepted & User Created. <a href='application_log.php'>Go to Log</a>";
} catch (Exception $e) {
    $conn->rollback();
    error_log("accept.php error: " . $e->getMessage());
    die("❌ Error: " . $e->getMessage());
}
?>
