<?php
session_start();
include('../includes/db.php');

// Handle product approval/rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve_product'])) {
        $pending_id = $_POST['product_id'];

        // Fetch the product from pending_products
        $stmt = $conn->prepare("SELECT * FROM pending_products WHERE id = ?");
        $stmt->bind_param("i", $pending_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        if ($product) {
            
            // Insert into products table
            $insert = $conn->prepare("INSERT INTO products 
                (name, category_name, price, description, image,quantity, seller_id) 
                VALUES (?, ?, ?, ?, ?,?, ?)");
            $insert->bind_param(
                "sssssis",
                $product['name'],
                $product['category_name'],
                $product['price'],
                $product['description'],
                $product['image'],
                $product['quantity'],
                $product['seller_id']
            );

            if ($insert->execute()) {
                // Delete from pending_products after successful insert
                $delete = $conn->prepare("DELETE FROM pending_products WHERE id = ?");
                $delete->bind_param("i", $pending_id);
                $delete->execute();
            } else {
                echo "Insert failed: " . $insert->error;
            }
        }
    } elseif (isset($_POST['reject_product'])) {
        $pending_id = $_POST['product_id'];
        $delete = $conn->prepare("DELETE FROM pending_products WHERE id = ?");
        $delete->bind_param("i", $pending_id);
        $delete->execute();
    }
}

// Fetch all sellers
$sql = "SELECT * FROM sellers ORDER BY created_at DESC";
$result = $conn->query($sql);

// Fetch pending products
$pending_query = "SELECT * FROM pending_products";
$pending_result = $conn->query($pending_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
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
      font-size:30px;
      color: #4d2c19;
      text-align:center;
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

        table { width: 100%; border-collapse: collapse; background: white; margin-bottom: 40px; }
        th, td { border: 1px solid #ccc; padding: 12px; text-align: center; }
        th { background: #ddd; }
        button { padding: 6px 10px; cursor: pointer; }
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
            text-align: center;
            padding: 10px 0;
            background: #f0e1b5;
            margin-top: 220px;
             display: flex;
            justify-content: center;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="navbar">
    <div class="logo-container">
      <img src="../images/logo.jpg" alt="Eco Crafty Logo">
    </div>
    <h1> Admin </h1>
    <div class="logout">
    <a href="logout.php">Logout</a>
</div>
  </div>

<h1>Seller Requests</h1>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Business</th>
        <th>Proof</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['shop_name']) ?></td>
        <td><a href="../uploads/<?= $row['proof'] ?>" target="_blank">View</a></td>
        <td><?= $row['status'] ?></td>
        <td>
            <?php if ($row['status'] == 'pending'): ?>
                <form action="process_seller.php" method="POST" style="display:inline-block;">
                    <input type="hidden" name="seller_id" value="<?= $row['id'] ?>">
                    <button name="action" value="approve">Approve</button>
                    <button name="action" value="reject">Reject</button>
                </form>
            <?php else: ?>
                <?= ucfirst($row['status']) ?>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h1>Pending Product Approvals</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Description</th>
        <th>Image</th>
        <th>Quantity</th>
        <th>Seller ID</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $pending_result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['category_name']) ?></td>
        <td>₹<?= $row['price'] ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td>
            <?php if (!empty($row['image']) && file_exists("../" . $row['image'])): ?>
               
                <a href="../<?= $row['image'] ?>" target="_blank">View</a>

            <?php else: ?>
                <span style="color:red;">No Image</span>
            <?php endif; ?>
        </td>
        <td><?=$row['quantity']?></td>
        <td><?= $row['seller_id'] ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <button type="submit" name="approve_product">Approve</button>
            </form>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <button type="submit" name="reject_product">Reject</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<footer>
    © 2025 Eco Crafty. Handmade with love for a greener world.
  </footer>
</body>
</html>
