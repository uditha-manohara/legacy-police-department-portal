<?php
session_start();
// Auto logout after 30 minutes (1800 seconds)
$timeout_duration = 1800;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: index.php?timeout=1");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

include 'db.php';
if (!isset($_SESSION['user']))
    header("Location: index.php");
$user = $_SESSION['user'];
$target_id = $_GET['id'];

// Get target user's username for header
$stmt = $conn->prepare("SELECT username FROM users WHERE id=?");
$stmt->bind_param("i", $target_id);
$stmt->execute();
$target_user = $stmt->get_result()->fetch_assoc();

// Permission check
$can_warn = in_array($user['rank'], ['Chief', 'Deputy Chief', 'Commander', 'Lieutenant', 'Sergeant', 'Corporal', 'Legacy Staff']);

// Handle new warning submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $can_warn) {
    $warn = $_POST['warning'];
    $stmt = $conn->prepare("INSERT INTO rule_breaks (user_id, warning, added_by) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $target_id, $warn, $user['id']);
    $stmt->execute();
}

// Handle delete
if (isset($_GET['del']) && $user['is_admin']) {
    $conn->query("DELETE FROM rule_breaks WHERE id = " . intval($_GET['del']));
    header("Location: rule_breaks.php?id=$target_id");
    exit;
}

// Fetch rule_break logs for this user
$logs = $conn->query("
    SELECT r.id, r.warning, r.created_at, u.rank, u.ingame_name
    FROM rule_breaks r
    JOIN users u ON u.id = r.added_by
    WHERE r.user_id = $target_id
    ORDER BY r.created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Warnings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>
<body class="bg-light">
    <div class="container py-4">
        <h3>Rule Breaks for <?= htmlspecialchars($target_user['username']) ?></h3>
        <?php if ($can_warn): ?>
            <form method="POST" class="mb-3">
                <textarea name="warning" class="form-control" required placeholder="Add warning..."></textarea>
                <button class="btn btn-danger mt-2">Add</button>
            </form>
        <?php endif; ?>

        <?php while ($row = $logs->fetch_assoc()): ?>
            <div class="alert alert-warning">
                <strong>[<?= htmlspecialchars($row['rank']) ?>] <?= htmlspecialchars($row['ingame_name']) ?></strong>: <?= htmlspecialchars($row['warning']) ?>
                <br><small><?= htmlspecialchars($row['created_at']) ?></small>
                <?php if ($user['is_admin']): ?>
                    <a href="?id=<?= $target_id ?>&del=<?= $row['id'] ?>" class="btn-close float-end"></a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>

        <a href="dashboard.php" class="btn btn-secondary mt-3">Back</a>
    </div>
    <script>
        let idleTime = 0;
        setInterval(() => {
            idleTime++;
            if (idleTime > 30) location.href = 'logout.php';
        }, 60000); // 1 minute

        document.onmousemove = document.onkeypress = () => {
            idleTime = 0;
        };
    </script>
</body>
</html>
