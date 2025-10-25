<?php
// db.php - Unified PDO Database Connection

$host = 'localhost';
$db   = 'brew_bliss';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,       // Throw exceptions on error
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,             // Fetch rows as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                        // Disable emulation for better security
];

try {
    // The connection object will be named $pdo
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Log the error (optional, but good practice)
    error_log("Database connection failed: " . $e->getMessage());
    // In a production environment, you might just show a generic error
    die("Database connection failed: Please try again later.");
}
?>