<?php
session_start();
include '../includes/db.php';

$loginError = '';
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE name = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $email, $hashed_password);
        $stmt->fetch();

        if (password_verify($pass, $hashed_password)) {
            $_SESSION['userid'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            $success = "Login  successful!";
            header("refresh:1;url=homepage.php");
        } else {
            $loginError = "Incorrect password.";
        }
    } else {
        $loginError = "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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

        .navbar h1 {
            position: absolute;
            left: 45%;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .login-box {
            background: #fff;
            padding: 30px 50px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
            margin-top: 120px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .login-box input[type="input"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background-color: #73d773;
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #45a049;
        }

        .login-box p {
            text-align: center;
            margin-top: 15px;
        }

        .login-box a {
            color: #6a23c7;
            text-decoration: none;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        .success {
        color: green;
        text-align: center;
        margin-top: 10px;
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
            <img src="../images/logo.jpg" class="logo-circle" alt="Logo">
        </div>
        <h1>EcoCrafty</h1>
    </div>

    <div class="login-box">
        <h2>Login</h2>
        <?php if (!empty($loginError)) echo "<div class='error'>$loginError</div>"; ?>
        <?php if (!empty($success)) echo "<div class='success'>$success</div>"; ?>
        <form method="POST" action="">
            <input type="input" name="username" placeholder="User Name" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Eco Crafty. Handmade with love for a greener world.</p>
    </footer>
</body>
</html>
