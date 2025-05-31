<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php';

$auth = new Auth();
$auth->redirectIfNotLoggedIn();
$auth->redirectIfNotManager();

// Handle approve/reject actions
if (isset($_GET['action'])) {
    $status = ($_GET['action'] === 'approve') ? 'approved' : 'rejected';
    $catalog = new VacationCatalog();
    $requestId = (int)$_GET['request_id'];
    $catalog->updateRequest($requestId, $status);
   
    header("Location: dashboard.php");
    exit();
}

// Get all requests 
$catalog = new VacationCatalog();
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
                    <th>Submitted At</th>
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
                        <td><?= htmlspecialchars($request->getSubmittedAt()->format('Y-m-d')) ?></td>
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

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>