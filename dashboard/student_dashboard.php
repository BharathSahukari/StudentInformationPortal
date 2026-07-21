<?php
session_start();
include("../db.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../login/studentLogin.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$query = mysqli_query($conn,"SELECT * FROM students WHERE id='$student_id'");
$student = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/dashboardStyle.css">
    <link rel="stylesheet" href="../css/responsiveness.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="sidebar">

    <div class="logo">
        <h2>SMS</h2>
    </div>

    <ul>

        <li>
            <a href="student_dashboard.php" class="active">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="../profile/myProfile.php">
                <i class="fa-solid fa-user"></i> My Profile
            </a>
        </li>

        <li>
           <a href="../view/my_view.php?id=<?php echo $student['id']; ?>&from=dashboard">
    <i class="fa-solid fa-address-card"></i> View Details
</a>
        </li>

        <li>
            <a href="../logout.php" onclick="return logoutConfirm();">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </li>

    </ul>

</div>


<div class="main">

    <div class="topbar">

        <h2>Student Dashboard</h2>

        <div class="user">

            <span>Welcome, <?php echo $student['full_name']; ?></span>

        </div>

    </div>

    <div class="cards">

        <div class="card">

            <i class="fa-solid fa-user-graduate"></i>

            <h3><?php echo $student['full_name']; ?></h3>

            <p>Student Name</p>

        </div>

        <div class="card">

            <i class="fa-solid fa-building-columns"></i>

            <h3><?php echo $student['department']; ?></h3>

            <p>Department</p>

        </div>

        <div class="card">

            <i class="fa-solid fa-calendar"></i>

            <h3><?php echo $student['year']; ?></h3>

            <p>Academic Year</p>

        </div>

        <div class="card">

            <i class="fa-solid fa-envelope"></i>

            <h3><?php echo $student['email']; ?></h3>

            <p>Email</p>

        </div>

    </div>

    <div class="table-box">

        <h3>My Information</h3>

        <table>

            <tr>
                <th>Roll No</th>
                <td><?php echo $student['roll_no']; ?></td>
            </tr>

            <tr>
                <th>Name</th>
                <td><?php echo $student['full_name']; ?></td>
            </tr>

            <tr>
                <th>Department</th>
                <td><?php echo $student['department']; ?></td>
            </tr>

            <tr>
                <th>Year</th>
                <td><?php echo $student['year']; ?></td>
            </tr>

            <tr>
                <th>Gender</th>
                <td><?php echo $student['gender']; ?></td>
            </tr>

            <tr>
                <th>Phone</th>
                <td><?php echo $student['phone']; ?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?php echo $student['email']; ?></td>
            </tr>

            <tr>
                <th>Address</th>
                <td><?php echo $student['address']; ?></td>
            </tr>

        </table>

    </div>

</div>


<script src="../js/logout.js"></script>
</body>
</html>