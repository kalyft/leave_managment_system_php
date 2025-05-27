<?php
require_once 'Database.php';
require_once 'User.php';

class UserCatalog {
    private $db;
    
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Get all users
     * @return User[]
     */
    public function getAllUsers(): array {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        $users = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $this->createUserFromRow($row);
        }
        
        return $users;
    }

    /**
     * Find user by ID
     */
    public function findById(int $id): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createUserFromRow($row) : null;
    }

    /**
     * Create or update user
     */
    public function saveUser(User $user): bool {
        if ($user->getId()) {
            return $this->updateUser($user);
        }
        return $this->createUser($user);
    }

    /**
     * Delete user
     */
    public function deleteUser(int $userId): bool {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$userId]);
    }

    private function createUser(User $user): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO 
                users 
            (username, password, email, role, full_name) 
            VALUES 
            (?, ?, ?, ?, ?)"
        );
        
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        return $stmt->execute([
            $user->getUsername(),
            $hashedPassword,
            $user->getEmail(),
            $user->getRole(),
            $user->getFullName()
        ]);
    }

    private function updateUser(User $user): bool {
        // Update without password
        if (empty($user->getPassword())) {
            $stmt = $this->db->prepare(
                "UPDATE users SET 
                 username = ?, email = ?, role = ?, full_name = ?
                 WHERE id = ?"
            );
            return $stmt->execute([
                $user->getUsername(),
                $user->getEmail(),
                $user->getRole(),
                $user->getFullName(),
                $user->getId()
            ]);
        }
        
        // Update with password
        $stmt = $this->db->prepare(
            "UPDATE users SET 
             username = ?, password = ?, email = ?, role = ?, full_name = ?
             WHERE id = ?"
        );
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        return $stmt->execute([
            $user->getUsername(),
            $hashedPassword,
            $user->getEmail(),
            $user->getRole(),
            $user->getFullName(),
            $user->getId()
        ]);
    }

    private function createUserFromRow(array $row): User {
        $user = new User();
        $user->setId($row['id']);
        $user->setUsername($row['username']);
        $user->setEmail($row['email']);
        $user->setRole($row['role']);
        $user->setFullName($row['full_name']);
        // Note: Password is not set from database
        
        return $user;
    }
}