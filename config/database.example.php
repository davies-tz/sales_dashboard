<?php
/**
 * Database Configuration — EXAMPLE FILE
 * 
 * Copy this file to: config/database.php
 * Then fill in your actual credentials.
 * 
 * NEVER commit config/database.php to Git!
 */

define('DB_HOST',    'localhost');
define('DB_NAME',    'sales_dashboard');
define('DB_USER',    'your_db_username');
define('DB_PASS',    'your_db_password');
define('DB_CHARSET', 'utf8mb4');

class Database {
    private static ?PDO $instance = null;

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
            }
        }
        return self::$instance;
    }

    private function __construct() {}
    private function __clone() {}
}
