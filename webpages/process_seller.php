<?php
session_start();
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $seller_id = $_POST['seller_id'];
    $action = $_POST['action'];

    $status = ($action === "approve") ? "approved" : "rejected";

    $stmt = $conn->prepare("UPDATE sellers SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $seller_id);
    if ($stmt->execute()) {
        header("Location: admin.php");
    } else {
        echo "Error updating seller status.";
    }
}
?>
