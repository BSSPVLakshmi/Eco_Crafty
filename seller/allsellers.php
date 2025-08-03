<?php
include('../includes/db.php');

$sql = "SELECT * FROM sellers ORDER BY created_at DESC";
$result = $conn->query($sql);
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
      font-size: 30px;
      color: #4d2c19;
      margin-right:630px;
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

        table { width: 95%; border-collapse: collapse; background: white; margin-bottom: 40px;margin-top:30px;margin-left:20px; }
        th, td { border: 1px solid #ccc; padding: 12px; text-align: center; }
        th {
            background-color: #eadaba;
        }
        
        footer {
            text-align: center;
            padding: 10px 0;
            background: #f0e1b5;
            margin-top: 380px;
             display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="navbar">
    <div class="logo-container">
      <img src="../images/logo.jpg" alt="Eco Crafty Logo">
    </div>


<h1>All Sellers Details</h1>
    </div>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Aadhar Number</th>
        <th>Shop Name</th>
        <th>Status</th>
        
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['aadhar_number']) ?></td>
            <td><?= htmlspecialchars($row['shop_name']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            
        </tr>
    <?php endwhile; ?>
</table>
<footer>
    © 2025 Eco Crafty. Handmade with love for a greener world.
  </footer>
</body>
</html>
