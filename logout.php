<?php
session_start();

$isAdmin = isset($_SESSION['admin_id']);
$isStudent = isset($_SESSION['student_id']);

session_unset();
session_destroy();

if ($isAdmin) {
    header("Location: login/adminLogin.php");
} elseif ($isStudent) {
    header("Location: login/studentLogin.php");
} else {
    header("Location: login/adminLogin.php");
}

exit();
?>