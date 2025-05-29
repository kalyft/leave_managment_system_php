<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php';

$auth = new Auth();
$user = $auth->getCurrentUser();

?>
<h2>Logged in as <?= htmlspecialchars($user['full_name']) ?> (Manager)</h2>
<header>
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link active" href="./dashboard.php">Leaves' Managment</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./users_list.php">Users List</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./create_user.php">Create New User</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="../logout.php">Log Out</a>
      </li>
    </ul>
</header>

