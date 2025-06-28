<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LCPD Department Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background: url('background.gif') no-repeat center center fixed;
            background-size: cover;
            /* Allow vertical scroll on small devices */
            overflow-y: auto;
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            padding: 1rem;
        }
        .btn-lg-custom {
            padding: 0.75rem 2rem;
            font-size: 1.25rem;
            white-space: nowrap;
        }

        /* Responsive tweaks */
        @media (max-width: 576px) {
            .d-flex.gap-3.mb-3 {
                flex-direction: column !important;
                gap: 0.75rem !important;
                width: 100%;
                max-width: 300px;
            }
            .btn-lg-custom {
                font-size: 1rem;
                padding: 0.6rem 1.5rem;
                width: 100%;
                box-sizing: border-box;
            }
            .center-content h1 {
                font-size: 1.75rem;
                margin-bottom: 1.5rem;
                padding: 0 1rem;
            }
            /* Center the Apply button */
            .center-content > div:last-child {
                margin-top: 1rem;
                width: 100%;
                max-width: 300px;
                display: flex;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="center-content">
        <h1 class="mb-4">Welcome to LCPD Department Portal</h1>
        <div class="d-flex gap-3 mb-3">
	    <a href="login.php" class="btn btn-success btn-lg-custom">Login</a>
            <a href="roleplay_rules.php" class="btn btn-primary btn-lg-custom">Roleplay Rules</a>
            <a href="robbery_rules.php" class="btn btn-primary btn-lg-custom">Robbery Rules</a>
            <a href="ten_codes.php" class="btn btn-warning btn-lg-custom">10-Codes Reference</a>
        </div>

        <div>
            <a href="apply.php" class="btn btn-outline-primary btn-lg-custom">Apply for Department</a>
        </div>
    </div>
</body>
</html>
