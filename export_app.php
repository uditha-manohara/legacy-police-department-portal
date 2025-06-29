<?php
// File: export_app.php
session_start();
include 'db.php';

$user = $_SESSION['user'] ?? null;
$can_export = $user && in_array($user['rank'], [
    'Chief', 'Deputy Chief', 'Commander', 'Lieutenant', 'Sergeant', 'Corporal'
]);

if (!$can_export) {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'])) {
    $id = intval($_POST['application_id']);
    $app = $conn->query("SELECT * FROM applications WHERE id = $id")->fetch_assoc();

    if (!$app) {
        die("Application not found.");
    }

    $filename = "application_{$app['username']}_{$app['id']}.txt";

    header('Content-Type: text/plain');
    header("Content-Disposition: attachment; filename=\"$filename\"");

    echo "=== LSPD Application ===\n\n";
    echo "--- OOC Info ---\n";
    echo "Full Name: {$app['full_name_ooc']}\n";
    echo "Gender: {$app['gender']}\n";
    echo "Birthday: {$app['birthday']}\n";
    echo "Whatsapp: {$app['whatsapp']}\n";
    echo "Email: {$app['email']}\n";
    echo "Discord: {$app['discord']}\n";
    echo "MTA Serial: {$app['mta_serial']}\n";
    echo "Character Slot: {$app['character_slot']}\n";
    echo "Gang Member: {$app['gang_member']}\n";
    echo "Microphone: {$app['mic']}\n\n";

    echo "--- IC Info ---\n";
    echo "IC Name: {$app['full_name_ic']}\n";
    echo "Age: {$app['age']}\n";
    echo "Backstory:\n{$app['backstory']}\n\n";
    echo "Reason to Join:\n{$app['reason_to_join']}\n\n";
    echo "Duty Hours: {$app['duty_hours']}\n";
    echo "Workshift: {$app['workshift']}\n\n";

    echo "--- Login Info ---\n";
    echo "Username: {$app['username']}\n";
    echo "Password (hashed): {$app['password']}\n\n";

    echo "--- Application Meta ---\n";
    echo "Status: {$app['status']}\n";
    echo "Submitted: {$app['created_at']}\n";
    echo "Reviewed By (ID): {$app['reviewer_id']}\n";
    echo "Reviewed At: {$app['reviewed_at']}\n";
    exit();
} else {
    die("Invalid request.");
}
