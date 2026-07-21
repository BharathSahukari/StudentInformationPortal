<?php
session_start();
include "../db.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$message="";

if(isset($_POST['send'])){

$email=mysqli_real_escape_string($conn,$_POST['email']);

$query=mysqli_query($conn,"SELECT * FROM admins WHERE email='$email'");

if(mysqli_num_rows($query)>0){

$otp = rand(100000,999999);

$expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

mysqli_query($conn,
    "UPDATE admins
     SET otp='$otp',
         otp_expiry='$expiry'
     WHERE email='$email'");

$_SESSION['reset_email'] = $email;

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'bharathsahukari05@gmail.com';


    $mail->Password = 'sjrdkejoaypfqwnm';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('bharathsahukari05@gmail.com', 'Student Management System');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset OTP';

    $mail->Body = "
        <h2>Password Reset Request</h2>
        <p>Your OTP is:</p>
        <h1>$otp</h1>
        <p>This OTP is valid for 5 minutes.</p>
    ";

    $mail->send();

    header("Location: verifyOTP.php");
    exit();

} catch (Exception $e) {

    $message = "Unable to send email.<br>" . $mail->ErrorInfo;

}

}
else{

$message="Email not found.";

}

}
?>

<!DOCTYPE html>

<html>

<head>

<title>Forgot Password</title>

<link rel="stylesheet" href="../css/loginStyle.css">
<link rel="stylesheet" href="../css/responsiveness.css">

</head>

<body>

<div class="login-box">

<h2>Forgot Password</h2>

<?php

if($message!=""){

echo "<p style='color:red;text-align:center;'>$message</p>";

}

?>

<form method="POST">

<input
type="email"
name="email"
placeholder="Enter Registered Email"
required>

<button
type="submit"
name="send">

Generate OTP

</button>

</form>

<p align="center">

<a href="adminLogin.php">

Back to Login

</a>

</p>

</div>

</body>

</html>
