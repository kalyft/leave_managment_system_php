<?php

class User {
    private $db;
    private $id;
    private $username;
    private $password;
    private $role;
    private $fullName;
    private $createdAt;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Getters and Setters
    public function getId() { 
        return $this->id;
    }
    public function getUsername() { 
        return $this->username; 
    }
    public function getRole() {
        return $this->role;
    }
    public function getFullName() {
        return $this->fullName;
    }

    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function setPassword($password) { 
        $this->password = $password;
    }
    
    public function setRole($role) {
        $this->role = $role;
    }
    
    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    // User methods
    public function create() {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role, full_name) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->username, $hashedPassword, $this->role, $this->fullName]);
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyPassword($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
    }

    public function getAllEmployees() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 'employee'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

/*
class Employee extends User {
    public function newVacationRequest () {

    }
}

class Manager extends User {
  

    public function createEmployee() {

    }
}*/
?>