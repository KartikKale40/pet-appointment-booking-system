<?php
session_start();
include "Rconfig.php";

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Use prepared statement (secure)
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: user.php");
            exit();
        }
        else{
            echo "<script>alert('Incorrect Password');</script>";
        }
    }
    else{
        echo "<script>alert('User Not Found');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>User Login - HappyTails</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">🐶 HappyTails Pet Care</div>
</nav>

<section class="section active">
    <div class="card">
        <h2>User Login</h2>

        <form method="POST" action="">

            <table class="form-table">
                <tr>
                    <td>
                        <input type="text" name="username" placeholder="Username" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="password" name="password" placeholder="Password" required>
                    </td>
                </tr>
            </table>

            <button type="submit" name="login" class="submit-btn">
                Login
            </button>

            <p style="margin-top:15px;">
                New user? <a href="register.php">Create Account</a>
            </p>

        </form>
    </div>
</section>
<script src="script.js"></script>
</body>
</html>
