<?php
// File: apply_step2.php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['application'] = array_merge($_SESSION['application'] ?? [], $_POST);
    header("Location: apply_step3.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Step 2 - IC Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="card-title mb-4">Section 2.0 - In Character Information</h2>
            <form method="POST">
                <div class="mb-3"><input name="full_name_ic" class="form-control" placeholder="Full Name (IC)" required></div>
                <div class="mb-3"><input name="age" type="number" class="form-control" placeholder="Age" required></div>
                <div class="mb-3"><textarea name="backstory" class="form-control" rows="4" placeholder="Character Backstory (Don't use AI)" required></textarea></div>
                <div class="mb-3"><textarea name="reason" class="form-control" rows="3" placeholder="Why does your character want to join the LCPD?" required></textarea></div>
                <div class="mb-3"><input name="duty_hours" class="form-control" placeholder="How many hours will you be on duty daily?" required></div>
                <div class="mb-3">
                    <label>Preferred Work Shifts (select multiple):</label><br>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="workshift[]" value="Morning" class="form-check-input"><label class="form-check-label">Morning</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="workshift[]" value="Afternoon" class="form-check-input"><label class="form-check-label">Afternoon</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="workshift[]" value="Evening" class="form-check-input"><label class="form-check-label">Evening</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="workshift[]" value="Night" class="form-check-input"><label class="form-check-label">Night</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Next</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
