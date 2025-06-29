<?php
session_start();
include 'db.php';

$user = $_SESSION['user'] ?? null;
$can_view_logs = $user && in_array($user['rank'], [
    'Chief', 'Deputy Chief', 'Commander', 'Lieutenant', 'Sergeant', 'Corporal', 'Legacy Staff'
]);

if (!$can_view_logs) die("Access denied. This page is only for high-ranking officers.");

$pending = $conn->query("
    SELECT 
        id, full_name_ooc, gender, birthday, whatsapp, email, discord, 
        mta_serial, character_slot, gang_member, mic,
        full_name_ic, age, backstory, reason_to_join, duty_hours, workshift,
        username, password, status, reviewer_id, reviewed_at, created_at,
        'Pending' AS action
    FROM applications
");

$reviewed = $conn->query("
    SELECT 
        id, full_name_ooc, gender, birthday, whatsapp, email, discord, 
        mta_serial, character_slot, gang_member, mic,
        full_name_ic, age, backstory, reason_to_join, duty_hours, workshift,
        username, password, status, reviewer_id, reviewed_at, created_at,
        action
    FROM applications_reviewed
");


$apps = [];
while ($row = $pending->fetch_assoc()) $apps[] = $row;
while ($row = $reviewed->fetch_assoc()) $apps[] = $row;

$total = count($apps);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Applications Log</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-3">All Applications (Pending, Accepted & Denied)</h2>
    <p>Total applications in DB: <strong><?= $total ?></strong></p>

    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
        </div>
        <div class="col-md-6">
            <select id="statusFilter" class="form-select">
                <option value="">Filter by Status: All</option>
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
                <option value="denied">Denied</option>
            </select>
        </div>
    </div>

    <div class="accordion" id="appAccordion">
        <?php $i = 0; foreach ($apps as $app): $i++; ?>
            <div class="accordion-item mb-2 app-item" data-status="<?= strtolower($app['action']) ?>">
                <h2 class="accordion-header" id="heading<?= $i ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>">
                        <?= htmlspecialchars($app['full_name_ic']) ?> - <?= $app['action'] ?>
                    </button>
                </h2>
                <div id="collapse<?= $i ?>" class="accordion-collapse collapse" data-bs-parent="#appAccordion">
                    <div class="accordion-body">
                        <strong>OOC Info:</strong><br>
                        Name: <?= htmlspecialchars($app['full_name_ooc']) ?><br>
                        Gender: <?= $app['gender'] ?><br>
                        Birthday: <?= $app['birthday'] ?><br>
                        Whatsapp: <?= $app['whatsapp'] ?><br>
                        Email: <?= $app['email'] ?><br>
                        Discord: <?= $app['discord'] ?><br>
                        MTA Serial: <?= $app['mta_serial'] ?><br>
                        Character Slot: <?= $app['character_slot'] ?><br>
                        Gang Member: <?= $app['gang_member'] ?><br>
                        Microphone: <?= $app['mic'] ?><br><br>

                        <strong>IC Info:</strong><br>
                        IC Name: <?= $app['full_name_ic'] ?><br>
                        Age: <?= $app['age'] ?><br>
                        Backstory:<div class="border p-2 bg-light"><?= nl2br(htmlspecialchars($app['backstory'])) ?></div>
                        Reason to Join:<div class="border p-2 bg-light"><?= nl2br(htmlspecialchars($app['reason_to_join'])) ?></div><br>
                        Duty Hours: <?= $app['duty_hours'] ?><br>
                        Workshift: <?= $app['workshift'] ?><br><br>

                        <strong>Login Info:</strong><br>
                        Username: <?= $app['username'] ?><br>
                        Password (hashed): <?= $app['password'] ?><br><br>

                        <strong>Status:</strong> <?= $app['action'] ?><br>
                        <strong>Reviewed At:</strong> <?= $app['reviewed_at'] ?? '-' ?><br>
                        <strong>Reviewed By ID:</strong> <?= $app['reviewer_id'] ?? '-' ?><br>
                        <strong>Submitted:</strong> <?= $app['created_at'] ?><br>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="dashboard.php" class="btn btn-secondary mt-4">Back to Dashboard</a>
</div>

<script>
    function filterApps() {
        const search = $("#searchInput").val().toLowerCase();
        const status = $("#statusFilter").val();

        $(".app-item").each(function () {
            const text = $(this).text().toLowerCase();
            const appStatus = $(this).data("status");

            const matchSearch = text.includes(search);
            const matchStatus = !status || appStatus === status;

            $(this).toggle(matchSearch && matchStatus);
        });
    }

    $("#searchInput").on("keyup", filterApps);
    $("#statusFilter").on("change", filterApps);
</script>
</body>
</html>
