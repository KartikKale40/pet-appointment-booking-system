<?php
session_start();
include "Rconfig.php";

// Protect page (user must login)
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['petName'])){

    $user_id = $_SESSION['user_id'];

    $petName = trim($_POST['petName']);
    $petType = trim($_POST['petType']);
    $breed = trim($_POST['breed']);
    $color = trim($_POST['color']);
    $age = intval($_POST['age']);
    $weight = floatval($_POST['weight']);
  $gender = isset($_POST['gender']) ? trim($_POST['gender']) : "";
    $healthProblem = trim($_POST['healthProblem']);
    $vaccinated = trim($_POST['vaccinated']);
   
$vaccinationDate = (!empty($_POST['vaccinationDate'])) ? $_POST['vaccinationDate'] : NULL;



    $service = trim($_POST['service']);
    $appointmentDate = $_POST['appointmentDate'];
    $timeSlot = trim($_POST['timeSlot']);

    // Checkbox array convert to string
    $behaviour = "";
    if(isset($_POST['behaviour'])){
        $behaviour = implode(",", $_POST['behaviour']);
    }

    // File Upload Security
    $vaccinationFileName = "";

    if(isset($_FILES['vaccinationFile']) && $_FILES['vaccinationFile']['error'] == 0){

        $allowed = ['jpg','jpeg','png','pdf'];
        $fileName = $_FILES['vaccinationFile']['name'];
        $fileTmp = $_FILES['vaccinationFile']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if(in_array($fileExt, $allowed)){

            $vaccinationFileName = time()."_".$fileName;
            move_uploaded_file($fileTmp, "uploads/".$vaccinationFileName);
        }
    }

    // Prepared Statement (VERY SECURE)
    $query = "INSERT INTO appointments 
    (user_id, pet_name, pet_type, breed, color, age, weight, gender, health_problem, vaccinated, vaccination_date, vaccination_file, behaviour, service, appointment_date, time_slot) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "issssissssssssss",
        $user_id,
        $petName,
        $petType,
        $breed,
        $color,
        $age,
        $weight,
        $gender,
        $healthProblem,
        $vaccinated,
        $vaccinationDate,
        $vaccinationFileName,
        $behaviour,
        $service,
        $appointmentDate,
        $timeSlot
    );

    if(mysqli_stmt_execute($stmt)){
        echo "<script>alert('Appointment Booked Successfully');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Appointment - HappyTails</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">🐶 HappyTails Pet Care</div>

    <ul>
        <li><a href="user.php">Home</a></li>
        <li><a href="book.php">Book Appointment</a></li>
        <li><a href="user_logout.php">Logout</a></li>
    </ul>
</nav>
<section class="section active">
    <div class="card">
        <h2>Pet Appointment Registration</h2>

    <form class="appointment-form" method="POST" action="" enctype="multipart/form-data">


    <!-- Pet Basic Information -->
    <h3>1. Basic Pet Information</h3>
    <table class="form-table">
        <tr>
            <td><input type="text" id="petName" name="petName" placeholder="Pet Name" required></td>
            <td>
                <select id="petType" name="petType" required>
                    <option value="">Select Pet Type</option>
                    <option>Dog</option>
                    <option>Cat</option>
                    <option>Other</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><input type="text" name="breed" placeholder="Breed (Example: Labrador)"></td>
            <td><input type="text" name="color" placeholder="Color"></td>
        </tr>
    </table>

    <!-- Age & Health -->
    <h3>2. Age & Health Details</h3>
    <table class="form-table">
        <tr>
            <td><input type="number" name="age"  id="age" placeholder="Age (in years)"></td>
            <td><input type="number" name="weight" id="weight" placeholder="Weight (in kg)"></td>
        </tr>
        <tr>
            <td>
<select name="gender" required> 
    <option value="">Select Gender</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
</select>

            </td>
            <td><input type="text" name="healthProblem" placeholder="Any Health Problem?"></td>
        </tr>
    </table>

<!-- Vaccination -->
<h3>3. Vaccination Details</h3>

<label>
    Is your pet vaccinated?
    <select id="vaccinatedSelect" name="vaccinated">
        <option value="">Select Option</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>
</label>

<p id="vaccinationNeeded" style="color:red; display:none;">
  
</p>

<div id="vaccinationFields" style="display:none;">
    <table class="form-table">
        <tr>
            <td>
                <label>Last Vaccination Date</label>
                <input type="date" name="vaccinationDate" id="vaccinationDate">
            </td>
            <td>
                <label>Upload Vaccination Proof</label>
                <input type="file"  name="vaccinationFile" id="vaccinationFile">
            </td>
        </tr>
    </table>
</div>

    <!-- Behaviour -->
    <h3>4. Pet Behaviour</h3>
<div class="checkbox-group">
    <label><input type="checkbox" name="behaviour[]" value="Friendly"> Friendly</label>
    <label><input type="checkbox" name="behaviour[]" value="Shy"> Shy</label>
    <label><input type="checkbox" name="behaviour[]" value="Aggressive"> Aggressive</label>
    <label><input type="checkbox" name="behaviour[]" value="Calm"> Calm</label>
</div>


    <!-- Service Selection -->
    <h3>5. Select Service</h3>
    <select class="full-width" id="service" name="service"   required>
        <option value="">Choose Service</option>
        <option>Check-up</option>
        <option>Vaccination</option>
        <option>Grooming</option>
        <option>Dental Cleaning</option>
        <option>Emergency Visit</option>
    </select>

    <!-- Appointment Date -->
    <h3>6. Appointment Date & Time</h3>
    <table class="form-table">
        <tr>
            <td><input type="date"  name="appointmentDate" id="appointmentDate"required></td>
            <td>
                <select id="timeSlot" name="timeSlot"  required>
                    <option value="">Select Time</option>
                    <option>Morning</option>
                    <option>Afternoon</option>
                </select>
            </td>
        </tr>
    </table>

    <!-- Submit Button -->
    <button type="submit" class="submit-btn">
        Book Appointment
    </button>

</form>

    </div>
</section>

<script src="script.js"></script>
</body>
</html>
