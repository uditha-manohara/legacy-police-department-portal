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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = hash('sha256', $_POST['password']);
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows) {
        $_SESSION['user'] = $result->fetch_assoc();
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>LCPD Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>

<body class="bg-dark text-light d-flex align-items-center justify-content-center vh-100">
    <form method="POST" class="p-4 bg-secondary rounded shadow" style="min-width:300px;">
        <h3 class="text-center mb-3">LCPD Login</h3>
        <?php if (isset($error))
            echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if (isset($_GET['timeout'])): ?>
            <div class="alert alert-warning">You were logged out due to inactivity.</div>
        <?php endif; ?>

        <input name="username" class="form-control mb-2" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <button class="btn btn-primary w-100">Login</button>
    </form>
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