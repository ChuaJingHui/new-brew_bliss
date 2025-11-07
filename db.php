<?php
// Define database connection parameters for MySQLi
$host = 'localhost';
$user = 'root'; // Make sure this is the correct username for your MySQL
$pass = '';     // Make sure this is the correct password for your MySQL (it's often empty for root on XAMPP/WAMP)
$db   = 'brew_bliss'; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    // !!! CRITICAL FIX HERE !!!
    // Do NOT die() with an HTML message.
    // Set JSON header and output a JSON error, then exit.
    header('Content-Type: application/json'); // Ensure header is set even on error
    echo json_encode([
        'success' => false, // Added success: false for consistency
        'message' => 'Database connection failed.',
        'details' => $conn->connect_error // This will give you specific details about the connection failure
    ]);
    exit(); // Stop script execution immediately
}

// Set charset for the connection
$conn->set_charset("utf8mb4");

// No 'return $conn;' needed, as the $conn variable is now globally available
// through the include, or if you prefer, you can return it and catch it in customer_orders.php
// For simplicity, we'll rely on it being included.
?>