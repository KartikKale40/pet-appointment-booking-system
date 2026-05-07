<?php
session_start();
include "Rconfig.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin-login.php");
    exit();
}

/* ========================
   DASHBOARD COUNTS
======================== */

$totalPatients = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(DISTINCT pet_name) as total FROM appointments"))['total'];

$totalBookings = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM appointments"))['total'];

$pendingCount = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM appointments WHERE status='Pending'"))['total'];

$totalUsers = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM users"))['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - HappyTails</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-layout">

    <!-- Sidebar -->
    <div class="admin-sidebar">
        <h2 class="admin-title">Administrator</h2>
        <a href="admin-logout.php"><button class="admin-logout">Logout</button></a>
<ul>
    <li class="admin-menu <?php if(basename($_SERVER['PHP_SELF'])=='admin-dashboard.php'){echo 'active';} ?>">
        <a href="admin-dashboard.php">Dashboard</a>
    </li>
    <li class="admin-menu <?php if(basename($_SERVER['PHP_SELF'])=='schedule.php'){echo 'active';} ?>">
        <a href="schedule.php">Schedules</a>
    </li>
    <li class="admin-menu <?php if(basename($_SERVER['PHP_SELF'])=='appointments.php'){echo 'active';} ?>">
        <a href="appointments.php">Appointments</a>
    </li>
    <li class="admin-menu <?php if(basename($_SERVER['PHP_SELF'])=='users_info.php'){echo 'active';} ?>">
        <a href="users_info.php">User Data</a>
    </li>
</ul>

    </div>

    <!-- Main Content -->
    <div class="admin-main">
        <h1>Dashboard Overview</h1>

        <div class="admin-grid">
            <div class="admin-card">
                <h3>Total Patients</h3>
                <p><?php echo $totalPatients; ?></p>
            </div>
            <div class="admin-card">
                <h3>Total Bookings</h3>
                <p><?php echo $totalBookings; ?></p>
            </div>
            <div class="admin-card">
                <h3>Pending Requests</h3>
                <p><?php echo $pendingCount; ?></p>
            </div>
            <div class="admin-card">
                <h3>Total Users</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
