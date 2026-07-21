<?php
session_start();
include "../db.php";

if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] != true) {
    header("Location: forgotPassword.php");
    exit();
}

$message = "";

if (isset($_POST['reset'])) {

    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword != $confirmPassword) {

        $message = "Passwords do not match.";

    } else {

        $email = $_SESSION['reset_email'];

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $update = mysqli_query($conn,
            "UPDATE admins
             SET password='$hashedPassword',
                 otp=NULL,
                 otp_expiry=NULL
             WHERE email='$email'");

        if ($update) {

            // Clear session variables
            unset($_SESSION['otp_verified']);
            unset($_SESSION['reset_email']);

            echo "<script>
                    alert('Password changed successfully!');
                    window.location='adminLogin.php';
                  </script>";
            exit();

        } else {

            $message = "Unable to update password.";

        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Reset Password</title>

<link rel="stylesheet" href="../css/loginStyle.css">
<link rel="stylesheet" href="../css/responsiveness.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="login-box">

<h2>Create New Password</h2>

<?php
if($message!=""){
    echo "<p style='color:red;text-align:center;'>$message</p>";
}
?>

<form method="POST">

 <label>New Password</label>

    <div class="password-group">
        <input
            type="password"
            id="newPassword"
            name="new_password"
            placeholder="Enter New Password"
            required>

        <span class="toggle-password"
              onclick="togglePassword('newPassword', this)">
            <i class="fa-solid fa-eye-slash"></i>
        </span>
    </div>

    <label>Confirm Password</label>

    <div class="password-group">
        <input
            type="password"
            id="confirmPassword"
            name="confirm_password"
            placeholder="Confirm Password"
            required>

        <span class="toggle-password"
              onclick="togglePassword('confirmPassword', this)">
            <i class="fa-solid fa-eye-slash"></i>
        </span>
    </div>

<button
type="submit"
name="reset">

Update Password

</button>

</form>

</div>

<script src="../js/login.js"></script>
</body>
</html>