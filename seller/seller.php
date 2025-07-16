<!DOCTYPE html>
<html>
<head>
  <title>Become a Seller - Eco Crafty</title>
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

    .container {
       max-width: 900px;
       margin: auto;
       background: white;
       margin-top:50px;
       padding: 30px;
       border-radius: 10px;
       box-shadow: 0 2px 10px rgba(0,0,0,0.1);
     }

     
    h1 { 
      text-align: center;
       color: #4d2c19;
       }
    .btn { 
      display: inline-block;
       padding: 12px 20px; 
       background: #4d2c19; 
       color: white; 
       text-decoration: none;
        border-radius: 8px;
         margin-top: 20px;
        text-align:center;
        margin-left:40px;
         
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
    <h1>Become a Seller</h1>
  </div>
  <div class="container">
    <h1>Start Selling on Eco Crafty!</h1>
    <p>Reach eco-conscious customers by listing your handmade or eco-friendly products on our platform.</p>
    <h3>How it works:</h3>
    <img  style="width=350px;height:300px;margin-left:150px;" src="../images/seller.jpg" alt="seller image">

    <ul>
      <li>Register with your basic details and business proof</li>
      <br>
      <li>Admin will review and approve your account</li>
      <br>
      
      <li>Start uploading and selling your products</li>
    </ul>
    <p>
      <a href="seller_login.php" class="btn">Login</a>
      <a href="seller_register.php" class="btn">Register</a>
    </p>
  </div>
   <footer>
    © 2025 Eco Crafty. Handmade with love for a greener world.
  </footer>
</body>
</html>
