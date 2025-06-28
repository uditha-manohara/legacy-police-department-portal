<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];
$rank = $user['rank'];

// Define rank groups
$uniforms = [
    'Cadet' => [
        'parts' => [
            'Gloves' => 'Black Glove (if you need)',
            'T-Shirts and Jackets' => 'Black T-shirt [Police]',
            'Hats' => 'No Hat',
            'Pants' => 'Black Pants',
            'Ballastic Vests' => 'Cinta Policial 1',
            'Masks' => 'No Masks',
            'Boots' => 'Black Boots',
        ],
        'special' => [
            'No Hairstyle (must be no hair)',
            'No Beard',
            'No Tattoos',
        ],
        'image' => 'uniforms/cadet.png'
    ],
    'Senior Officer' => [
        'parts' => [
            'Gloves' => 'Black Glove (if you need)',
            'T-Shirts and Jackets' => 'Blue T-Shirt [Police]',
            'Hats' => 'No Cap',
            'Pants' => 'Black Pants',
            'Ballastic Vests' => 'Black Vest [Police] 3 & Cinta Policial 1',
            'Masks' => 'No Mask',
            'Boots' => 'Black Boots',
        ],
        'special' => [
            'Hairstyle and Beard Only',
            'No Tattoos',
        ],
        'image' => 'uniforms/senior_officer.png'
    ],
    'Officer' => [
        'parts' => [
            'Gloves' => 'Black Glove (if you need)',
            'T-Shirts and Jackets' => 'Blue T-Shirt [Police]',
            'Hats' => 'No Hat',
            'Pants' => 'Black Pants',
            'Ballastic Vests' => 'Black Vest [Police] 2 & Cinta Policial 1',
            'Masks' => 'No Masks',
            'Boots' => 'Black Boots',
        ],
        'special' => [
            'Hairstyle Only',
            'No Beard',
            'No Tattoos',
        ],
        'image' => 'uniforms/officer.png'
    ],
    'Corporal' => [
        'parts' => [
            'Gloves' => 'Black Glove (If You Need)',
            'T-Shirts and Jackets' => 'Grey Coat [Police]',
            'Hats' => 'No Hat',
            'Pants' => 'Black Pants',
            'Ballastic Vests' => 'Black Military Vest & Cinta Policial 1',
            'Masks' => 'No Masks',
            'Boots' => 'Black Boots',
        ],
        'special' => [
            'Hairstyle & Beard Only',
            'No Tattoos',
        ],
        'image' => 'uniforms/corporal.png'
    ],
    'Sergeant' => [
        'parts' => [
            'Gloves' => 'Black Glove (If You Need)',
            'T-Shirts and Jackets' => 'Brown Coat [Sheriff]',
            'Hats' => 'No Hat',
            'Pants' => 'Black Pants',
            'Ballastic Vests' => 'Black Military Vest & Cinta Policial 1',
            'Masks' => 'Mask (If You Need)',
            'Boots' => 'Black Boots',
        ],
        'special' => [
            'Hairstyle & Beard Only',
            'No Tattoos',
        ],
        'image' => 'uniforms/sergeant.png'
    ],
    'Lieutenant' => [
        'parts' => [
            'Gloves' => 'Black Gloves (If You Need)',
            'T-Shirts and Jackets' => 'Blue Sweatshirt [Police]',
            'Hats' => 'No Hat',
            'Pants' => 'Black Pants',
            'Ballastic Vests' => 'Cinta Policial 1 or Cinta Policial 2 & (Black Military Vest if you need)',
            'Masks' => 'Mask (If You Need)',
            'Boots' => 'Black Boots',
        ],
        'special' => [
            'Hairstyle & Beard Only',
            'No Tattoos',
        ],
        'image' => 'uniforms/lieutenant.png'
    ],
    'Commander' => [
        'parts' => [
            'Gloves' => 'Black Glove (If You Need)',
            'T-Shirts and Jackets' => 'Olivia Sweatshirt [Police]',
            'Hats' => 'Touca Olivia (If You Need)',
            'Pants' => 'Black Pants',
            'Ballastic Vests' => 'Cinta Policial 1 or Cinta Policial 2 & (Black Military Vest if you need)',
            'Masks' => 'Mask (If You Need)',
            'Boots' => 'Black Boots',
        ],
        'special' => [
            'Hairstyle & Beard Only',
            'No Tattoos',
        ],
        'image' => 'uniforms/commander.png'
    ],
    'Deputy Chief' => [
        'parts' => [
            'Gloves' => 'Black Glove',
            'T-Shirts and Jackets' => 'Olivia Sweatshirt [Sherrif2]',
            'Hats' => 'Touca Olivia (If You Need)',
            'Pants' => 'Black Pants',
            'Ballastic Vests' => 'Cinta Policial 1 or Cinta Policial 2 & (Black Military Vest if you need)',
            'Masks' => 'Mask (If You Need)',
            'Boots' => 'Black Boots',
        ],
        'special' => [
            'Hairstyle & Beard Only',
            'No Tattoos',
        ],
        'image' => 'uniforms/deputy_chief.png'
    ],
    'Chief' => [
        'parts' => [
            'Gloves' => 'Black Tactical Gloves',
            'T-Shirts and Jackets' => 'Olivia Sweatshirt [Sherrif]',
            'Hats' => 'Touca Olivia (If You Need)',
            'Pants' => 'Black Pants',
            'Ballastic Vests' => 'Cinta Policial 1 or Cinta Policial 2 & (Black Military Vest if you need)',
            'Masks' => 'Mask (If You Need)',
            'Boots' => 'Black Boots',
        ],
        'special' => [
            'Hairstyle & Beard Only',
            'No Tattoos',
        ],
        'image' => 'uniforms/chief.png'
    ],
    'Default' => null
];

