<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LCPD Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }
        body {
            background: url('background.gif') no-repeat center center fixed;
            background-size: cover;
        }
        .overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.6);
            z-index: 0;
        }
        .center-content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
        }
        .btn-lg-custom {
            padding: 0.75rem 2rem;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="center-content">
        <h1 class="mb-4">Welcome to LCPD Department Portal</h1>
        <div class="d-flex gap-3">
            <a href="login.php" class="btn btn-primary btn-lg-custom">Login</a>
            <a href="apply.php" class="btn btn-success btn-lg-custom">Apply for Department</a>
        </div>
    </div>
</body>
</html>
