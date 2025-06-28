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

$can_warn = in_array($user['rank'], ['Chief', 'Deputy Chief', 'Commander', 'Lieutenant', 'Sergeant', 'Corporal', 'Legacy Staff']);
if (!$can_warn)
    die("Unauthorized");

$members = $conn->query("SELECT * FROM users WHERE id != {$user['id']}");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $to_id = $_POST['to_user_id'];
    $content = $_POST['content'];
    $stmt = $conn->prepare("INSERT INTO warnings (from_user_id, to_user_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user['id'], $to_id, $content);
    $stmt->execute();

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Warning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />

</head>

<body class="bg-light">
    <div class="container py-5">
        <h3>Issue a Warning</h3>
        <form method="POST" class="bg-white p-4 shadow rounded">
            <label>User to Warn:</label>
            <select name="to_user_id" class="form-control mb-3" required>
                <option value="">-- Select User --</option>
                <?php while ($m = $members->fetch_assoc()): ?>
                    <option value="<?= $m['id'] ?>"><?= $m['username'] ?> (<?= $m['rank'] ?>)</option>
                <?php endwhile; ?>
            </select>
            <textarea name="content" class="form-control mb-3" placeholder="Warning content" required></textarea>
            <button class="btn btn-danger">Submit Warning</button>
            <a href="dashboard.php" class="btn btn-secondary">Back</a>
        </form>
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