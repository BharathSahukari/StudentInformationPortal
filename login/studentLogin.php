<?php
session_start();
include("../db.php");

if(isset($_POST['login'])){

    $roll_no = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM students WHERE roll_no='$roll_no'");

    if(mysqli_num_rows($query) > 0){

        $student = mysqli_fetch_assoc($query);

        if(password_verify($password, $student['password'])){

            // Remove any existing admin session
            unset($_SESSION['admin_id']);
            unset($_SESSION['admin_name']);

            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['full_name'];

            header("Location: ../dashboard/student_dashboard.php");
            exit();

        }else{
            $error = "Invalid Roll Number or Password";
        }

    }else{
        $error = "Invalid Roll Number or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Student Login</title>

<link rel="stylesheet" href="../css/loginStyle.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="login-box">

<h2>Student Login</h2>

<?php
if(isset($error))
echo "<p style='color:red;text-align:center;'>$error</p>";
?>

<form method="POST" onsubmit="return validateLogin()">

<input type="text" name="roll_no" placeholder="Roll Number" required>

<div class="input-group password-group">
    <input type="password" id="loginPassword" name="password" placeholder="Password" required>

    <span class="toggle-password" onclick="togglePassword('loginPassword', this)">
        <i class="fa-solid fa-eye-slash"></i>
    </span>
</div>

<p style="text-align:right;">
    <a href="forgotPassword.php">Forgot Password?</a>
</p>

<button type="submit" name="login">Login</button>

</form>

<p align="center">
     <a href="adminLogin.php">Admin Login</a>
</p>

</div>

<script src="../js/login.js"></script>

</body>
</html>