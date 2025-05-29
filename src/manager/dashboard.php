<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php';

$auth = new Auth();
$auth->redirectIfNotLoggedIn();
$auth->redirectIfNotManager();

$catalog = new VacationCatalog();

// Handle approve/reject actions
if (isset($_GET['action'])) {
    $status = ($_GET['action'] === 'approve') ? 'approved' : 'rejected';
    $requestId = (int)$_GET['request_id'];
    
    // VacationCatalog to handle this
    $db = (new Database())->getConnection();
    $stmt = $db->prepare("UPDATE vacation_requests SET status = ? WHERE id = ?");
    $stmt->execute([$status, $requestId]);
    
    header("Location: /manager/dashboard.php");
    exit();
}

// Get all requests 
$allRequests = $catalog->getAllRequests();
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="container mt-4">
<div class="card">
    <div class="card-header">Vacation Requests</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Duration</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allRequests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request->getUserName()) ?></td>
                        <td><?= htmlspecialchars($request->getStartDate()->format('Y-m-d')) ?> </td>
                        <td><?= htmlspecialchars($request->getEndDate()->format('Y-m-d')) ?></td>
                        <td><?= $request->getDuration() ?> days</td>
                        <td><?= htmlspecialchars($request->getReason())?> </td>
                        <td>
                            <span class="badge bg-<?= 
                                $request->getStatus() === 'approved' ? 'success' : 
                                ($request->getStatus() === 'rejected' ? 'danger' : 'warning') 
                            ?>"> <?= $request->getStatus() ?></span>
                        </td>
                        <td>
                            <a href="?action=approve&request_id=<?= $request->getId() ?>" 
                               class="btn btn-sm btn-success">Approve</a>
                            <a href="?action=reject&request_id=<?= $request->getId() ?>" 
                               class="btn btn-sm btn-danger">Reject</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
