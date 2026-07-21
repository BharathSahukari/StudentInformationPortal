<?php
session_start();
include "../db.php";

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Get admin by username only
    $query = mysqli_query($conn, "SELECT * FROM admins WHERE username='$username'");

    if(mysqli_num_rows($query) > 0){

        $admin = mysqli_fetch_assoc($query);

        // Verify the hashed password
        if(password_verify($password, $admin['password'])){

                // Remove any existing student session
            unset($_SESSION['student_id']);
            unset($_SESSION['student_name']);

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];

            header("Location: ../dashboard/admin_dashboard.php");
            exit();

        } else {
            $error = "Invalid Username or Password";
        }

    } else {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="../css/loginStyle.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="login-box">

<h2>Admin Login</h2>

<?php
if(isset($error))
echo "<p style='color:red;text-align:center;'>$error</p>";
?>

<form method="POST" onsubmit="return validateLogin()">

<input type="text" name="username" placeholder="Username" required>

<div class="input-group password-group">
    <input type="password" id="loginPassword" name="password" placeholder="Password" required>

    <span class="toggle-password" onclick="togglePassword('loginPassword', this)">
        <i class="fa-solid fa-eye-slash"></i>
    </span>
</div>

<p class="forgot-link">
    <a href="forgotPassword.php">Forgot Password?</a>
</p>
<button type="submit" name="login">Login</button>

</form>

<p align="center">
<a href="studentLogin.php">Student Login</a>
</p>

</div>
<script src="../js/login.js"></script>
</body>
</html>