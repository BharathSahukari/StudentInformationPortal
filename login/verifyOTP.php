<?php
session_start();
include "../db.php";

$message = "";

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgotPassword.php");
    exit();
}

$email = $_SESSION['reset_email'];

if (isset($_POST['verify'])) {

    $enteredOtp = mysqli_real_escape_string($conn, $_POST['otp']);

    $query = mysqli_query($conn, "SELECT otp, otp_expiry FROM admins WHERE email='$email'");

    if (mysqli_num_rows($query) > 0) {

        $row = mysqli_fetch_assoc($query);

        if (date("Y-m-d H:i:s") > $row['otp_expiry']) {

            $message = "OTP has expired. Please generate a new OTP.";

        } elseif ($enteredOtp == $row['otp']) {

            $_SESSION['otp_verified'] = true;

            header("Location: resetPassword.php");
            exit();

        } else {

            $message = "Invalid OTP.";

        }

    } else {

        $message = "Something went wrong.";

    }

}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Verify OTP</title>

    <link rel="stylesheet" href="../css/loginStyle.css">
    <link rel="stylesheet" href="../css/responsiveness.css">
</head>

<body>

<div class="login-box">

    <h2>Verify OTP</h2>

    <?php
    if($message!=""){
        echo "<p style='color:red;text-align:center;'>$message</p>";
    }
    ?>

    <form method="POST">

        <input
            type="text"
            name="otp"
            placeholder="Enter 6-digit OTP"
            maxlength="6"
            required>

        <button
            type="submit"
            name="verify">
            Verify OTP
        </button>

    </form>

    <p align="center">
        <a href="forgotPassword.php">
            Generate New OTP
        </a>
    </p>
    
</div>

</body>

</html>