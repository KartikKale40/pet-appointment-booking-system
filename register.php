<?php
session_start();
include "Rconfig.php";

if(isset($_POST['register'])){

    $fullName = htmlspecialchars(trim($_POST['fullName']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $address = htmlspecialchars(trim($_POST['address']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if($password !== $confirmPassword){
        echo "<script>alert('Passwords do not match');</script>";
    }
    else{

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");

        if(mysqli_num_rows($checkUser) > 0){
            echo "<script>alert('Username or Email already exists');</script>";
        }
        else{
            $insert = mysqli_query($conn, "INSERT INTO users 
            (full_name, phone, email, address, username, password) 
            VALUES 
            ('$fullName','$phone','$email','$address','$username','$hashedPassword')");

            if($insert){
                echo "<script>alert('Registration Successful'); window.location='login.php';</script>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Registration - HappyTails</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">🐶 HappyTails Pet Care</div>
</nav>

<section class="section active">
    <div class="card">
        <h2>User Registration</h2>

<form method="POST" action="">

            <h3>Personal Information</h3>

            <table class="form-table">
                <tr>
                    <td><input type="text" id="fullName" name="" placeholder="Full Name" required></td>
                    <td><input type="tel" id="phone" name="" placeholder="Phone Number" required></td>
                </tr>
                <tr>
                    <td><input type="email" id="email" name="" placeholder="Email Address" required></td>
                    <td><input type="text" id="address" name="" placeholder="City / Address" required></td>
                </tr>
            </table>

            <h3>Login Details</h3>

            <table class="form-table">
                <tr>
                    <td><input type="text" id="username" name="" placeholder="Create Username" required></td>
                    <td><input type="password" id="password" name="" placeholder="Create Password" required></td>
                </tr>
                <tr>
                    <td><input type="password" id="confirmPassword"  placeholder="Confirm Password" required></td>
                </tr>
            </table>

            <button type="submit" name="register" class="submit-btn">Register</button>


            <p style="margin-top:15px;">
                Already have an account? <a href="login.php">Login Here</a>
            </p>

        </form>
    </div>
</section>

<script src="register.js"></script>
</body>
</html>
