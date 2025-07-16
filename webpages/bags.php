<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
$userId = $_SESSION['userid'] ?? 0;

require_once '../includes/db.php';

// Get all products in 'Decor' category
$sql = "SELECT * FROM products WHERE category_name = 'Bags'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bags Collection</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="../categorystyle.css" /></head>
<body>
<div class="navbar">
        <div class="logo-container">
            <img src="../images/logo.jpg" class="logo-circle" alt="Logo">
        </div>
        <h1>Bags  Collection</h1>
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

<section class="products-section">
  <div class="product-grid">
    <?php while($row = $result->fetch_assoc()): ?>
      <?php
        $product_id = $row['id'];
        $wishlistClass = '';
        if ($isLoggedIn) {
          $check = $conn->query("SELECT * FROM wishlist WHERE user_id = $userId AND product_id = $product_id");
          if ($check && $check->num_rows > 0) {
            $wishlistClass = 'active';
          }
        }
      ?>
      <div class="product-card">
        <span class="wishlist-icon <?php echo $wishlistClass; ?>" 
              data-id="<?php echo $row['id']; ?>" 
              onclick="handleWishlist(this)">
              <?php echo $wishlistClass === 'active' ? '❤️' : '🤍'; ?>
        </span>

        <img src="../<?php echo $row['image']; ?>" alt="Product">
        <h3><?php echo $row['name']; ?></h3>
        <p>₹<?php echo $row['price']; ?></p>
        <button class="btn" onclick="<?php echo $isLoggedIn ? "addToCart({$row['id']})" : "window.location.href='login.php'"; ?>">Add to Cart</button>
      </div>
    <?php endwhile; ?>
  </div>
</section>
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

function handleWishlist(el) {
  const productId = el.getAttribute('data-id');

  <?php if (!$isLoggedIn): ?>
    window.location.href = 'login.php';
    return;
  <?php endif; ?>

  fetch('wishlist_toggle.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'product_id=' + productId
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'added') {
      el.classList.add('active');
      el.innerHTML = '❤️';
    } else if (data.status === 'removed') {
      el.classList.remove('active');
      el.innerHTML = '🤍';
    }
  })
  .catch(() => alert('Wishlist toggle failed'));
}
</script>
<footer>
    <p>&copy; 2025 Eco Crafty. Handmade with love for a greener world.</p>
  </footer>
</body>
</html>
