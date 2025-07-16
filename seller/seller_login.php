<?php
session_start();
include('../includes/db.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $seller = $res->fetch_assoc();
        if (password_verify($password, $seller['password'])) {
            if ($seller['status'] === 'approved') {
                $_SESSION['seller_id'] = $seller['id'];
                $_SESSION['seller_name'] = $seller['name'];
                header("Location: seller_home.php");
                exit();
            } elseif ($seller['status'] === 'rejected') {
                $error = "Your seller request was rejected by admin.";
            } else {
                $error = "Your registration is under review. Please wait for admin approval.";
            }
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Seller not found with this email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Seller Login - Eco Crafty</title>
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
            left:45%;
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
      max-width: 400px;
      margin: auto;
      background: white;
      padding: 30px;
      margin-top:70px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #4d2c19;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .btn {
      background: #4d2c19;
      color: white;
      padding: 10px 16px;
      width: 100%;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn:hover {
      background: #603d23;
    }

    .message {
      background: #f8d7da;
      color: #721c24;
      padding: 10px;
      border-radius: 6px;
      text-align: center;
      margin-bottom: 10px;
    }

    .link {
      text-align: center;
      margin-top: 15px;
    }

    .link a {
      text-decoration: none;
      color: #4d2c19;
    }
    
     footer {
            text-align: center;
            padding: 15px 0;
            background: #f0e1b5;
            margin-top: 40px;
            display: flex;
            justify-content: center;
            position: fixed;
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
    <h1> Seller Login </h1>
  </div>

<div class="container">
  <h2>Seller Login</h2>

  <?php if ($error): ?>
    <div class="message"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="POST">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button class="btn" type="submit">Login</button>
  </form>

  <div class="link">
    Don't have an account? <a href="seller_register.php">Register here</a>
  </div>
</div>
<footer>
    © 2025 Eco Crafty. Handmade with love for a greener world.
  </footer>

</body>
</html>
