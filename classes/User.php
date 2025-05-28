<?php

class User {
    private $db;
    private $id;
    private $username;
    private $password;
    private $role;
    private $fullName;
    private $createdAt;
    private $email;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Getters
    public function getId() { 
        return $this->id;
    }
    public function getUsername() { 
        return $this->username; 
    }
    public function getPassword() { 
        return $this->password; 
    }
    public function getRole() {
        return $this->role;
    }
    public function getFullName() {
        return $this->fullName;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function getCreatedAt() {
        return $this->createdAt;
    }

    //and Setters
    public function setId(int $id): void {
        $this->id = $id;
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

    public function setEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format");
        }
        $this->email = $email;
    }
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    // move to catalog
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyPassword($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
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
