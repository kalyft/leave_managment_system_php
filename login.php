<?php
require  $_SERVER['DOCUMENT_ROOT'] . '/init.php';

$auth = new Auth();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($auth->login($username, $password)) {
        $user = $auth->getCurrentUser();
        header("Location: " . ($user['role'] === 'manager' ? 'manager/dashboard.php' : 'employee/dashboard.php'));
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<?php include 'includes/header.php'; ?>
    <div class="container mt-5">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>