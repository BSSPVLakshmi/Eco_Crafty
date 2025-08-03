<?php
include('../includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ship_order'])) {
    $order_id = $_POST['order_id'];

    // Step 1: Fetch order details
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if ($order) {
        // Step 2: Insert into shipped_orders
        $insert = $conn->prepare("INSERT INTO shipped_orders (user_id, product_id, quantity, address, status, ordered_at) VALUES (?, ?, ?, ?, 'shipped', ?)");
        $insert->bind_param("iiiss", 
            $order['user_id'], 
            $order['product_id'], 
            $order['quantity'], 
            $order['address'], 
            $order['ordered_at']
        );
        $insert->execute();

        // Step 3: Delete from orders
        $delete = $conn->prepare("DELETE FROM orders WHERE id = ?");
        $delete->bind_param("i", $order_id);
        $delete->execute();
    }
}

header("Location: seller_home.php");
exit();
?>
