<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php';


session_unset();
session_destroy();
header("Location: login.php");
exit();
//require Config::path('login.php');


?>
