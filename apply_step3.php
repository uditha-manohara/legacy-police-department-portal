<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Step 3 - Login Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="card-title mb-4">Section 3.0 - Dashboard Login Details</h2>
            <form method="POST" action="submit_application.php">
                <input type="hidden" name="data" value="<?= base64_encode(serialize($_SESSION['application'] ?? [])) ?>">
                <div class="mb-3"><input name="username" class="form-control" placeholder="Username" required></div>
                <div class="mb-3"><input name="password" type="password" class="form-control" placeholder="Password" required></div>
                <button type="submit" class="btn btn-success">Submit Application</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
