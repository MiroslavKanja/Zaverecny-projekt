<?php
// Spustíme session, aby sme vedeli skontrolovať, či je používateľ prihlásený
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ochrana stránky: Ak používateľ NIE JE prihlásený, nepustíme ho sem a presmerujeme na login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'app/Database.php';
require_once 'app/Device.php';

// Načítame všetku techniku z databázy cez náš existujúci model
$deviceModel = new Device();
$devices = $deviceModel->getAllDevices();
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrácia | Inventory Manager</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="container">
        <div class="logo">InvManager <span style="font-size: 0.9rem; color: #64748b;">(Admin Zóna)</span></div>
        <nav>
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="admin.php">Správa techniky</a></li>
                <li style="font-weight: 600; color: #2563eb;">Prihlásený: <?php echo htmlspecialchars($_SESSION['username']); ?></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container" style="margin-top: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Prehľad a správa zariadení</h2>
        <a href="add-device.php" class="btn" style="text-decoration: none; padding: 10px 20px;">+ Pridať zariadenie</a>
    </div>

    <table class="admin-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Názov zariadenia</th>
            <th>Stav</th>
            <th>Akcie</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($devices)): ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px;">V systéme nie sú žiadne zariadenia.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($devices as $device): ?>
                <tr>
                    <td><?php echo $device['id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($device['name'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                    <td>
                        <?php if ($device['status'] === 'available'): ?>
                            <span class="status available">Dostupné</span>
                        <?php else: ?>
                            <span class="status busy">Vypožičané</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit-device.php?id=<?php echo $device['id']; ?>" class="btn-action edit">Upraviť</a>
                        <a href="delete-device.php?id=<?php echo $device['id']; ?>" class="btn-action delete" onclick="return confirm('Naozaj chcete vymazať toto zariadenie?')">Zmazať</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</main>

<footer>
    <div class="container">
        <p>&copy; 2026 Inventory Management System | UKF Projekt</p>
    </div>
</footer>

</body>
</html>