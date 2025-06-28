<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['application'] = $_POST; // ✅ this is okay for step 1 since it's the beginning
    header('Location: apply_step2.php');
    exit();
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Step 1 - OOC Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="card-title mb-4">Section 1.0 - OOC Information</h2>
            <form method="POST">
                <div class="mb-3"><input name="full_name_ooc" class="form-control" placeholder="Full Name" required></div>
                <div class="mb-3">
                    <select name="gender" class="form-select" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="mb-3"><input name="birthday" type="date" class="form-control" required></div>
                <div class="mb-3"><input name="whatsapp" class="form-control" placeholder="Whatsapp Number" required></div>
                <div class="mb-3"><input name="email" type="email" class="form-control" placeholder="Email" required></div>
                <div class="mb-3"><input name="discord" class="form-control" placeholder="Discord Username" required></div>
                <div class="mb-3"><input name="mta_serial" class="form-control" placeholder="MTA Serial" required></div>
                <div class="mb-3">
                    <select name="character_slot" class="form-select" required>
                        <option value="">Select Character Slot</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select name="gang_member" class="form-select" required>
                        <option value="">Gang affiliation (if any)</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select name="mic" class="form-select" required>
                        <option value="">Do you have a working microphone?</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Next</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>