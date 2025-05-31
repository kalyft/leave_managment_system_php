<?php
// Initialize test database (runs before all tests)
require __DIR__.'/../vendor/autoload.php';

// Migrate test database
$pdo = new PDO(
    "mysql:host=".getenv('MYSQL_HOST').";dbname=".getenv('MYSQL_DATABASE'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);

