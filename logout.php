<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php';

$auth = new Auth();
$auth->logout();
header("Location: login.php");
exit();
?>