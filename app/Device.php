<?php

class Device {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Funkcia vytiahne všetky riadky z tabuľky devices
    public function getAllDevices() {
        $stmt = $this->db->query("SELECT * FROM devices ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    // Funkcia na pridanie nového zariadenia do databázy
    public function create($name) {
        // Použijeme Prepared Statement na 100% ochranu pred SQL Injection (kritérium bezpečnosti)
        $stmt = $this->db->prepare("INSERT INTO devices (name, status) VALUES (:name, 'available')");

        // Spustíme dopyt s ošetreným parametrom
        return $stmt->execute(['name' => $name]);
    }

    // Funkcia na vymazanie zariadenia podľa ID
    public function delete($id) {
        // Prepared statement zabezpečí, že nám nikto nevstrekne SQL Injection cez ID v URL adrese
        $stmt = $this->db->prepare("DELETE FROM devices WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}