<?php
session_start();
include("../includes/db.php");

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($pass !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "Registration successful!";
                header("refresh:2;url=homepage.php");
            } else {
                $error = "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: #fefefe;
    }
     header {
      background-color: #f0e1b5;
      text-align: center;
      padding: 15px 0;
      position: fixed;
      width: 100%;
      bottom: 0;
    }
    .logo-container {
      width: 70px;
      height: 70px;
      margin-left: 20px;
      overflow: hidden;
      border-radius: 50%;
    }

    .logo-circle {
      width: 110%;
      height: 110%;
      object-fit: cover;
    }
    .navbar {
      width: 100%;
      background-color: #f0e1b5;
      color: black;
      display: flex;
      align-items: center;
      padding: 15px 20px;
      position: fixed;
      top: 0;
      height: 80px;
    }
    .navbar h1 {
      position: absolute;
      left: 35%;
      font-size: 28px;
      font-weight: bold;
      letter-spacing: 1px;
    }
    .register-box {
      width: 360px;
      margin-top: 100px;
      background: #fff;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .register-box h2 {
      text-align: center;
      margin-bottom: 25px;
    }

    .register-box input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .register-box button {
      width: 100%;
      padding: 10px;
      background-color: #63d471;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 4px;
      cursor: pointer;
    }

    .register-box button:hover {
      background-color: #50c05e;
    }

    .message {
      text-align: center;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .success {
      color: green;
    }

    .error {
      color: red;
    }

    footer {
      background-color: #f0e1b5;
      text-align: center;
      padding: 15px 0;
      position: fixed;
      width: 100%;
      bottom: 0;
    }
   
  </style>
</head>
<body>

  <header>
    <div class="navbar">
      <div class="logo-container">
        <img src="../images/logo.jpg" class="logo-circle">
      </div>
      <h1>Registration For EcoCrafty</h1>
    </div>
  </header>

  <div class="register-box">
    <h2>Register</h2>

    <?php if (!empty($success)) echo "<div class='message success'>$success</div>"; ?>
    <?php if (!empty($error)) echo "<div class='message error'>$error</div>"; ?>

    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <button type="submit">Sign Up</button>
      <p style="text-align: center;margin-top: 15px;">Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>

  <footer>
    © 2025 Eco Crafty. Handmade with love for a greener world.
  </footer>

</body>
</html>
