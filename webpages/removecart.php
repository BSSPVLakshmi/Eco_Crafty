<?php
session_start();

if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    
    if (isset($_SESSION['cart'])) {
        $index = array_search($productId, $_SESSION['cart']);
        if ($index !== false) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // re-index array
        }
    }
}

header("Location: cart.php");
exit();
