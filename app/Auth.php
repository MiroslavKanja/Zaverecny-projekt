<?php
// Spustenie session, aby trieda vedela pracovať s pamäťou prihlásenia
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Auth {
    private $db;

    public function __construct() {
        // Použijeme naše existujúce pripojenie z Database Singletonu
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        // Overenie hesla
        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }

    public function logout() {
        session_destroy();
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
    }
}
?>