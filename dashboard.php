<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']))
    header("Location: index.php");
$user = $_SESSION['user'];

$rank_order = [
    'Chief' => 1,
    'Deputy Chief' => 2,
    'Commander' => 3,
    'Lieutenant' => 4,
    'Sergeant' => 5,
    'Corporal' => 6,
    'Senior Officer 1' => 7,
    'Senior Officer 2' => 8,
    'Senior Officer 3' => 9,
    'Officer 1' => 10,
    'Officer 2' => 11,
    'Officer 3' => 12,
    'Cadet' => 13,
    'Legacy Staff' => 14
];

// Fetch members
$members = $conn->query("SELECT * FROM users");
$sorted_members = [];

while ($m = $members->fetch_assoc()) {
    $rank_index = $rank_order[$m['rank']] ?? 999;
    $sorted_members[] = ['rank_index' => $rank_index, 'member' => $m];
}
usort($sorted_members, fn($a, $b) => $a['rank_index'] - $b['rank_index']);

// Fetch pending application count
$pending_app_count_result = $conn->query("SELECT COUNT(*) AS count FROM applications WHERE status = 'Pending'");
$pending_app_count_row = $pending_app_count_result->fetch_assoc();
$pending_app_count = $pending_app_count_row['count'] ?? 0;

// Fetch rule_breaks count per user
$rule_breaks_result = $conn->query("SELECT user_id, COUNT(*) AS count FROM rule_breaks GROUP BY user_id");
$rule_breaks_count_map = [];
while ($row = $rule_breaks_result->fetch_assoc()) {
    $rule_breaks_count_map[$row['user_id']] = $row['count'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>LSPD Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand">LSPD Dashboard</span>
    <div>
        <?php if ($user['is_admin']): ?>
            <a href="add_member.php" class="btn btn-success btn-sm">+ Add Member</a>
        <?php endif; ?>

        <?php if (in_array($user['rank'], ['Chief', 'Deputy Chief', 'Commander', 'Lieutenant', 'Sergeant', 'Corporal', 'Legacy Staff'])): ?>
            <a href="review_applications.php"
               class="btn btn-sm <?= $pending_app_count > 0 ? 'btn-warning' : 'btn-info' ?>">
                Review Applications<?= $pending_app_count > 0 ? " ($pending_app_count)" : "" ?>
            </a>
            
        <?php endif; ?>

        <a href="uniform.php" class="btn btn-outline-light btn-sm me-2">Uniform</a>
        <a href="illegal_items.php" class="btn btn-outline-light btn-sm me-2">Illegal Items</a>
        <a href="logout.php" class="btn btn-dark btn-sm">Logout</a>
    </div>
</nav>

    <div class="container py-4">
        <table class="table table-bordered bg-white shadow">
            <thead>
                <tr>
                    <th>In-Game Name</th>
                    <th>Rank</th>
                    <th>Callsign</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sorted_members as $item):
                    $row = $item['member'];
                    $rule_breaks_count = $rule_breaks_count_map[$row['id']] ?? 0;

                    if ($rule_breaks_count >= 3) {
                        $rule_breaks_btn_class = 'btn-danger';
                    } elseif ($rule_breaks_count >= 1) {
                        $rule_breaks_btn_class = 'btn-warning';
                    } else {
                        $rule_breaks_btn_class = 'btn-secondary';
                    }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ingame_name']) ?></td>
                        <td><?= htmlspecialchars($row['rank']) ?></td>
                        <td><?= htmlspecialchars($row['callsign']) ?></td>
                        <td>
                            <?php if ($user['is_admin']): ?>
                                <a href="edit_member.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="delete_member.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Kick</a>
                            <?php endif; ?>
                            <a href="rule_breaks.php?id=<?= $row['id'] ?>" class="btn btn-sm <?= $rule_breaks_btn_class ?>">
                                Warnings<?= $rule_breaks_count > 0 ? " ($rule_breaks_count)" : "" ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        let idleTime = 0;
        setInterval(() => {
            idleTime++;
            if (idleTime > 30) location.href = 'logout.php';
        }, 60000);

        document.onmousemove = document.onkeypress = () => {
            idleTime = 0;
        };
    </script>
</body>
</html>
