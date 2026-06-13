<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vymažeme všetky dáta zo session
$_SESSION = array();

// Ak sa používajú cookies pre session, zmažeme aj tie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Zničíme reláciu
session_destroy();

// Presmerujeme na hlavnú stránku ako úplne čistého, odhláseného používateľa
header("Location: index.php");
exit();
