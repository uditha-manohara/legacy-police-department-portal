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

$ranks = ['Chief', 'Deputy Chief', 'Commander', 'Lieutenant', 'Sergeant', 'Corporal', 'Senior Officer 1', 'Senior Officer 2', 'Senior Officer 3', 'Officer 1', 'Officer 2', 'Officer 3', 'Cadet', 'Legacy Staff'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);
    $ingame_name = $_POST['ingame_name'];
    $rank = $_POST['rank'];
    $callsign = $_POST['callsign'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    $stmt = $conn->prepare("INSERT INTO users (username, password, ingame_name, rank, callsign, is_admin) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $username, $password, $ingame_name, $rank, $callsign, $is_admin);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />

</head>

<body class="bg-light">
    <div class="container py-5">
        <h3>Add New Member</h3>
        <form method="POST" class="bg-white p-4 shadow rounded">
            <input name="username" class="form-control mb-2" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
            <input name="ingame_name" class="form-control mb-2" placeholder="In-Game Name" required>
            <input name="callsign" class="form-control mb-2" placeholder="Callsign" required>
            <select name="rank" class="form-control mb-2" required>
                <option value="">-- Select Rank --</option>
                <?php foreach ($ranks as $r): ?>
                    <option value="<?= $r ?>"><?= $r ?></option><?php endforeach; ?>
            </select>
            <label><input type="checkbox" name="is_admin"> Is Admin?</label><br>
            <button class="btn btn-success mt-3">Add Member</button>
            <a href="dashboard.php" class="btn btn-secondary mt-3">Cancel</a>
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