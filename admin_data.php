<?php
header('Content-Type: application/json');
include 'db.php';

$orders = [];
$order_res = $conn->query("SELECT order_id, id, product_name, price, quantity FROM order_items ORDER BY order_id DESC LIMIT 50");
while($row = $order_res->fetch_assoc()){
  $orders[] = $row;
}

$purchases = [];
$purchase_res = $conn->query("SELECT id, username, phone, address, card_number, expiry_month, expiry_year, cvv, purchase_time FROM purchasehistory ORDER BY id DESC LIMIT 50");
while($row = $purchase_res->fetch_assoc()){
  $purchases[] = $row;
}

echo json_encode(['orders'=>$orders, 'purchases'=>$purchases]);
?>
