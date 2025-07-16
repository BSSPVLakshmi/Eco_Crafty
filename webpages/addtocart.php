<?php
session_start();
include('../includes/db.php');

$user_id = $_SESSION['userid'];
$product_id = $_POST['product_id'];

// Check if product already in cart
$query = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
$query->bind_param("ii", $user_id, $product_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    // Increment quantity
    $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id");
} else {
    // Insert new
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, added_at) VALUES (?, ?, 1, NOW())");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
}
?>
