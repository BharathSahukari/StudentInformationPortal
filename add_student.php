<?php
session_start();
include "db.php";

if(isset($_POST['add_student']))
{
    $full_name  = mysqli_real_escape_string($conn,$_POST['full_name']);
    $roll_no    = mysqli_real_escape_string($conn,$_POST['roll_no']);
    $department = mysqli_real_escape_string($conn,$_POST['department']);
    $year       = mysqli_real_escape_string($conn,$_POST['year']);
    $email      = mysqli_real_escape_string($conn,$_POST['email']);
    $phone      = mysqli_real_escape_string($conn,$_POST['phone']);
    $gender     = mysqli_real_escape_string($conn,$_POST['gender']);

    // Default password
    $password = password_hash("123456", PASSWORD_DEFAULT);

    // Upload image
    $photo = "";

    if(isset($_FILES['photo']) && $_FILES['photo']['name']!="")
    {
        $photo = $_FILES['photo']['name'];
        $temp = $_FILES['photo']['tmp_name'];
        move_uploaded_file($temp,"uploads/".$photo);
    }

    $query = "INSERT INTO students
    (
        roll_no,
        full_name,
        email,
        password,
        phone,
        gender,
        department,
        year,
        profile_image
    )
    VALUES
    (
        '$roll_no',
        '$full_name',
        '$email',
        '$password',
        '$phone',
        '$gender',
        '$department',
        '$year',
        '$photo'
    )";

    if(mysqli_query($conn,$query))
    {
        echo "<script>
        alert('Student Added Successfully');
        window.location='view/view_student.php';
        </script>";
    }
    else
    {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Student</title>

<link rel="stylesheet" href="css/addStyle.css">
<link rel="stylesheet" href="css/responsiveness.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="form-box">

<h2>Add Student</h2>
<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="input-box">
<label>Name</label>
<input type="text" name="full_name" required>
</div>

<div class="input-box">
<label>Roll Number</label>
<input type="text" name="roll_no" required>
</div>

</div>

<div class="row">

<div class="input-box">
<label>Department</label>
<select name="department">
<option>CSE</option>
<option>IT</option>
<option>ECE</option>
<option>EEE</option>
<option>AIML</option>
<option>CIVIL</option>
<option>MET</option>
<option>MECH</option>
</select>
</div>

<div class="input-box">
<label>Year</label>
<select name="year">
<option>1st Year</option>
<option>2nd Year</option>
<option>3rd Year</option>
<option>4th Year</option>
</select>
</div>

</div>

<div class="row">

<div class="input-box">
<label>Email</label>
<input type="email" name="email">
</div>

<div class="input-box">
<label>Phone</label>
<input type="text" name="phone">
</div>

</div>

<div class="row">

<div class="input-box">
<label>Gender</label>
<select name="gender">
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>
</div>


<div class="input-box">
<label>Address</label>
<textarea name="address" rows="4"></textarea>
</div>

</div>

<div class="input-box">
<label>Photo</label>
<input type="file" name="photo">
</div>

<div class="button-group">
    <a href="dashboard/admin_dashboard.php" class="back-btn">← Back</a>

    <button type="submit" name="add_student" class="add-btn">
        Add Student
    </button>
</div>


</form>

</div>

</div>

</body>
</html>