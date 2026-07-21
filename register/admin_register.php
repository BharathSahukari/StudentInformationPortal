<?php
include("../db.php");

$msg="";

if(isset($_POST['register']))
{
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);

    $check=mysqli_query($conn,"SELECT * FROM admins WHERE email='$email'");

    if(mysqli_num_rows($check)>0)
    {
        $msg="Email already exists!";
    }
    else
    {
        $sql="INSERT INTO admins(username,email,password)
              VALUES('$username','$email','$password')";

        if(mysqli_query($conn,$sql))
        {
            echo "<script>
            alert('Admin Registered Successfully');
            window.location='../login/adminLogin.php';
            </script>";
        }
        else
        {
            $msg="Registration Failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Register</title>
<link rel="stylesheet" href="../css/registerStyle.css">
<link rel="stylesheet" href="../css/responsiveness.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="register-box">

<h2>Admin Registration</h2>

<p class="error"><?php echo $msg; ?></p>

<form method="POST" onsubmit="return validateRegister()">

<label>Username</label>
<input type="text" id="username" name="username" required>


<label>Email</label>
<input type="email" id="email" name="email" required>

<label>Password</label>
<div class="input-group password-group">
    <input
        type="password"
        id="registerPassword"
        name="password"
        placeholder="Password"
        required>

    <span class="toggle-password" onclick="togglePassword('registerPassword', this)">
        <i class="fa-solid fa-eye-slash"></i>
    </span>
</div>

<label>Confirm Password</label>
<div class="input-group password-group">
    <input
        type="password"
        id="confirmPassword"
        name="confirm_password"
        placeholder="Confirm Password"
        required>

    <span class="toggle-password" onclick="togglePassword('confirmPassword', this)">
        <i class="fa-solid fa-eye-slash"></i>
    </span>
</div>


<input type="submit" name="register" value="Register">

</form>

<p>
Already have an account?
<a href="../login/adminLogin.php">Login</a>
</p>

<p align="center">
<a href="student_register.php">Student Registeration</a>
</p>

</div>

<script src="../js/register.js"></script>
</body>
</html>