// Map rank to group
$group = match (true) {
    $rank === 'Cadet' => 'Cadet',
    $rank === 'Corporal' => 'Corporal',
    $rank === 'Sergeant' => 'Sergeant',
    $rank === 'Commander' => 'Commander',
    $rank === 'Deputy Chief' => 'Deputy Chief',
    $rank === 'Chief' => 'Chief',
    in_array($rank, ['Senior Officer 1', 'Senior Officer 2', 'Senior Officer 3']) => 'Senior Officer',
    in_array($rank, ['Officer 1', 'Officer 2', 'Officer 3']) => 'Officer',
    $rank === 'Legacy Staff' => 'Default',
    default => 'Officer'
};

$uniform = $uniforms[$group] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Uniform - LCPD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand">LCPD Uniform</span>
    <div>
        <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
        <a href="logout.php" class="btn btn-dark btn-sm">Logout</a>
    </div>
</nav>

<div class="container py-4">
    <?php if ($uniform): ?>
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><?= htmlspecialchars($rank) ?> Uniform</h4>
            </div>
            <div class="card-body">
                <h5 class="mb-3">Uniform Parts</h5>
                <ul class="list-group mb-3">
                    <?php foreach ($uniform['parts'] as $part => $desc): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong><?= htmlspecialchars($part) ?>:</strong>
                            <span><?= htmlspecialchars($desc) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <?php if (!empty($uniform['special'])): ?>
                    <h5>Special Instructions</h5>
                    <ul>
                        <?php foreach ($uniform['special'] as $note): ?>
                            <li><?= htmlspecialchars($note) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if (!empty($uniform['image'])): ?>
                    <div class="text-center mt-4">
                        <img src="<?= htmlspecialchars($uniform['image']) ?>" class="img-fluid rounded shadow" alt="Uniform Image" style="max-height: 500px;">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            No uniform assigned to your rank.
        </div>
    <?php endif; ?>
</div>
</body>
</html>
