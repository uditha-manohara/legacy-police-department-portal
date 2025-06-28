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
$user = $_SESSION['user'];
$id = $user['id'];

$query = "SELECT w.id, w.content, w.created_at, u.username AS from_user 
          FROM warnings w 
          JOIN users u ON u.id = w.from_user_id 
          WHERE w.to_user_id = $id ORDER BY w.created_at DESC";
$result = $conn->query($query);

if (isset($_GET['del']) && $user['is_admin']) {
    $warn_id = intval($_GET['del']);
    $conn->query("DELETE FROM warnings WHERE id = $warn_id AND from_user_id = $id");
    header("Location: my_warnings.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Warnings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />

</head>

<body class="bg-light">
    <div class="container py-4">
        <h3>Your Warnings</h3>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="alert alert-warning">
                <strong>From:</strong> <?= $row['from_user'] ?><br>
                <?= $row['content'] ?><br>
                <small><i><?= $row['created_at'] ?></i></small>
                <?php if ($user['is_admin']): ?>
                    <a href="?del=<?= $row['id'] ?>" class="btn-close float-end"></a>
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