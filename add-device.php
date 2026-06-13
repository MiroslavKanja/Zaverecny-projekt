<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ochrana: Ak nie je prihlásený, nepustíme ho sem
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'app/Database.php';
require_once 'app/Device.php';

$message = "";
$messageClass = "";

// Spracovanie formulára po odoslaní
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Odstránime zbytočné medzery zo vstupu
    $deviceName = trim($_POST['device_name']);

    if (!empty($deviceName)) {
        $deviceModel = new Device();

        // Zavoláme našu OOP metódu
        if ($deviceModel->create($deviceName)) {
            // Po úspešnom pridaní presmerujeme späť na admin panel
            header("Location: admin.php");
            exit();
        } else {
            $message = "Chyba: Zariadenie sa nepodarilo uložiť do databázy.";
            $messageClass = "alert danger";
        }
    } else {
        $message = "Upozornenie: Názov zariadenia nesmie byť prázdny!";
        $messageClass = "alert danger";
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pridať zariadenie | Inventory Manager</title>
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

<main class="container" style="margin-top: 40px; max-width: 500px;">
    <div class="login-card" style="box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); background: white; padding: 30px; border-radius: 8px;">
        <h2 style="text-align: left; margin-bottom: 20px;">Pridať novú techniku</h2>

        <?php if ($message != ""): ?>
            <div class="<?php echo $messageClass; ?>" style="padding: 10px; margin-bottom: 20px; border-radius: 8px; text-align: center; font-weight: 600;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="input-group">
                <label for="device_name">Názov alebo model zariadenia</label>
                <input type="text" id="device_name" name="device_name" placeholder="napr. Monitor Dell 24\" required>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 25px;">
                <button type="submit" class="btn" style="border: none; padding: 12px 20px; cursor: pointer; width: 100%;">Uložiť zariadenie</button>
                <a href="admin.php" class="btn-action edit" style="text-align: center; padding: 12px 20px; width: 100%; text-decoration: none; border-radius: 6px;">Zrušiť</a>
            </div>
        </form>
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; 2026 Inventory Management System | UKF Projekt</p>
    </div>
</footer>

</body>
</html>