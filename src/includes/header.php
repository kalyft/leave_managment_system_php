<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php';

$auth = new Auth();
$user = $auth->getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Leave Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">

        <?php 
            if ($auth->isManager()) {
                include $_SERVER['DOCUMENT_ROOT'] . '/manager/navigation_bar.php';
            }
        ?>
    </div>