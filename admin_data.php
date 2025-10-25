<?php
header('Content-Type: application/json');
require 'db.php'; // Use require to ensure db.php is loaded, using the unified file

$orders = [];
// Use PDO for fetching orders
$stmt_orders = $pdo->query("SELECT order_id, id, product_name, price, quantity FROM order_items ORDER BY order_id DESC LIMIT 50");
$orders = $stmt_orders->fetchAll();

$purchases = [];
// Use PDO for fetching purchases
$stmt_purchases = $pdo->query("SELECT id, username, phone, address, card_number, expiry_month, expiry_year, cvv, purchase_time FROM purchasehistory ORDER BY id DESC LIMIT 50");
$purchases = $stmt_purchases->fetchAll();

echo json_encode(['orders' => $orders, 'purchases' => $purchases]);
?>