<?php
// File: review_applications.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

$user = $_SESSION['user'] ?? null;
$can_accept = $user && in_array($user['rank'], [
    'Chief', 'Deputy Chief', 'Commander', 'Lieutenant', 'Sergeant', 'Corporal', 'Legacy Staff'
]);

if (!$can_accept) {
    die("Access denied. This page is only for high-ranking officers.");
}

$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appId = intval($_POST['application_id']);
    $action = $_POST['action'] ?? '';

    // Fetch application safely
    $result = $conn->query("SELECT * FROM applications WHERE id = $appId");
    if (!$result || $result->num_rows === 0) {
        $errorMsg = "Application not found.";
    } else {
        $app = $result->fetch_assoc();

        if ($action === 'accept') {
            // Check for duplicate username
            $checkUser = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $checkUser->bind_param("s", $app['username']);
            $checkUser->execute();
            $checkUser->store_result();

            if ($checkUser->num_rows > 0) {
                $errorMsg = "Error: Username '" . htmlspecialchars($app['username']) . "' is already taken. Cannot accept this application.";
                $checkUser->close();
            } else {
                $checkUser->close();

                $stmt = $conn->prepare("INSERT INTO users (username, password, ingame_name, rank) VALUES (?, ?, ?, 'Cadet')");
                if (!$stmt) {
                    $errorMsg = "Prepare failed: " . $conn->error;
                } else {
                    $stmt->bind_param("sss", $app['username'], $app['password'], $app['full_name_ic']);
                    if (!$stmt->execute()) {
                        $errorMsg = "Insert error: " . $stmt->error;
                    }
                    $stmt->close();

                    if (!$errorMsg) {
                        $conn->query("DELETE FROM applications WHERE id = $appId");
                        header("Location: review_applications.php");
                        exit();
                    }
                }
            }
        } elseif ($action === 'deny') {
            $conn->query("DELETE FROM applications WHERE id = $appId");
            header("Location: review_applications.php");
            exit();
        }
    }
}

// Fetch pending applications
$applications = $conn->query("SELECT * FROM applications ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Pending LCPD Applications</h2>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= $errorMsg ?></div>
    <?php endif; ?>

    <?php if ($applications && $applications->num_rows > 0): ?>
        <div class="accordion" id="applicationAccordion">
            <?php $i = 0; while ($app = $applications->fetch_assoc()): $i++; ?>
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="heading<?= $i ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>">
                            <?= htmlspecialchars($app['full_name_ic']) ?> (Username: <?= htmlspecialchars($app['username']) ?>)
                        </button>
                    </h2>
                    <div id="collapse<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $i ?>" data-bs-parent="#applicationAccordion">
                        <div class="accordion-body">
                            <strong>OOC Info:</strong><br>
                            Full Name: <?= htmlspecialchars($app['full_name_ooc']) ?><br>
                            Gender: <?= htmlspecialchars($app['gender']) ?><br>
                            Birthday: <?= htmlspecialchars($app['birthday']) ?><br>
                            Whatsapp: <?= htmlspecialchars($app['whatsapp']) ?><br>
                            Email: <?= htmlspecialchars($app['email']) ?><br>
                            Discord: <?= htmlspecialchars($app['discord']) ?><br>
                            MTA Serial: <?= htmlspecialchars($app['mta_serial']) ?><br>
                            Character Slot: <?= htmlspecialchars($app['character_slot']) ?><br>
                            Gang Member: <?= htmlspecialchars($app['gang_member']) ?><br>
                            Microphone: <?= htmlspecialchars($app['mic']) ?><br><br>

                            <strong>IC Info:</strong><br>
                            IC Name: <?= htmlspecialchars($app['full_name_ic']) ?><br>
                            Age: <?= htmlspecialchars($app['age']) ?><br>
                            Backstory: <div class="border p-2 bg-light"><?= nl2br(htmlspecialchars($app['backstory'])) ?></div>
                            Reason to Join: <div class="border p-2 bg-light"><?= nl2br(htmlspecialchars($app['reason_to_join'])) ?></div><br>
                            Duty Hours: <?= htmlspecialchars($app['duty_hours']) ?><br>
                            Workshift: <?= htmlspecialchars($app['workshift']) ?><br><br>

                            <strong>Login Info:</strong><br>
                            Username: <?= htmlspecialchars($app['username']) ?><br>
                            Password (hashed): <?= htmlspecialchars($app['password']) ?><br><br>

                            <form method="POST" class="d-flex gap-2">
                                <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                                <button name="action" value="accept" class="btn btn-success" onclick="return confirm('Are you sure you want to accept this application?')">Accept</button>
                                <button name="action" value="deny" class="btn btn-danger" onclick="return confirm('Are you sure you want to deny this application?')">Deny</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No pending applications found.</div>
    <?php endif; ?>
</div>
</body>
</html>
