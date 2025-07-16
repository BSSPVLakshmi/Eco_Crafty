<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'login_required']);
    exit();
}

require_once '../includes/db.php';

$user_id = $_SESSION['userid'];
$product_id = $_POST['product_id'] ?? 0;

$check = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
$check->bind_param("ii", $user_id, $product_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    $delete = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $delete->bind_param("ii", $user_id, $product_id);
    $delete->execute();
    echo json_encode(['status' => 'removed']);
} else {
    $insert = $conn->prepare("INSERT INTO wishlist (user_id, product_id, added_at) VALUES (?, ?, NOW())");
    $insert->bind_param("ii", $user_id, $product_id);
    $insert->execute();
    echo json_encode(['status' => 'added']);
}
?>


