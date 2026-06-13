<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ochrana: Ak nie je admin prihlásený, okamžite stop
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'app/Database.php';
require_once 'app/Device.php';

// Skontrolujeme, či nám v URL adrese prišlo ID na mazanie (napr. delete-device.php?id=5)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $deviceModel = new Device();
    $deviceModel->delete($id);
}

// Po vymazaní hneď skočíme späť na zoznam
header("Location: admin.php");
exit();