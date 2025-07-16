<?php
session_start();
require_once '../includes/db.php';

$isLoggedIn = isset($_SESSION['username']);


$user_id = $_SESSION['userid'];

// Handle quantity update directly
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $action = $_POST['action'];

    if ($action === 'increase') {
        $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id");
    } elseif ($action === 'decrease') {
        $conn->query("UPDATE cart SET quantity = GREATEST(quantity - 1, 1) WHERE user_id = $user_id AND product_id = $product_id");
    } elseif ($action === 'remove') {
        $conn->query("DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id");
    }
}

// Fetch cart products
$sql = "SELECT c.product_id, c.quantity, p.name, p.price, p.image 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$productDetails = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $productDetails[] = $row;
    $total += $row['price'] * $row['quantity'];
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
    .quantity-form {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 5px;
    }
    .quantity-form button {
      padding: 4px 10px;
      font-size: 16px;
      cursor: pointer;
    }
    .remove-btn {
        gap:30px;
      right:50%;
      background: red;
      color: white;
      padding: 8px 14px;
      border: none;
      border-radius: 5px;
      cursor: pointer; 
    }
    .total {
      text-align:center;
      font-size: 24px;
      font-weight: bold;
      margin-top: 20px;
    }
    .checkout-btn {
      display: block;
      margin-left: auto;
      margin-top: 20px;
      background: #28a745;
      color: white;
      padding: 12px 24px;
      font-size: 16px;
      text-decoration: none;
      border-radius: 6px;
      text-align: center;
      width: fit-content;
    }
    .empty {
      text-align: center;
      font-size: 30px;
      margin-top: 250px;
      margin-bottom: 250px;
      color: gray;
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
<h1>Your Cart</h1>
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
                <div>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>Price: ₹<?php echo $product['price']; ?></p>
                    <form class="quantity-form" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <button type="submit" name="action" value="decrease">-</button>
                        <strong><?php echo $product['quantity']; ?></strong>
                        <button type="submit" name="action" value="increase">+</button>
                    </form>
                    <br>
                    <p>Total Price: ₹<?php echo $product['price'] * $product['quantity']; ?></p>
                </div>

                <form method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <button class="remove-btn" type="submit" name="action" value="remove">Remove</button>
                </form>
            </div>
        <?php endforeach; ?>

        <div class="total">Total: ₹<?php echo $total; ?></div>
        <a class="checkout-btn" href="checkout.php">Proceed to Checkout</a>

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


