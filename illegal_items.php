<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];

// Define illegal items list
$illegal_items = [
    ['name' => 'Marijuana Seed', 'icon' => 'items/weedseed.png'],
    ['name' => 'Cocain Seed', 'icon' => 'items/cocaineseed.png'],
    ['name' => 'Taser', 'icon' => 'items/taser.png'],
    ['name' => 'Tec 9', 'icon' => 'items/tec-9.png'],
    ['name' => 'Shotgun', 'icon' => 'items/shotgun.png'],
    ['name' => 'MP5', 'icon' => 'items/mp5.png'],
    ['name' => 'M4', 'icon' => 'items/m4.png'],
    ['name' => 'Glock', 'icon' => 'items/glock.png'],
    ['name' => 'AK 47', 'icon' => 'items/ak-47.png'],

    ['name' => '45 Ammo', 'icon' => 'items/hutteammo.png'],
    ['name' => '9mm', 'icon' => 'items/9mm.png'],
    ['name' => '556 Ammo', 'icon' => 'items/556.png'],
    ['name' => 'Shotgun Ammo', 'icon' => 'items/calibre.12.png'],
    ['name' => 'Armour', 'icon' => 'items/armor.png'],
    ['name' => 'Axe', 'icon' => 'items/axe.png'],
    ['name' => 'Battery', 'icon' => 'items/batteries.png'],
    ['name' => 'Alluminium', 'icon' => 'items/aluminium.png'],
    ['name' => 'Black Money', 'icon' => 'items/blackmoney.png'],

    ['name' => 'Bronze Plates', 'icon' => 'items/bronzeplates.png'],
    ['name' => 'Bracelet', 'icon' => 'items/bracelete.png'],
    ['name' => 'Cannabis', 'icon' => 'items/Cannabis.png'],
    ['name' => 'Cannabis Powder', 'icon' => 'items/cannabispowder.png'],
    ['name' => 'Cocain', 'icon' => 'items/cocaine.png'],
    ['name' => 'Cuff', 'icon' => 'items/cuff.png'],
    ['name' => 'Corpo fuzil', 'icon' => 'items/corpo-fuzil.png'],
    ['name' => 'Pistol Part', 'icon' => 'items/corpo-pistola.png'],

    ['name' => 'Diamond', 'icon' => 'items/diamante.png'],
    ['name' => 'Electronics', 'icon' => 'items/electronickit.png'],
    ['name' => 'Empty 9mm', 'icon' => 'items/empty_9mm.png'],
    ['name' => 'Empty SMG AMMO', 'icon' => 'items/empty_ammo_smg.png'],
    ['name' => 'Erythroxylon', 'icon' => 'items/Erythroxylon.png'],
    ['name' => 'Erythroxylon Powder', 'icon' => 'items/erythroxylonpoweder.png'],
    ['name' => 'Emerald', 'icon' => 'items/esmeralda.png'],
    ['name' => 'Knife', 'icon' => 'items/faca.png'],

    ['name' => 'Fix Kit', 'icon' => 'items/fixkit.png'],
    ['name' => 'Gatilho', 'icon' => 'items/gatilho.png'],
    ['name' => 'Glass', 'icon' => 'items/glass.png'],
    ['name' => 'Gold Bar', 'icon' => 'items/goldbar.png'],
    ['name' => 'Gold Chain', 'icon' => 'items/goldchain.png'],
    ['name' => 'Lockpick', 'icon' => 'items/lockpick.png'],
    ['name' => 'Lockpick Handle', 'icon' => 'items/lockpickhandle.png'],
    ['name' => 'Glock Parts', 'icon' => 'items/parts_glock.png'],

    ['name' => 'SMG Parts', 'icon' => 'items/parts_smg.png'],
    ['name' => 'Plastic Bag', 'icon' => 'items/plasticbag.png'],
    ['name' => 'Plastic', 'icon' => 'items/plastico.png'],
    ['name' => 'Plastic ', 'icon' => 'items/plastic.png'],
    ['name' => 'Metal', 'icon' => 'items/metal.png'],
    ['name' => 'Gun Powder', 'icon' => 'items/gunpowder.png'],
    ['name' => 'Ring', 'icon' => 'items/ring.png'],
    ['name' => 'Rolex Watch', 'icon' => 'items/rolex.png'],
    ['name' => 'Rubber', 'icon' => 'items/rubber.png'],
    ['name' => 'Spring', 'icon' => 'items/sprin.png'],

    ['name' => 'Metal Spring', 'icon' => 'items/springmetal.png'],
    ['name' => 'Synthetic Fabric', 'icon' => 'items/syntheticfabric.png'],
    ['name' => 'Tape', 'icon' => 'items/tape.png'],
    ['name' => 'Zip Lock', 'icon' => 'items/ziplock.png'],

];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Illegal Items - LCPD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand">LCPD - Illegal Items</span>
    <div>
        <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
        <a href="uniform.php" class="btn btn-outline-light btn-sm me-2">Uniform</a>
        <a href="logout.php" class="btn btn-dark btn-sm">Logout</a>
    </div>
</nav>

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Illegal Items</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered align-middle text-center bg-white">
                <thead class="table-light">
                    <tr>
                        <th>Item Name</th>
                        <th>Icon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($illegal_items as $item): ?>
                        <tr>
                            <td class="fw-semibold"><?= htmlspecialchars($item['name']) ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($item['icon']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="height: 50px;">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
