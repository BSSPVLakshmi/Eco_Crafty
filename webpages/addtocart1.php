<?php
session_start();
require_once '../includes/db.php';

// Check login
if (!isset($_SESSION['username'])) {
    echo "login_required";
    exit();
}

$username = $_SESSION['username'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if (!$product_id) {
    echo "invalid_product";
    exit();
}

// Check if product already in cart
$sql = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $username, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If exists, increase quantity
    $row = $result->fetch_assoc();
    $newQty = $row['quantity'] + 1;

    $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $update->bind_param("ii", $newQty, $row['id']);
    if ($update->execute()) {
        echo "updated";
    } else {
        echo "update_failed";
    }
} else {
    // If not exists, insert new row
    $insert = $conn->prepare("INSERT INTO cart (username, product_id, quantity, added_at) VALUES (?, ?, 1, NOW())");
    $insert->bind_param("ii", $user_id, $product_id);
    if ($insert->execute()) {
        echo "inserted";
    } else {
        echo "insert_failed";
    }
}
?>

