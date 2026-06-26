<?php
session_start();
include("config.php");
if(isset($_SESSION['admin'])) {
    header("Location: adminpanel.php");
    exit;
}
// Register
if(isset($_POST['register'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $check = $conn->query("SELECT * FROM admins WHERE username='$username'");
    if($check->num_rows > 0) {
        $error = "Username already exists!";
    } else {
        $conn->query("INSERT INTO admins (username,password) VALUES ('$username','$password')");
        $success = "Registration successful! You can now login.";
    }
}
// Login
if(isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $res = $conn->query("SELECT * FROM admins WHERE username='$username'");
    if($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        if(password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $username;
            header("Location: adminpanel.php");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login/Register</title>
<style>
:root {
    --bgcol: #a86c3e;
    --hov: #7c4f2c;
    /* header */
    --accent-color: #A3C1AD;
    /* soft green */
    --waray: #258300;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background: linear-gradient(135deg, #a86c3e, #c18f60);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    perspective: 1000px;
}

.container {
    width: 400px;
    height: 500px;
    position: relative;
}

.card {
    width: 100%;
    height: 100%;
    position: absolute;
    transform-style: preserve-3d;
    transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border-radius: 15px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.card.flipped {
    transform: rotateY(180deg);
}

.card-face {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.card-back {
    transform: rotateY(180deg);
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #a86c3e;
    font-weight: 600;
}

.form-group {
    margin-bottom: 20px;
    position: relative;
}

input {
    width: 100%;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
    background: #f9f9f9;
    transition: all 0.3s ease;
    font-size: 16px;
}

input:focus {
    outline: none;
    border-color: #8E2DE2;
    background: #fff;
    box-shadow: 0 0 0 2px rgba(142, 45, 226, 0.2);
}

button {
    width: 100%;
    padding: 15px;
    background: #a86c3e;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    margin-top: 10px;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(142, 45, 226, 0.4);
}

button:active {
    transform: translateY(0);
}

.error, .success {
    padding: 12px;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 20px;
    animation: fadeIn 0.5s ease;
}

.error {
    color: #d32f2f;
    background: rgba(211, 47, 47, 0.1);
    border: 1px solid rgba(211, 47, 47, 0.3);
}

.success {
    color: #388e3c;
    background: rgba(56, 142, 60, 0.1);
    border: 1px solid rgba(56, 142, 60, 0.3);
}

.flip-btn {
    background: none;
    border: none;
    color: #8E2DE2;
    text-align: center;
    margin-top: 20px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: underline;
    padding: 5px;
    width: auto;
}

.flip-btn:hover {
    transform: none;
    box-shadow: none;
    color: #4A00E0;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 480px) {
    .container {
        width: 90%;
        height: auto;
        min-height: 500px;
    }
    
    .card-face {
        padding: 20px;
    }
}
</style>
</head>
<body>
<div class="container">
    <div class="card" id="flipCard">
        <!-- Login Form -->
        <div class="card-face">
            <h2>Admin Login</h2>
            <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
            <?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
            <button class="flip-btn" onclick="flipCard()">Don't have an account? Register</button>
        </div>
        
        <!-- Register Form -->
        <div class="card-face card-back">
            <h2>Admin Register</h2>
            <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
            <?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="username" placeholder="New Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="New Password" required>
                </div>
                <button type="submit" name="register">Register</button>
            </form>
            <button class="flip-btn" onclick="flipCard()">Already have an account? Login</button>
        </div>
    </div>
</div>

<script>
function flipCard() {
    const card = document.getElementById('flipCard');
    card.classList.toggle('flipped');
}

// Check if there's an error or success message on the register form
document.addEventListener('DOMContentLoaded', function() {
    const errorElements = document.querySelectorAll('.error');
    const successElements = document.querySelectorAll('.success');
    
    // If there's an error or success on the register side, flip the card
    if (errorElements.length > 0 || successElements.length > 0) {
        const cardBack = document.querySelector('.card-back');
        if (cardBack && (cardBack.querySelector('.error') || cardBack.querySelector('.success'))) {
            document.getElementById('flipCard').classList.add('flipped');
        }
    }
});
</script>
</body>
</html>