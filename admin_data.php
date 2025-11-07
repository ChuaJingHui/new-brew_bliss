<?php
// --- Start Error Logging/Display Control (Place at the absolute top) ---
ini_set('display_errors', 0); // Stop displaying errors to the browser (CRITICAL for JSON APIs)
ini_set('log_errors', 1);    // Enable logging errors to a file
ini_set('error_log', __DIR__ . '/php_error.log'); // Specify a log file path in the same directory
error_reporting(E_ALL);      // Report all types of errors
// --- End Error Logging/Display Control ---

header('Content-Type: application/json'); // This should be the first actual output line

require 'db.php'; // Use require to ensure db.php is loaded, using the unified file

$orders = [];
$purchases = [];

try {
    // Use PDO for fetching orders
    $stmt_orders = $pdo->query("SELECT order_id, id, product_name, price, quantity FROM order_items ORDER BY order_id DESC LIMIT 50");
    $orders = $stmt_orders->fetchAll();

    // Use PDO for fetching purchases
    $stmt_purchases = $pdo->query("SELECT id, username, phone, address, card_number, expiry_month, expiry_year, cvv, remark, purchase_time FROM purchasehistory ORDER BY id DESC LIMIT 50");
    $purchases = $stmt_purchases->fetchAll();

    echo json_encode(['orders' => $orders, 'purchases' => $purchases]);

} catch (\PDOException $e) {
    // Catch any PDO exceptions that occur during query execution
    // Output a JSON error
    echo json_encode([
        'error' => 'Database query failed.',
        'details' => $e->getMessage() // This will give specific details about the query error
    ]);
    // Also log the error to the php_error.log for server-side debugging
    error_log("PDO Query Error: " . $e->getMessage());
    exit(); // Stop execution
} catch (\Exception $e) {
    // Catch any other general PHP exceptions
    echo json_encode([
        'error' => 'An unexpected server error occurred.',
        'details' => $e->getMessage()
    ]);
    error_log("General PHP Error: " . $e->getMessage());
    exit();
}
?>