<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['seller_id'])) {
    header("Location: seller_login.php");
    exit();
}
$success='';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_SESSION['seller_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $quantity=$_POST['quantity'];

    // Handle image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
    $targetDir = "../images/";
    $filename = time() . '_' . basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $filename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        $image = "images/" . $filename;  // Store relative path for database
    }
}

    

    // Insert into pending_products table
    $stmt = $conn->prepare("INSERT INTO pending_products (seller_id, name, price, description, image, category_name,quantity) VALUES (?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("isssssi", $seller_id, $name, $price, $description, $image, $category,$quantity);

    if ($stmt->execute()) {
        $success = "Product submitted. Wait for admin approval."; 
        //<script> window.location.href='seller_home.php'</script>


        //echo "<script>alert('Product submitted for admin approval'); </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
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
      margin-bottom: 2px;
      font-weight: bold;
      color: #333;
    }
    input[type="text"],
    input[type="number"],
    input[type="password"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    textarea{
        width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    select{
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
    <h1> Upload Your Products</h1>
  </div>
  <div class="container">
    <?php if ($success): ?>
      <div class="message success"><?php echo $success; ?></div>
    
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>
        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label for="category">Category:</label><br>
            <select name="category" id="category" required>
                <option value="">-- Select Category --</option>
                <option value="Jewellery">Jewellery</option>
                <option value="Bags">Bags</option>
                <option value="Decor">Decor</option>
                <option value="Baskets">Baskets</option>
                <option value="Stationary">Stationary</option>
                <option value="Paintings">Paintings</option>
                <option value="Crochet Bags">Crochet Bags</option>
            </select><br><br>


        <label>Quantity:</label><br>
        <input type="number" step="0.01" name="quantity" required><br><br>

        <label>Image:</label><br>
        <input type="file" name="image" required><br><br>

        <button type="submit" class="btn">Upload Product</button>
    </form>
    </div>
    <footer>
    © 2025 Eco Crafty. Handmade with love for a greener world.
  </footer>
</body>
</html>
