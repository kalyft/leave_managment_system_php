<?php
require_once '../init.php';

$auth = new Auth();
$auth->redirectIfNotManager();

$catalog = new UserCatalog();
$users = $catalog->getAllUsers();

if (isset($_GET['action']) && $_GET['action'] == 'deleteUser') {
    try {
    	$userId = (int)$_GET['id'];
		$catalog = new UserCatalog();

        if ($catalog->deleteUser($userId)) {
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
    <a href="create_user.php" class="btn btn-primary mb-3">Create New User</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user->getId()) ?></td>
                <td><?= htmlspecialchars($user->getUsername()) ?></td>
                <td><?= htmlspecialchars($user->getEmail()) ?></td>
                <td><?= ucfirst($user->getRole()) ?></td>

                <td><?= htmlspecialchars($user->getCreatedAt()) ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $user->getId() ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?action=deleteUser&id=<?= $user->getId() ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>