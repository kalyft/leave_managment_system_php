<?php
class Auth {
    private $user;

    public function __construct() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->user = new User();
    }

    public function login($username, $password) {
        $user = $this->user->findByUsername($username);
        
        if ($user && $this->user->verifyPassword($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            return true;
        }
        return false;
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function isManager() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'manager';
    }

    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'role' => $_SESSION['role'],
                'full_name' => $_SESSION['full_name']
            ];
        }
        return null;
    }

    public function redirectIfNotLoggedIn($redirectTo = 'login.php') {
        if (!$this->isLoggedIn()) {
            header("Location: $redirectTo");
            exit();
        }
    }

    public function redirectIfNotManager($redirectTo = 'employee/dashboard.php') {
        if (!$this->isManager()) {
            header("Location: $redirectTo");
            exit();
        }
    }
}
?>