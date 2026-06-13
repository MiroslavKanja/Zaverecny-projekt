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
}