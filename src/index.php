<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php';

$auth = new Auth();

if ($auth->isLoggedIn()) {
    $user = $auth->getCurrentUser();
    $dashboard = $user['role'] === 'manager' 
        ? Config::path('manager/dashboard.php') 
        : Config::path('employee/dashboard.php');
    
    include $dashboard;
    header("Location: $dashboard");
} else {
    require Config::path('login.php');
}
?>
