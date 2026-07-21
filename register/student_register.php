<?php
include("../db.php");

$msg = "";

if (isset($_POST['register'])) {

    $roll_no = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);

    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    // Upload Profile Image
    $profile_image = "";

    if (!empty($_FILES['profile_image']['name'])) {

        $profile_image = $_FILES['profile_image']['name'];
        $tmp = $_FILES['profile_image']['tmp_name'];

        move_uploaded_file($tmp, "../uploads/" . $profile_image);
    }

    $check = mysqli_query($conn, "SELECT * FROM students WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {

        $msg = "Email already exists!";

    } else {

        $sql = "INSERT INTO students
        (roll_no, full_name, email, password, phone, gender, department, year, profile_image,address)
        VALUES
        ('$roll_no','$full_name','$email','$password','$phone','$gender','$department','$year','$profile_image','$address')";

        if (mysqli_query($conn, $sql)) {

            echo "<script>
            alert('Student Registered Successfully');
            window.location='../login/studentLogin.php';
            </script>";

        } else {

            $msg = "Registration Failed!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Register</title>
<link rel="stylesheet" href="../css/registerStyle.css">
<link rel="stylesheet" href="../css/responsiveness.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="register-box">

<h2>Student Registration</h2>

<p class="error"><?php echo $msg; ?></p>

<form method="POST" enctype="multipart/form-data">

<label>Roll Number</label>
<input type="text" name="roll_no" required>

<label>Full Name</label>
<input type="text" name="full_name" required>

<label>Gender</label>
<select name="gender" required>
    <option value="">Select Gender</option>
    <option>Male</option>
    <option>Female</option>
    <option>Other</option>
</select>

<label>Phone</label>
<input type="text" name="phone" required>

<label>Email</label>
<input type="email" name="email" required>

<label>Department</label>
<select name="department" required>
    <option value="">Select Department</option>
    <option>CSE</option>
    <option>IT</option>
    <option>ECE</option>
    <option>EEE</option>
    <option>CIVIL</option>
    <option>MECH</option>
    <option>MET</option>
</select>

<label>Year</label>
<select name="year" required>
    <option value="">Select Year</option>
    <option value="1">1st Year</option>
    <option value="2">2nd Year</option>
    <option value="3">3rd Year</option>
    <option value="4">4th Year</option>
</select>

<label>Profile Image</label>
<input type="file" name="profile_image">

<label>Address</label>
<input type="textarea" name="address" required>

<label>Password</label>
<div class="input-group password-group">
    <input type="password" id="registerPassword" name="password" placeholder="Password" required>

    <span class="toggle-password" onclick="togglePassword('registerPassword', this)">
        <i class="fa-solid fa-eye-slash"></i>
    </span>
</div>

<label>Confirm Password</label>
<div class="input-group password-group">
    <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required>

    <span class="toggle-password" onclick="togglePassword('confirmPassword', this)">
        <i class="fa-solid fa-eye-slash"></i>
    </span>
</div>

<input type="submit" name="register" value="Register">

</form>

<p>
Already have an account?
<a href="../login/studentLogin.php">Login</a>
</p>

<p align="center">
<a href="admin_register.php">Admin Registeration</a>
</p>

</div>

<script src="../js/register.js"></script>

</body>
</html>