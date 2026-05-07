<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PawCare Appointment System</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">🐶  Pet Care</div>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="book.php">Book Appointment</a></li>
        <li><a href="login.php">Login</a></li>
    </ul>
</nav>

<section class="section active">
    <div class="hero">
        <h1>Professional Pet Care</h1>
        <p>Book appointments for your Cat 🐱 & Dog 🐶 easily</p>

        <?php
        if(isset($_SESSION['user_id'])){
            // User is logged in, normal link to booking page
            echo '<a href="book.php"><button>Book Now</button></a>';
        } else {
            // User not logged in, link triggers JS alert before redirect
            echo '<button onclick="notLoggedIn()">Book Now</button>';
        }
        ?>
    </div>
</section>

<script>
function notLoggedIn(){
    alert("Please login first to book an appointment!");
    window.location.href = "login.php";
}
</script>

</body>
</html>
