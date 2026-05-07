<?php
session_start();
include "Rconfig.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users - HappyTails</title>
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

    <div class="admin-main">
        <h1>User Data</h1>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
<?php
$users = mysqli_query($conn, "SELECT full_name, phone, email FROM users");
while($user = mysqli_fetch_assoc($users)){
?>
<tr>
    <td><?php echo $user['full_name']; ?></td>
    <td><?php echo $user['phone']; ?></td>
    <td><?php echo $user['email']; ?></td>
</tr>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
