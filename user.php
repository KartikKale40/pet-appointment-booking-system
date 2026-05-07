<?php
session_start();
include "Rconfig.php";

/* ================= SECURITY ================= */

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];



/* ================= FETCH USER APPOINTMENTS ================= */

$stmt = $conn->prepare("
    SELECT a.pet_name, a.service, sa.appointment_date, sa.time_slot, sa.scheduled_time, sa.charges
    FROM appointments a
    JOIN scheduled_appointments sa ON a.id = sa.appointment_id
    WHERE a.user_id = ?
    ORDER BY sa.appointment_date DESC, sa.scheduled_time ASC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard - HappyTails</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
   <div class="logo">🐶  Pet Care</div>

    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="book.php">Book Appointment</a></li>
        <!-- <li><a href="user-dashboard.php">My Profile</a></li> -->
        <li><a href="user_logout.php">Logout</a></li>
    </ul>
</nav>

<section class="section active">

    <div class="card">
        <h2>My Appointment Details</h2>

        <table class="user-table">
            <thead>
                <tr>
                    <th>Pet Name</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Slot</th>
                    <th>Time</th>
                    <th>Charges (₹)</th>
                </tr>
            </thead>

          <tbody>
<?php
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>".htmlspecialchars($row['pet_name'])."</td>
                <td>".htmlspecialchars($row['service'])."</td>
                <td>".date("d M Y", strtotime($row['appointment_date']))."</td>
                <td>".htmlspecialchars($row['time_slot'])."</td>
                <td>".htmlspecialchars($row['scheduled_time'])."</td>
                <td>₹".htmlspecialchars($row['charges'])."</td>
              </tr>";
    }
} else {
    echo "<tr>
            <td colspan='6'>No Scheduled Appointments Found</td>
          </tr>";
}
?>
</tbody>

        </table>

    </div>

</section>
<script src="script.js"></script>
</body>
</html>
