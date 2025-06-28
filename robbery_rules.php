<?php
// No session or login checks here, page is publicly accessible
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Robbery Rules & Situations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <style>
    body {
      background-color: #f0f2f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 40px 15px;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: #fff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    h1 {
      text-align: center;
      color: #007bff;
      font-weight: 700;
      margin-bottom: 30px;
      letter-spacing: 0.05em;
    }
    .rule-item {
      margin-bottom: 25px;
      border-left: 6px solid #007bff;
      padding-left: 18px;
    }
    .rule-title {
      font-size: 1.4rem;
      font-weight: 700;
      color: #007bff;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .verify-icon {
      color: #28a745;
      font-weight: 900;
      font-size: 1.25rem;
    }
    .rule-details {
      font-size: 1.05rem;
      color: #444;
      line-height: 1.5;
    }
    .note {
      font-style: italic;
      color: #666;
      margin-top: 6px;
    }
    .btn-back {
      display: block;
      margin: 30px auto 0;
      width: max-content;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Robbery Situations Overview</h1>

    <div class="rule-item">
      <div class="rule-title"><span class="verify-icon">✔️</span> Shop Robbery</div>
      <div class="rule-details">
        PD Count: 4<br>
        Suspect Count: 2<br>
        <span class="note">The police can be looted</span>
      </div>
    </div>

    <div class="rule-item">
      <div class="rule-title"><span class="verify-icon">✔️</span> Bank Robbery</div>
      <div class="rule-details">
        PD Count: 10<br>
        Suspect Count: 6<br>
        Air Unit: 1
      </div>
    </div>

    <div class="rule-item">
      <div class="rule-title">Jewelry Store Robbery</div>
      <div class="rule-details">
        PD Count: 10<br>
        Suspect Count: 6<br>
        Air Unit: 1
      </div>
    </div>

    <div class="rule-item">
      <div class="rule-title"><span class="verify-icon">✔️</span> PullOver</div>
      <div class="rule-details">
        PD Count: 4<br>
        Suspect Count: 2<br>
        Air Unit: 1 (Only for ambushes)<br>
        <span class="note">The police can't be looted</span>
      </div>
    </div>

    <div class="rule-item">
      <div class="rule-title">Drug Sale Sit</div>
      <div class="rule-details">
        PD Count: 5<br>
        Suspect Count: 2<br>
        Suspect Backup: 1<br>
        Air Unit: 1 (Only for ambushes)<br>
        <span class="note">The police can be looted</span>
      </div>
    </div>

    <div class="rule-item">
      <div class="rule-title">Code-Red Sit</div>
      <div class="rule-details">
        PD Count: All Count<br>
        Suspect Count: 8<br>
        Suspect Backup: No<br>
        Can Start Sit Onduty PD 6 Officers<br>
        <span class="note">The police can be looted</span>
      </div>
    </div>

    <a href="index.php" class="btn btn-primary btn-back">Back to Main Page</a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
