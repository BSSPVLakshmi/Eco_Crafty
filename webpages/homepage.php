<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Eco Crafty</title>
  <link rel="icon" type="image/x-icon" href="images/logo.jpg">

  <!-- Icons & Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="../style.css" />
  <style>
    .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 30px;
    background-color: #f5e9c5;
}

.right-nav {
    display: flex;
    align-items: center;
    gap: 30px; /* removes any unnecessary margin */
}

.right-nav a {
    text-decoration: none;
    color: #000;
    font-weight: bold;
}

.profile-icon {
    background-color: #8bc34a;
    color: white;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
}

    /* Profile dropdown */
    .profile-menu {
      position: relative;
      display: inline-block;
      margin-left: auto;
      margin-right: 20px;
    }
    .profile-btn {
      background-color:rgb(93, 222, 79);
      border: none;
      font-size: 18px;
      border-radius: 50%;
      width: 45px;
      height: 45px;
      color:white;
      text-align: center;
      cursor: pointer;
    }
    .dropdown {
      display: none;
      position: absolute;
      right: 0;
      background-color: white;
      color:black;
      width: 250px;
      height:250px;
      box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
      padding: 20px;
      z-index: 1;
      border-radius: 8px;
    }
    .profile-menu:hover .dropdown {
      display: block;
    }

    /* Product Grid */
  
    .product-grid {
      display: flex;
        max-width: 1200px;
       padding: 20px 40px;
      flex-wrap: wrap;
      justify-content: center;
        margin: auto;
       flex-wrap: wrap;
      
    }
    .product-card {
       width: 240px;
      border: 1px solid #ccc;
      border-radius: 10px;
      margin: 15px;
     position: relative;
      padding: 15px;
      text-align: center;
      background-color: #fff;
    }
   .product-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px;
    }
    .product-card h3 {
      font-size: 18px;
      margin: 10px 0;
    }
    .product-card .btn {
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
    .wishlist-icon {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      color: #ccc;
      cursor: pointer;
    }
    .wishlist-icon.active {
      color: red;
    }
  </style>
</head>

<body>

<!-- Navbar -->


<div class="navbar">
  
  <div class="logo-container">
    <img src="../images/logo.jpg" class="logo-circle">
  </div>

  <div class="search-container">
    <button class="search-button">
      <i class="material-icons">search</i>
    </button>
    <input type="text" placeholder="Search for products..." class="search-input">
  
  </div>
<div class="right-nav">
  <section class="category-bar">
    <div class="category"><a href="homepage.php"><p class="material-icons">home</p> Home</a></div>
    <div class="category"><a href="contact.html"><i class="fa fa-phone" style="font-size:20px"></i> Contact Us</a></div>
    <div class="category"><a href="../seller/seller.php"><p class="material-icons">storefront</p> Become a Seller</a></div>
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

<!-- Categories -->
<div class="category-section">
  <div class="category-container">
    <a href="jewellery.php" class="category-card">
      <img src="../images/jewellery.jpg" alt="Jewelry">
      <p>Jewellery</p>
    </a>
    <a href="bags.php" class="category-card">
      <img src="../images/bags.jpg" alt="Bags">
      <p>Bags</p>
    </a>
    <a href="decor.php" class="category-card">
      <img src="../images/decor.jpg" alt="Decor">
      <p>Decor</p>
    </a>
    <a href="baskets.php" class="category-card">
      <img src="../images/baskets.jpg" alt="Baskets">
      <p>Baskets</p>
    </a>
    <a href="stationary.php" class="category-card">
      <img src="../images/stationery.jpg" alt="Stationery">
      <p>Stationery</p>
    </a>
    <a href="paintings.php" class="category-card">
      <img src="../images/paintings.jpg" alt="Paintings">
      <p>Paintings</p>
    </a>
    <a href="crochet.php" class="category-card">
      <img src="../images/crochet.jpg" alt="Crochet">
      <p>Crochet Arts</p>
    </a>
  </div>
</div>

<!-- Carousel -->
<div class="carousel">
  <div class="carousel-track" id="carouselTrack">
    <img src="../images/slide.png" alt="1">
    <img src="../images/slide2.png" alt="2">
    <img src="../images/slide3.png" alt="3">
    <img src="../images/slide4.png" alt="4">
  </div>
  <button class="carousel-button prev" onclick="moveSlide(-1)">&#10094;</button>
  <button class="carousel-button next" onclick="moveSlide(1)">&#10095;</button>
</div>

<!-- Product Display -->
<?php
include '../includes/db.php';
$userId = $_SESSION['userid'] ?? 0;
$sql = "SELECT * FROM products LIMIT 12";
$result = $conn->query($sql);
?>
<h1 style="text-align:center; margin-top:30px;">Explore Our Products</h1>
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
      <img src="../<?php echo $row['image']; ?>" alt="Product" >

      <h3><?php echo $row['name']; ?></h3>
      <p>₹<?php echo $row['price']; ?></p>
        <button class="btn" onclick="<?php echo $isLoggedIn ? "addToCart({$row['id']})" : "window.location.href='login.php'"; ?>">Add to Cart</button>
    </div>
    
  <?php endwhile; ?>
</div>
  </section>

   <footer>
    <p>&copy; 2025 Eco Crafty. Handmade with love for a greener world.</p>
  </footer>
<!-- script  code for auto sliding-->

  <script>
    
    const track = document.getElementById("carouselTrack");
    const slides = track.children;
    const totalSlides = slides.length;
    const slideWidth = 1000;
    let index = 0;

    function updateSlide() {
      track.style.transform = `translateX(-${index * slideWidth}px)`;
    }

    function moveSlide(step) {
      index = (index + step + totalSlides) % totalSlides;
      updateSlide();
      resetAutoSlide();
    }

    // Auto Slide
    let autoSlide = setInterval(() => {
      index = (index + 1) % totalSlides;
      updateSlide();
    }, 3000);

    function resetAutoSlide() {
      clearInterval(autoSlide);
      autoSlide = setInterval(() => {
        index = (index + 1) % totalSlides;
        updateSlide();
      }, 3000);
    }
    
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
</body>
</html>
