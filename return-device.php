<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ochrana: Iba prihlásený admin sem môže
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'app/Database.php';
require_once 'app/Device.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $deviceModel = new Device();
    $deviceModel->returnDevice($id);
}

header("Location: admin.php");
exit();
