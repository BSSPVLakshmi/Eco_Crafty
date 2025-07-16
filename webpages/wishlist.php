<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}
$isLoggedIn = isset($_SESSION['userid']);


$user_id = $_SESSION['userid'];

// Get wishlist items with product info
$sql = "SELECT p.*, w.product_id 
        FROM wishlist w 
        JOIN products p ON w.product_id = p.id 
        WHERE w.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$wishlist = [];
while ($row = $result->fetch_assoc()) {
    $wishlist[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Wishlist </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="../categorystyle.css" />
  
    <style>
        
        .wishlist-grid {
            display: flex;
            flex-wrap: wrap;
           
        max-width: 1200px;
            gap: 20px;
            justify-content: center;
            margin:auto;
        }

        .product-card {
            width: 240px;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            position: relative;
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }

        .product-card h3 {
            margin: 10px 0;
            font-size: 18px;
        }.product-card .btn {
       background-color: rgb(219, 189, 72);
      color:  #4d2c19;;
      padding: 8px 12px;
      border: none;
      border-radius: 14px;
      text-decoration: none;
      display: inline-block;
      margin-top: 10px;
      cursor: pointer;
    }
    .btn:hover {
      background-color: rgb(219, 189, 72);
    }

        .price {
            color: green;
            font-size: 16px;
            margin-bottom: 10px;
        }

       
        .wishlist-icon {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      color: #ccc;
      cursor: pointer;
    }

        .wishlist-icon:not(.active) {
            color: #ccc;
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
<h1>Your Wishlist</h1>
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
    </div>
    <div class="container">
<div class="wishlist-grid">
    <?php if (!empty($wishlist)): ?>
        <?php foreach ($wishlist as $item): ?>
            <div class="product-card">
                <img src="../<?php echo $item['image']; ?>" alt="Product">
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p class="price">₹<?php echo $item['price']; ?></p>
                <span class="wishlist-icon active" data-id="<?php echo $item['id']; ?>" onclick="toggleWishlist(this)">❤️</span>
<?php if ($isLoggedIn): ?>
    <button class="btn" onclick="addToCart(<?php echo $item['id']; ?>)">Add to Cart</button>
<?php else: ?>
    <button class="btn" onclick="window.location.href='login.php'">Add to Cart</button>
<?php endif; ?>

            
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center; font-size: 18px; color: gray;">No items in your wishlist.</p>
    <?php endif; ?>
</div>
    </div>
<script>
    function addToCart(productId) {
  fetch('addtocart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'product_id=' + encodeURIComponent(productId)
  })
  .then(response => {
    if (response.ok) {
      alert('Product added to cart!');
    } else {
      alert('Failed to add product.');
    }
  })
  .catch(() => alert('Error adding to cart.'));
}
function toggleWishlist(el) {
    const productId = el.getAttribute("data-id");

    fetch("wishlist_toggle.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "product_id=" + productId
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "removed") {
            el.parentElement.remove(); // Remove product card
        }
    });
}
</script>
<footer>
    <p>&copy; 2025 Eco Crafty. Handmade with love for a greener world.</p>
  </footer>
</body>
</html>

