<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ochrana: Ak používateľ nie je prihlásený, vyhodíme okno a UŽ NEPOKRAČUJEME v skripte
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Pre zapožičanie techniky sa musíte najskôr prihlásiť!');
        window.location.href = 'login.php';
    </script>";
    exit(); // Týmto stopneme celý skript a PHP už nespustí presmerovanie na index.php nižšie!
}

require_once 'app/Database.php';
require_once 'app/Device.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $deviceId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    $deviceModel = new Device();
    $deviceModel->rent($deviceId, $userId);
}

// Presmerujeme späť na domovskú stránku (vykoná sa LEN pre prihláseného Jožka)
header("Location: index.php");
exit();