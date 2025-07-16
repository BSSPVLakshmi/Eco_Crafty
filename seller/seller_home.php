<?php
session_start();
if (!isset($_SESSION['seller_id'])) {
    header("Location: seller_login.php");
    exit();
}

require_once '../includes/db.php';

$seller_id = $_SESSION['seller_id'];

// Get seller details
$sellerStmt = $conn->prepare("SELECT * FROM sellers WHERE id = ?");
$sellerStmt->bind_param("i", $seller_id);
$sellerStmt->execute();
$sellerResult = $sellerStmt->get_result();
$seller = $sellerResult->fetch_assoc();



// Get seller's products
$productStmt = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
$productStmt->bind_param("i", $seller_id);
$productStmt->execute();
$productResult = $productStmt->get_result();

// Get seller's orders
$orderStmt = $conn->prepare("
    SELECT 
        o.id AS order_id, o.product_id, o.user_id, o.quantity, o.ordered_at,
        p.name AS product_name, p.price,
        u.name AS customer_name,
        (p.price * o.quantity) AS total_price
    FROM orders o
    JOIN products p ON o.product_id = p.id
    JOIN users u ON o.user_id = u.id
    WHERE p.seller_id = ?
    ORDER BY o.ordered_at DESC
");
$orderStmt->bind_param("i", $seller_id);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>
    <style>
        body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fefaf5;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background: #ece0c0;
      padding: 12px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .navbar h1 {
            position: absolute;
            left:38%;
            font-size: 34px;
            font-weight: bold;
            letter-spacing: 1px;
             color:#4d2c19;
        }

    .logo-container {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      overflow: hidden;
    }

    .logo-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
        h1, h2 {
            text-align: center;
            color: #4d2c19;
        }

        .section {
            margin: 30px auto;
            max-width: 1000px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .product-table, .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #eadaba;
        }
        .addproduct{
            text-align:right;
            margin-left:1100px;
            margin-bottom: 10px;
        }
        .addproduct a{
            text-decoration: none;
          padding: 10px 20px;
            background: #1ba606ff;
            color: white;
            border-radius: 5px;
        }

        .logout {
            text-align: right;
            margin-bottom: 10px;
        }

        .logout a {
            text-decoration: none;
            padding: 10px 20px;
            background: #cc3d3d;
            color: white;
            border-radius: 5px;
        }
        footer {
      background-color: #ece0c0;
      text-align: center;
      padding: 15px;
      margin-top: 30px;
      font-size: 14px;
      color: #4d2c19;
    }
    </style>
</head>
<body>
<div class="navbar">
    <div class="logo-container">
      <img src="../images/logo.jpg" alt="Eco Crafty Logo">
    </div>
    
<h1>Welcome, <?php echo htmlspecialchars($seller['name']); ?> (Seller)</h1>
 <div class="addproduct">
    <a href="seller_addproduct.php">Add Product</a>
</div> 

<div class="logout">
    <a href="../webpages/logout.php">Logout</a>
</div>
</div>

<div class="section">
    <h2>Orders Received</h2>
    <?php if ($orderResult->num_rows > 0): ?>
        <table class="order-table">
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Date</th>
            </tr>
            <?php while ($order = $orderResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td>₹<?php echo $order['total_price']; ?></td>
                    <td><?php echo $order['ordered_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>

<div class="section">
    <h2>Your Products</h2>
    <?php if ($productResult->num_rows > 0): ?>
        <table class="product-table">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Description</th>
                <th>Image</th>
            </tr>
            <?php while ($product = $productResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>₹<?php echo $product['price']; ?></td>
                    <td><?php echo $product['category_name']; ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td><img src="../<?php echo $product['image']; ?>" width="80" heigth="80"></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>
<footer>
    © 2025 Eco Crafty. Handmade with love for a greener world.
  </footer>

</body>
</html>


