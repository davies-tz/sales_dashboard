<?php
/**
 * Application Configuration
 * Sales Analytics Dashboard
 */

define('APP_NAME', 'SalesPulse Analytics');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/sales_dashboard/public');
define('ROOT_PATH', dirname(__DIR__));

// Autoloader
spl_autoload_register(function ($class) {
    $paths = [
        ROOT_PATH . '/app/controllers/' . $class . '.php',
        ROOT_PATH . '/app/models/' . $class . '.php',
        ROOT_PATH . '/config/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Load database config
require_once ROOT_PATH . '/config/database.php';

// Session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
