<?php
require_once '../init.php';

$auth = new Auth();
$auth->redirectIfNotManager();

$db = (new Database())->getConnection();
$userId = (int)$_GET['id'];
$catalog = new UserCatalog();
$user = $catalog->findById($userId);

if (!$user) {
    header("Location: users_list.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user->setUsername($_POST['username']);
        $user->setEmail($_POST['email']);
        $user->setRole($_POST['role']);
        
        if (!empty($_POST['password'])) {
            $user->setPassword($_POST['password']);
        }
        
        // Move this to catalog
        if ($catalog->saveUser($user)) {
            header("Location: users_list.php?success=1");
            exit();
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

include '../includes/header.php';
?>

<div class="container mt-4">
    <h2>Edit User</h2>
    
    <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" 
                   value="<?= htmlspecialchars($user->getUsername()) ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" 
                   value="<?= htmlspecialchars($user->getEmail()) ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="employee" <?= $user->getRole() === 'employee' ? 'selected' : '' ?>>Employee</option>
                <option value="manager" <?= $user->getRole() === 'manager' ? 'selected' : '' ?>>Manager</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
