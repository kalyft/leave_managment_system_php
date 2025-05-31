<?php
// Define the absolute application path
define('APP_ROOT', __DIR__);

// Manually load Config class first since everything depends on it
require_once APP_ROOT . '/classes/Config.php';

// Initialize configuration
Config::initialize(APP_ROOT);

// Then set up autoloader for other classes
spl_autoload_register(function ($className) {
    $file = Config::path('classes/' . str_replace('\\', '/', $className) . '.php');
    if (file_exists($file)) {
        require $file;
    }
});

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
