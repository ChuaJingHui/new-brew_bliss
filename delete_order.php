<?php
// Set the content type to JSON so the client knows how to parse the response
header('Content-Type: application/json');

// Initialize a default response (will be updated based on success/failure)
$response = ['success' => false, 'message' => 'An unknown error occurred.'];

// Include your database connection file (the unified db.php)
require 'db.php'; // <--- Corrected to include the unified db.php

// 1. Get the raw POST data (this is the JSON sent from your JavaScript)
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true); // Decode the JSON string into a PHP associative array

// 2. Check if 'order_id' was sent in the request
if (isset($data['order_id'])) {
    $orderId = $data['order_id'];

    try {
        // 3. Prepare an SQL DELETE statement
        // Use the $pdo object from db.php
        $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = :order_id");
       
        // 4. Bind the parameter
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT); // Assuming order_id is an integer

        // 5. Execute the prepared statement
        if ($stmt->execute()) {
            // 6. Check if any rows were actually affected (deleted)
            if ($stmt->rowCount() > 0) {
                $response = ['success' => true, 'message' => 'Order deleted successfully.'];
            } else {
                $response = ['success' => false, 'message' => 'No order found with the specified ID to delete.'];
            }
        } else {
            // Error executing the SQL query
            $response = ['success' => false, 'message' => 'Failed to execute delete query.'];
        }
    } catch (PDOException $e) {
        // Catch any database-related errors
        $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
} else {
    // If order_id was not provided in the request
    $response = ['success' => false, 'message' => 'Order ID not provided in the request.'];
}

// 7. Encode the PHP response array into JSON and send it back to the client
echo json_encode($response);
?>