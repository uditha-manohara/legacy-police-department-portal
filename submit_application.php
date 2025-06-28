<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

// Rebuild full form data
$data = unserialize(base64_decode($_POST['data'] ?? ''));

$data['username'] = $_POST['username'] ?? null;
$data['password'] = $_POST['password'] ?? null;

if (empty($data['username']) || empty($data['password'])) {
    die("Missing username or password. Please complete the final step of the application.");
}

$workshift = isset($data['workshift']) ? implode(",", $data['workshift']) : '';
$passwordHash = hash('sha256', $data['password']);

$stmt = $conn->prepare("INSERT INTO applications (
    full_name_ooc, gender, birthday, whatsapp, email, discord, mta_serial, character_slot, gang_member, mic,
    full_name_ic, age, backstory, reason_to_join, duty_hours, workshift,
    username, password
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssssssssssssss",
    $data['full_name_ooc'], $data['gender'], $data['birthday'], $data['whatsapp'], $data['email'],
    $data['discord'], $data['mta_serial'], $data['character_slot'], $data['gang_member'], $data['mic'],
    $data['full_name_ic'], $data['age'], $data['backstory'], $data['reason'], $data['duty_hours'], $workshift,
    $data['username'], $passwordHash
);

$stmt->execute();

echo "<div style='padding: 20px; font-family: Arial; text-align:center'>✅ Application submitted successfully. You’ll hear back within 72 hours.</div>";
