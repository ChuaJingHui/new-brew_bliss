<?php
ini_set('display_errors', 1); // Temporarily hide errors from output
error_reporting(E_ALL);
session_start();
include 'db.php'; // Include your database connection script

header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false, 'message' => 'An unknown error occurred.', 'orders' => []];

// Get the POST data from the request body
$input = json_decode(file_get_contents('php://input'), true);

$username = $input['username'] ?? '';
$phone = $input['phone'] ?? '';

if (empty($username) || empty($phone)) {
    http_response_code(400); // Bad Request
    $response['message'] = 'Username and phone number are required.';
    echo json_encode($response);
    exit;
}

// 1. Verify username and phone number directly in the 'purchasehistory' table
//    ASSUMPTION: 'purchasehistory' table has 'id', 'username', and 'phone' columns.
//    We will fetch all unique order IDs associated with this username and phone.
$sql_verify_and_get_order_ids = "SELECT DISTINCT id FROM purchasehistory WHERE username = ? AND phone = ?";
if ($stmt_verify = $conn->prepare($sql_verify_and_get_order_ids)) {
    $stmt_verify->bind_param("ss", $username, $phone); // 'ss' for two strings
    $stmt_verify->execute();
    $result_verify = $stmt_verify->get_result();

    if ($result_verify->num_rows > 0) { // Check if any orders exist for this combination
        $order_ids = [];
        while ($row = $result_verify->fetch_assoc()) {
            $order_ids[] = $row['id'];
        }
        $stmt_verify->close(); // Close this statement before preparing another

        // Convert array of IDs to a comma-separated string for the IN clause
        $ids_string = implode(',', $order_ids);
        // Create placeholders for binding if you want to be more secure with IN clause,
        // but for integer IDs fetched from your own DB, imploding is usually safe.
        // For maximum security with dynamic IN clauses:
        // $placeholders = implode(',', array_fill(0, count($order_ids), '?'));
        // $sql_fetch_orders = "... WHERE ph.id IN ($placeholders) ...";
        // $stmt_orders->bind_param(str_repeat('i', count($order_ids)), ...$order_ids);


        // 2. Fetch all order items for the verified order IDs
        $sql_fetch_orders = "
            SELECT
                ph.id AS order_id,
                ph.purchase_time,
                oi.product_name,
                oi.quantity,
                oi.price
            FROM
                purchasehistory ph
            JOIN
                order_items oi ON ph.id = oi.purchase_id
            WHERE
                ph.id IN ($ids_string)
            ORDER BY
                ph.purchase_time DESC, ph.id DESC;
        ";

        // Using query instead of prepare for IN clause with dynamic number of parameters
        // For true prepared statement with IN, you would dynamically build placeholders and bind.
        // Given that $ids_string comes from database query result (integers), it's generally safe here.
        $result_orders = $conn->query($sql_fetch_orders);

        if ($result_orders) {
            while ($row = $result_orders->fetch_assoc()) {
                $response['orders'][] = $row;
            }
            $response['success'] = true;
            $response['message'] = 'Orders fetched successfully.';
        } else {
            http_response_code(500);
            $response['message'] = 'Failed to retrieve order results.';
            error_log("Error getting order results: " . $conn->error); // Log the actual SQL error
        }

    } else {
        http_response_code(401); // Unauthorized
        $response['message'] = 'Invalid username or phone number.';
        $stmt_verify->close();
    }
} else {
    http_response_code(500);
    $response['message'] = 'Failed to prepare user verification statement.';
    error_log("Error preparing user verification statement: " . $conn->error);
}

$conn->close();
echo json_encode($response);
?>