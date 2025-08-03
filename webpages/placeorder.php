<?php
session_start();
include('../includes/db.php');


$user_id = $_SESSION['userid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address']);

    // Default status for new orders
    $status = "Placed";

    // Get all cart items for this user
    $cart_query = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $cart_query->bind_param("i", $user_id);
    $cart_query->execute();
    $cart_result = $cart_query->get_result();

    if ($cart_result->num_rows > 0) {
        while ($item = $cart_result->fetch_assoc()) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];

            // Insert into orders table
            $status="pending";
            $order_query = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, address, status, ordered_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $order_query->bind_param("iiiss", $user_id, $product_id, $quantity, $address, $status);
            $order_query->execute();
        }

        // Clear cart after placing order
        $delete_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $delete_cart->bind_param("i", $user_id);
        $delete_cart->execute();

        echo "<script>alert('Order placed successfully!'); window.location.href='homepage.php';</script>";
    } else {
        echo "Cart is empty.";
    }
}
?>



