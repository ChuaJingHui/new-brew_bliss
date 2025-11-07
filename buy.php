<?php
// This PHP block assumes it's in the same file as the HTML,
// or that the HTML form action points to this same file (e.g., index.php)
// If it's in a separate buy.php, make sure db.php is included there.

// Only process POST requests to avoid displaying PHP errors on initial page load
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php'; // Include your database connection

    // Sanitize and get customer details
    $username    = $conn->real_escape_string($_POST['username']);
    $phone       = $conn->real_escape_string($_POST['phone']); // Phone is now cleaned on client-side
    $address     = $conn->real_escape_string($_POST['address']);
    // Card number is cleaned on client-side before submission
    $card_number = $conn->real_escape_string($_POST['card_number']); 
    $expiry_month= $conn->real_escape_string($_POST['expiry_month']);
    $expiry_year = $conn->real_escape_string($_POST['expiry_year']);
    $cvv         = $conn->real_escape_string($_POST['cvv']);
    $remark      = $conn->real_escape_string($_POST['remark']);

    // Step 1: Insert order into purchasehistory
    // Ensure phone and card_number are treated as strings by the database
    // (requires database columns to be VARCHAR, as discussed)
    $sql_order = "
        INSERT INTO purchasehistory (username, phone, address, card_number, expiry_month, expiry_year, cvv, remark)
        VALUES (
            '$username', 
            '$phone', 
            '$address', 
            '$card_number', 
            '$expiry_month', 
            '$expiry_year', 
            '$cvv',
            '$remark'
        )
    ";

    if ($conn->query($sql_order) === TRUE) {
        $order_id = $conn->insert_id;  // Get the generated order ID

        // Step 2: Insert order items
        $cart_json = $_POST['cart'] ?? '[]';

        if (empty($cart_json)) {
            echo "<script>alert('Cart data is missing!');</script>";
            exit;
        }

        $cart_items = json_decode($cart_json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "<script>alert('Cart JSON Error: " . json_last_error_msg() . "');</script>";
            exit;
        }

        if (is_array($cart_items)) {
            foreach ($cart_items as $item) {
                $product_name = $conn->real_escape_string($item['name']);
                $quantity     = (int)$item['qty']; // Quantity should be int
                $price        = (float)$item['price']; // Price should be float

                $sql_item = "
                    INSERT INTO order_items (id, product_name, quantity, price)
                    VALUES ('$order_id', '$product_name', '$quantity', '$price')
                ";

                if (!$conn->query($sql_item)) {
                    echo "<script>alert('Error inserting order item: " . $conn->error . "');</script>";
                }
            }
        
            // Success message and redirect
            echo "<script>alert('Thank you, $username! Your order has been received.');</script>";
            echo "<script>window.setTimeout(function(){ window.location.href = 'index.html'; }, 1000);</script>";

        } else {
            echo "<script>alert('Cart items are not in array format.');</script>";
        }

    } else {
        echo "Error inserting order: " . $conn->error;
    }
    // Close connection after all operations
    $conn->close();
}
?>