<?php
session_start();

if(isset($_POST['adminLogin'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username === "admin" && $password === "admin123"){
        $_SESSION['admin'] = true;
        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Admin Login');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - HappyTails</title>
<link rel="stylesheet" href="style.css">

<style>

/* Admin Login Card */
.admin-login-card{
    max-width:400px;
    margin:100px auto;
    background:white;
    padding:40px;
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,0.1);
    animation:fadeUp 0.6s ease;
}

.admin-login-card h2{
    margin-bottom:25px;
    color:#2c3e50;
    border-left:4px solid #1abc9c;
    padding-left:10px;
    text-align:center;
}

.admin-login-card input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:14px;
    transition:0.3s;
}

.admin-login-card input:focus{
    border-color:#1abc9c;
    box-shadow:0 0 6px rgba(26,188,156,0.3);
    outline:none;
}

</style>
</head>
<body>

<!-- Same Navbar Style -->
<nav class="navbar">
    <div class="logo">🐶 HappyTails Pet Care</div>
</nav>

<div class="admin-login-card">

    <h2>Administrator Login</h2>

    <form method="POST" id="adminLoginForm">

        <input type="text" name="username" id="username" placeholder="Admin Username" required>

        <input type="password" name="password" id="password" placeholder="Password" required>

        <button type="submit" name="adminLogin" class="submit-btn">
            Login
        </button>

    </form>

</div>

<script>

/* Simple Validation */
document.getElementById("adminLoginForm").addEventListener("submit", function(e){

    let user = document.getElementById("username").value.trim();
    let pass = document.getElementById("password").value.trim();

    if(user === "" || pass === ""){
        alert("Please fill all fields");
        e.preventDefault();
    }

});

</script>

</body>
</html>
