<?php
session_start();
include('../includes/db.php');

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $aadhar = trim($_POST['aadhar']);
    $shop_name = trim($_POST['shop_name']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    $proofFile = $_FILES['proof'];
    $proofPath = '';

    // Handle proof file upload
    if ($proofFile['error'] === 0) {
        $ext = pathinfo($proofFile['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $uploadDir = '../uploads/seller_proofs/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $proofPath = $uploadDir . $filename;
        move_uploaded_file($proofFile['tmp_name'], $proofPath);
    } else {
        $error = "Please upload valid proof document.";
    }

    if (empty($error)) {
        $stmt = $conn->prepare("INSERT INTO sellers (name, email, phone, aadhar_number, shop_name, proof, password, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("sssssss", $name, $email, $phone, $aadhar, $shop_name, $proofPath, $password);
        if ($stmt->execute()) {
            $success = "Registration submitted. Wait for admin approval.";
        } else {
            $error = "Email already registered or error occurred.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Seller Registration - Eco Crafty</title>
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
      font-size: 28px;
      color: #4d2c19;
      margin-right:600px;
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

    .container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #4d2c19;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #333;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    .btn {
      margin-top: 20px;
      background: #4d2c19;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      cursor: pointer;
    }
    .btn:hover {
      background: #603d23;
    }
    .message {
      margin-top: 15px;
      padding: 10px;
      border-radius: 6px;
      text-align: center;
    }
    .success { background: #d4edda; color: #155724; }
    .error { background: #f8d7da; color: #721c24; }
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
    <h1> Seller Registration</h1>
  </div>
  <div class="container">
    <h2>Become a Seller</h2>

    <?php if ($success): ?>
      <div class="message success"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
      <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <label>Name</label>
      <input type="text" name="name" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Phone Number</label>
      <input type="text" name="phone" required>

      <label>Aadhar Number</label>
      <input type="text" name="aadhar" required>

      <label>Business/Shop Name</label>
      <input type="text" name="shop_name" required>

      <label>Upload Business Proof</label>
      <input type="file" name="proof" accept=".jpg,.png,.pdf" required>

      <label>Password</label>
      <input type="password" name="password" required>

      <button type="submit" class="btn">Register</button>
    </form>
  </div>
  <footer>
    © 2025 Eco Crafty. Handmade with love for a greener world.
  </footer>
</body>
</html>
