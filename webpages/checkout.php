<?php
require_once '../includes/db.php';
session_start();

$isLoggedIn = isset($_SESSION['username']);
$user_id = $_SESSION['userid'];

// Fetch cart products
$sql = "SELECT c.product_id, c.quantity, p.name, p.price, p.image 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$productDetails = $result->fetch_all(MYSQLI_ASSOC);  // ✅ ADD THIS LINE

// Calculate total
$total = 0;
foreach ($productDetails as $product) {
    $total += $product['price'] * $product['quantity'];
}

?>
<!DOCTYPE html>
<html >
<head>
  
  <title>Your Cart </title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="../categorystyle.css" />
  <style>
    .cart-container {
      max-width: 900px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      
    }
    .cart-item {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 20px;
    }
    .cart-item img {
      width: 140px;
      height: 140px;
      object-fit: cover;
      border-radius: 8px;
    }
    .cart-item h3 {
      margin: 0;
      font-size: 18px;
    }
    .cart-item p {
      margin: 4px 0;
    }
    .total {
      text-align:center;
      font-size: 24px;
      font-weight: bold;
      margin-top: 20px;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #333;
    }
    input[type="text"] {
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
    .btn {
      margin-top: 20px;
      margin-left:200px;
     background: #28a745;
      color: white;
      border: none;
      padding: 20px 36px;
      border-radius: 8px;
      cursor: pointer;
      width: 50%;
    }
    footer {
            text-align: center;
            padding: 10px 0;
            background: #f0e1b5;
            margin-top: 40px;
            
            justify-content: center;
          
            width: 100%;
            bottom: 0;
        }
  </style>
</head>
<body>
<div class="navbar">
  
  <div class="logo-container">
    <img src="../images/logo.jpg" class="logo-circle">
  </div>
  <h1>Checkout</h1>
<div class="right-nav">
  <section class="category-bar">
    <div class="category"><a href="homepage.php"><p class="material-icons">home</p> Home</a></div>
    <i class="fa fa-shopping-cart" style="font-size:20px;color:black;"> 
      <a href="<?php echo $isLoggedIn ? 'cart.php' : 'login.php'; ?>">Cart</a>
    </i>
    <div class="category"><a href="wishlist.php">
    <p class="material-icons" >favorite_border</p>Wishlist</a></div>
</section>
<?php if ($isLoggedIn): ?>
    <div class="profile-menu">
      <button class="profile-btn">
        <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
      </button>
      <div class="dropdown">

        <h4>User Name :</h4><p><?php echo $_SESSION['username']; ?></p><br>
        <h4>Email : </h4><p><?php echo $_SESSION['email']; ?></p><br>
       <button> <a href="edit_profile.php">Edit Profile</a>
  </button><br><br>
        <a href="logout.php">Logout</a>
      </div>
    </div>
  <?php else: ?>
    <button class="login-btn"><a href="login.php"><i class="material-icons">person</i><b> Login</b></a></button>
  <?php endif; ?>
  </div>
  </div>
  <div class="container">
<div class="cart-container">
    <?php if (!empty($productDetails)): ?>
        <?php foreach ($productDetails as $product): ?>
            <div class="cart-item">
                <img src="../<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                
                 <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>Price: ₹<?php echo $product['price']; ?></p>
                    

                </div>
            
        <?php endforeach; ?>
            <div class="total">Total: ₹<?php echo $total; ?>
            </div>
            
            <form action="placeorder.php" method="POST">
    
    <label>Full Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Phone Number:</label><br>
    <input type="text" name="phone" required><br><br>

    <label>Address:</label><br>
    <textarea name="address" required></textarea><br><br>

    
    <button type="submit"  class="btn" name="place_order">Place Order</button>
</form>
        </div>
            <?php else: ?>
        <div class="empty">Your cart is empty.</div>
    <?php endif; ?>
        </div>
    </div>
<footer>
    <p>&copy; 2025 Eco Crafty. Handmade with love for a greener world.</p>
</footer>
  
</body>
</html>
