<?php
require_once '../init.php';

$auth = new Auth();
$auth->redirectIfNotManager();

$db = (new Database())->getConnection();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $user->setFullName($_POST['fullname']);
    $user->setUsername($_POST['username']);
    $user->setPassword($_POST['password']);
    $user->setEmail($_POST['email']);
    $user->setRole($_POST['role']);
    $user->setFullName($_POST['full_name']);
    
    $catalog = new UserCatalog();
    if ($catalog->saveUser($user)) {
        header("Location: users_list.php?success=1");
        exit();
    }
}

include '../includes/header.php';
?>

<div class="container mt-4">
    <h2>Create New User</h2>
    
    <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="employee">Employee</option>
                <option value="manager">Manager</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>