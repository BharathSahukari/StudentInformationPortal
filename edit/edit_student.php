<?php
session_start();
include "../db.php";

// Check login
if(isset($_SESSION['admin_id']))
{
    $user = "admin";
}
elseif(isset($_SESSION['student_id']))
{
    $user = "student";
}
else
{
    header("Location: ../login/studentLogin.php");
    exit();
}

$source = isset($_GET['source']) ? $_GET['source'] : '';

if(isset($_POST['source']))
{
    $source = $_POST['source'];
}

// Get student id
if($user == "admin")
{
    if(!isset($_GET['id']))
    {
        header("Location: ../dashboard/admin_dashboard.php");
        exit();
    }

    $id = $_GET['id'];
}
else
{
    // Student can edit only his/her own profile
    $id = $_SESSION['student_id'];
}

// Fetch student details
$result = mysqli_query($conn,"SELECT * FROM students WHERE id='$id'");

if(mysqli_num_rows($result)==0)
{
    echo "<script>alert('Student not found');</script>";
    exit();
}

$row = mysqli_fetch_assoc($result);


// Update student
if (isset($_POST['update_student'])) {
$full_name = mysqli_real_escape_string($conn,$_POST['full_name']);
$roll_no = mysqli_real_escape_string($conn,$_POST['roll_no']);
$department = mysqli_real_escape_string($conn,$_POST['department']);
$year = mysqli_real_escape_string($conn,$_POST['year']);
$email = mysqli_real_escape_string($conn,$_POST['email']);
$phone = mysqli_real_escape_string($conn,$_POST['phone']);
$gender = mysqli_real_escape_string($conn,$_POST['gender']);
$address = mysqli_real_escape_string($conn,$_POST['address']);

$photo = $row['profile_image'];

    // Check if new image uploaded
    if ($_FILES['photo']['name'] != "") {

        if (file_exists("../uploads/" . $photo)) {
            unlink("../uploads/" . $photo);
        }

        $photo = $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];

        move_uploaded_file($tmp, "../uploads/" . $photo);
    }

    $update = mysqli_query($conn, "UPDATE students SET

        full_name='$full_name',
        roll_no='$roll_no',
        department='$department',
        year='$year',
        email='$email',
        phone='$phone',
        gender='$gender',
        address='$address',
        profile_image='$photo'

        WHERE id='$id'
    ");

   if($update)
{
    echo "<script>alert('Student Updated Successfully');</script>";

    if($source=="admin_dashboard")
    {
        echo "<script>window.location='../dashboard/admin_dashboard.php';</script>";
    }
    elseif($source=="view_student")
    {
        echo "<script>window.location='../view/view_student.php';</script>";
    }
    elseif($source=="studentProfile")
    {
        echo "<script>window.location='../profile/studentProfile.php';</script>";
    }
    elseif($source=="myProfile")
    {
        echo "<script>window.location='../profile/myProfile.php';</script>";
    }
    else
    {
        if($user=="admin")
        {
            echo "<script>window.location='../view/view_student.php';</script>";
        }
        else
        {
            echo "<script>window.location='../profile/myProfile.php';</script>";
        }
    }

    exit();
}
else
{
    echo "<script>alert('Update Failed');</script>";
}
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Student</title>

    <link rel="stylesheet" href="../css/studentEditStyle.css">

</head>

<body>

<div class="container">

<div class="form-box">

<h2>Edit Student</h2>

<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="source" value="<?php echo $source; ?>">

<label>Name</label>
<input type="text" name="full_name" value="<?php echo $row['full_name']; ?>" required>

<label>Roll Number</label>
<input type="text" name="roll_no" value="<?php echo $row['roll_no']; ?>" required>

<label>Department</label>

<select name="department">

<option <?php if($row['department']=="CSE") echo "selected"; ?>>CSE</option>
<option <?php if($row['department']=="ECE") echo "selected"; ?>>ECE</option>
<option <?php if($row['department']=="EEE") echo "selected"; ?>>EEE</option>
<option <?php if($row['department']=="MECH") echo "selected"; ?>>MECH</option>
<option <?php if($row['department']=="CIVIL") echo "selected"; ?>>CIVIL</option>
<option <?php if($row['department']=="AIML") echo "selected"; ?>>AIML</option>

</select>

<label>Year</label>

<select name="year">

<option <?php if($row['year']=="1st Year") echo "selected"; ?>>1st Year</option>
<option <?php if($row['year']=="2nd Year") echo "selected"; ?>>2nd Year</option>
<option <?php if($row['year']=="3rd Year") echo "selected"; ?>>3rd Year</option>
<option <?php if($row['year']=="4th Year") echo "selected"; ?>>4th Year</option>

</select>

<label>Email</label>
<input type="email" name="email" value="<?php echo $row['email']; ?>">

<label>Phone</label>
<input type="text" name="phone" value="<?php echo $row['phone']; ?>">

<label>Gender</label>
<select name="gender">

<option <?php if($row['gender']=="Male") echo "selected"; ?>>Male</option>
<option <?php if($row['gender']=="Female") echo "selected"; ?>>Female</option>
<option <?php if($row['gender']=="Other") echo "selected"; ?>>Other</option>

</select>

<label>Address</label>
<textarea name="address"><?php echo $row['address']; ?></textarea>

<label>Current Photo</label><br>

<?php
if(!empty($row['profile_image'])){
    echo "<img src='../uploads/".$row['profile_image']."' width='120' style='border-radius:10px;'><br><br>";
}
?>

<label>Change Photo</label>
<input type="file" name="photo">

<div class="button-group">

<?php
if($user == "student"){
?>
    <a href="../profile/myProfile.php" class="back-btn">← Back</a>
<?php
}else{
?>
    <a href="../view/view_student.php" class="back-btn">← Back</a>
<?php
}
?>

<button type="submit" name="update_student" class="add-btn">
    Update Student
</button>

</div>

</form>

</div>

</div>

</body>
</html>