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
<title>Scheduled Appointments - HappyTails</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="admin.css">
<style>
/* Table container scroll */
.table-container {
    overflow-x: auto;
    margin-top: 20px;
}

/* View Button */
.view-btn {
    padding: 5px 10px;
    background-color: #00aaff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.view-btn:hover {
    background-color: #0077aa;
}

/* Modal styles */
.modal {
    display: none; 
    position: fixed; 
    z-index: 1000; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.6); 
}

.modal-content {
    background-color: #fff;
    margin: 50px auto;
    padding: 20px;
    border-radius: 5px;
    width: 90%;
    max-width: 700px;
    position: relative;
}

.modal-content h2 {
    margin-top: 0;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: black;
}

.modal-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.modal-table td, .modal-table th {
    padding: 8px 10px;
    border: 1px solid #ddd;
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

    <!-- Main Content -->
    <div class="admin-main">
        <h1>Scheduled Appointments</h1>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Owner Name</th>
                        <th>Phone</th>
                        <th>Service</th>
                        <th>Time Slot</th>
                        <th>Charges</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
<?php
$query = "
SELECT sa.*, u.full_name AS owner_name, u.phone AS owner_phone, 
       a.pet_name, a.pet_type, a.breed, a.color, a.age, a.weight, a.gender, a.health_problem, a.vaccinated, a.vaccination_date, a.vaccination_file, a.behaviour, a.service, a.time_slot, a.charges
FROM scheduled_appointments sa
JOIN appointments a ON sa.appointment_id = a.id
JOIN users u ON a.user_id = u.id
ORDER BY sa.appointment_date DESC, sa.scheduled_time ASC
";


$scheduled = mysqli_query($conn, $query);

if(mysqli_num_rows($scheduled) > 0){
    $sr = 1;
    while($row = mysqli_fetch_assoc($scheduled)){
        echo "<tr>";
        echo "<td>".$sr++."</td>";
        echo "<td>".$row['owner_name']."</td>";
        echo "<td>".$row['owner_phone']."</td>";
        echo "<td>".$row['service']."</td>";
        echo "<td>".$row['time_slot']."</td>";
        echo "<td>₹".$row['charges']."</td>";
        echo "<td><button class='view-btn' onclick='openModal(".json_encode($row).")'>View</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No scheduled appointments found.</td></tr>";
}
?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="appointmentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Appointment Details</h2>
        <table class="modal-table">
            <tbody id="modalBody">
                <!-- Content populated dynamically -->
            </tbody>
        </table>
    </div>
</div>

<script>
function openModal(data){
    let modal = document.getElementById('appointmentModal');
    let tbody = document.getElementById('modalBody');
    tbody.innerHTML = "";

    for(let key in data){
        if(key === 'id' || key === 'user_id' || key === 'appointment_id') continue; // skip IDs
        let tr = document.createElement('tr');
        let tdKey = document.createElement('td');
        tdKey.textContent = key.replace(/_/g, ' ').toUpperCase();
        let tdValue = document.createElement('td');
        tdValue.textContent = data[key] ? data[key] : "-";
        tr.appendChild(tdKey);
        tr.appendChild(tdValue);
        tbody.appendChild(tr);
    }

    modal.style.display = "block";
}

function closeModal(){
    document.getElementById('appointmentModal').style.display = "none";
}

// Close modal if click outside
window.onclick = function(event) {
    let modal = document.getElementById('appointmentModal');
    if(event.target == modal){
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
