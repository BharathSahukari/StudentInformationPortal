<?php
session_start();
include("../db.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../login/studentLogin.php");
    exit();
}

$id = $_SESSION['student_id'];

$query = mysqli_query($conn,"SELECT * FROM students WHERE id='$id'");
$row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>

    <link rel="stylesheet" href="../css/myProfileStyle.css">
    <link rel="stylesheet" href="../css/responsiveness.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<div class="container">

    <h2 class="page-title">My Profile</h2>

    <div class="profile-card">

        <div class="profile-image">

        <?php
        if(!empty($row['profile_image']) && file_exists("../uploads/".$row['profile_image'])){
        ?>

            <img src="../uploads/<?php echo $row['profile_image']; ?>" class="profile-img">

        <?php
        }else{
            $letter = strtoupper(substr($row['full_name'],0,1));
        ?>

            <div class="profile-avatar">
                <?php echo $letter; ?>
            </div>

        <?php
        }
        ?>

        </div>

        <div class="profile-details">

            <h3><?php echo $row['full_name']; ?></h3>

            <p class="email"><?php echo $row['email']; ?></p>

<div class="info">

    <div class="info-box">
        <h4>Roll Number</h4>
        <p><?php echo $row['roll_no']; ?></p>
    </div>

    <div class="info-box">
        <h4>Department</h4>
        <p><?php echo $row['department']; ?></p>
    </div>

    <div class="info-box">
        <h4>Year</h4>
        <p><?php echo $row['year']; ?></p>
    </div>

</div>
            <div class="profile-buttons">
<a href="../view/myview.php?id=<?php echo $row['id']; ?>&from=profile" class="view-btn">
    View
</a>

                <a href="../edit/edit_student.php?source=myProfile" class="update-btn">
                    Update
                </a>

            </div>

            <div class="profile-buttons" style="margin-top:15px;">

                <a href="../dashboard/student_dashboard.php" class="back-btn">
                    Back
                </a>

                <a href="../logout.php" class="logout-btn">
                    Logout
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>