<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php';

$auth = new Auth();
$auth->redirectIfNotLoggedIn();
$user = $auth->getCurrentUser();
$catlog = new VacationCatalog();

// Handle new vacation request 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $request = new VacationRequest($user['id'] ,$_POST['start_date'], $_POST['end_date'], $_POST['reason'], 'pending');
    
    if ($catlog->insertRequest($request)) {
        $success = "Request submitted successfully!";
    } else {
        $error = "Failed to submit request.";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'deleteRequest') {
    $requestId = (int)$_GET['request_id'];
    
    if ($catlog->deleteRequest($requestId)) {
        $success = "Request deleted";
    } else {
        $error = "Failed to delete request.";
    }
}

// Get all my requests.
$requests = $catlog->getUserRequests($user['id']);
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

    <div class="container mt-4">
        <h1>Leave Management System</h1>
        <h2>Welcome, <?= $user['full_name'] ?> (Employee)</h2>
        <!-- log out -->
        <div class="card mb-4">
            <div class="card-body float-right">
                <form action="../logout.php" method="GET">
                        <button type="submit" class="btn btn-primary mt-3 float-right">Log out</button>
                
                </form>
            </div>
        </div>
        
        <!-- Vacation Request Form -->
        <div class="card mb-4">
            <div class="card-header">Submit Vacation Request</div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php elseif (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Reason</label>
                            <select class="form-select" id="reason" name="reason" required>
                                <option value="" selected disabled>Select a reason...</option>
                                <option value="sick_leave">Sick Leave</option>
                                <option value="holiday">Annual Leave/Holiday</option>
                                <option value="maternity_leave">Maternity Leave</option>
                                <option value="paternity_leave">Paternity Leave</option>
                            </select>
                        </div> 
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>



        <!-- all requests -->
        <div class="card">
            <div class="card-header">Your Requests</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Submitted At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $request): ?>
                            <tr>
                                <td><?= htmlspecialchars($request->getStartDate()->format('Y-m-d')) ?> </td>
                                <td><?= htmlspecialchars($request->getEndDate()->format('Y-m-d')) ?></td>
                                <td><?= $request->getDuration() ?> days</td>
                                <td><?= $request->getReason() ?> </td>
                                <td><?= htmlspecialchars($request->getSubmittedAt()->format('Y-m-d')) ?></td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $request->getStatus() === 'approved' ? 'success' : 
                                        ($request->getStatus() === 'rejected' ? 'danger' : 'warning') 
                                    ?>">
                                    <?= ucfirst($request->getStatus()) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="?action=deleteRequest&request_id=<?= $request->getId() ?>" 
                                        class="badge bg-secondary" 
                                        <?= $request->getStatus() === 'pending' ? 'displayed' : 'hidden' ?> > Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
