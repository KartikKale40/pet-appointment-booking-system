<?php
session_start();
include "Rconfig.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin-login.php");
    exit();
}

// Handle scheduling form submission from modal
if(isset($_POST['schedule_modal'])){
    $appointment_id = $_POST['appointment_id'];
    $scheduled_time = $_POST['scheduled_time'];
    $charges = $_POST['charges'];

  
    // Fetch appointment details
    $appointment = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM appointments WHERE id='$appointment_id'"));

    // Insert into scheduled_appointments
    mysqli_query($conn, "INSERT INTO scheduled_appointments (appointment_id, pet_name, pet_type, age, vaccinated, behaviour, service, appointment_date, time_slot, scheduled_time, charges)
        VALUES ('{$appointment['id']}', '{$appointment['pet_name']}', '{$appointment['pet_type']}', '{$appointment['age']}', '{$appointment['vaccinated']}', '{$appointment['behaviour']}', '{$appointment['service']}', '{$appointment['appointment_date']}', '{$appointment['time_slot']}', '$scheduled_time', '$charges')");

    // Update original appointment status
    mysqli_query($conn, "UPDATE appointments SET status='Scheduled' WHERE id='$appointment_id'");

    $msg = "Appointment scheduled successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Appointments - HappyTails</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="admin.css">
<style>
/* Popup Modal CSS */
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.6);
}
.modal-content {
    background-color: #f9f9f9;
    margin: 10% auto;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
    text-align: center;
    box-shadow: 0px 0px 10px #000;
}
.modal input {
    width: 90%;
    padding: 8px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}
.modal button {
    padding: 10px 20px;
    background-color: #00aaff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.modal button:hover {
    background-color: #0077aa;
}
.close {
    float: right;
    font-size: 20px;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="admin-layout">

    <!-- Sidebar -->
    <div class="admin-sidebar">
        <h2 class="admin-title">Administrator</h2>
        <a href="admin-logout.php"><button class="admin-logout">Logout</button></a>
        <ul>
            <li class="admin-menu <?php if(basename($_SERVER['PHP_SELF'])=='admin-dashboard.php'){echo 'active';} ?>"><a href="admin-dashboard.php">Dashboard</a></li>
            <li class="admin-menu <?php if(basename($_SERVER['PHP_SELF'])=='schedule.php'){echo 'active';} ?>"><a href="schedule.php">Schedules</a></li>
            <li class="admin-menu <?php if(basename($_SERVER['PHP_SELF'])=='appointments.php'){echo 'active';} ?>"><a href="appointments.php">Appointments</a></li>
            <li class="admin-menu <?php if(basename($_SERVER['PHP_SELF'])=='users_info.php'){echo 'active';} ?>"><a href="users_info.php">User Data</a></li>
        </ul>
    </div>

    <div class="admin-main">
        <h1>Pending Appointments</h1>

        <?php if(isset($msg)){ echo "<p style='color:green;'>$msg</p>"; } ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Pet Name</th>
                    <th>Type</th>
                    <th>Age</th>
                    <th>Vaccinated</th>
                    <th>Behaviour</th>
                    <th>Service</th>
                    <th>Appointment Date</th>
                    <th>Time Slot</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
$pending = mysqli_query($conn, "SELECT * FROM appointments WHERE status='Pending'");
while($row = mysqli_fetch_assoc($pending)){
?>
<tr>
    <td><?php echo $row['pet_name']; ?></td>
    <td><?php echo $row['pet_type']; ?></td>
    <td><?php echo $row['age']; ?></td>
    <td><?php echo $row['vaccinated']; ?></td>
    <td><?php echo $row['behaviour']; ?></td>
    <td><?php echo $row['service']; ?></td>
    <td><?php echo $row['appointment_date']; ?></td>
    <td><?php echo $row['time_slot']; ?></td>
    <td>
        <button class="schedule-btn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['pet_name']; ?>">Schedule</button>
    </td>
</tr>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="scheduleModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalTitle">Schedule Appointment</h2>
        <form method="POST">
            <input type="hidden" name="appointment_id" id="modalAppointmentId">
            <input type="time" name="scheduled_time" required>
            <input type="number" name="charges" min="0" placeholder="Charges" required>
            <br>
            <button type="submit" name="schedule_modal">Save</button>
        </form>
    </div>
</div>

<script>
// JS for popup modal
const modal = document.getElementById('scheduleModal');
const closeBtn = document.querySelector('.close');
const buttons = document.querySelectorAll('.schedule-btn');
const modalAppointmentId = document.getElementById('modalAppointmentId');
const modalTitle = document.getElementById('modalTitle');

buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        modal.style.display = 'block';
        modalAppointmentId.value = btn.getAttribute('data-id');
        modalTitle.textContent = "Schedule Appointment for " + btn.getAttribute('data-name');
    });
});

closeBtn.onclick = () => {
    modal.style.display = 'none';
};

window.onclick = (e) => {
    if(e.target == modal){
        modal.style.display = 'none';
    }
};
</script>

</body>
</html>
