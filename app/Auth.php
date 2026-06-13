<?php

class Auth {
    private $db;

    public function __construct() {
        // Použijeme existujúce pripojenie z Database Singletonu
        $this->db = Database::getInstance()->getConnection();
    }

    // OPRAVENÉ: Názov funkcie je teraz presne 'login' (s jedným n)
    public function login($username, $password) {
        // Ochrana pred SQL Injection pomocou prepare a execute
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        // Overenie hesla pomocou bezpečnej funkcie password_verify
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
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