<?php
session_start();
include("../db.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../login/studentLogin.php");
    exit();
}

$id = $_SESSION['student_id'];

$query = mysqli_query($conn, "SELECT * FROM students WHERE id='$id'");
$row = mysqli_fetch_assoc($query);

if(!$row){
    die("Student not found.");
}
?>

<?php
$from = $_GET['from'] ?? 'dashboard';

if ($from == "profile") {
    $backPage = "../profile/myProfile.php";
} else {
    $backPage = "../dashboard/student_dashboard.php";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View My Profile</title>
    <link rel="stylesheet" href="../css/viewStyle.css">
    <link rel="stylesheet" href="../css/responsiveness.css">
</head>

<body>

<div class="container">

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
                <div class="profile-avatar"><?php echo $letter; ?></div>
            <?php } ?>

        </div>

        <div class="profile-details">

            <h2><?php echo $row['full_name']; ?></h2>

            <p><strong>Roll No :</strong> <?php echo $row['roll_no']; ?></p>

            <p><strong>Department :</strong> <?php echo $row['department']; ?></p>

            <p><strong>Year :</strong> <?php echo $row['year']; ?></p>

            <p><strong>Email :</strong> <?php echo $row['email']; ?></p>

            <p><strong>Phone :</strong> <?php echo $row['phone']; ?></p>

            <p><strong>Gender :</strong> <?php echo $row['gender']; ?></p>

            <p><strong>Address :</strong> <?php echo $row['address']; ?></p>

            <div class="profile-buttons">

<a href="<?php echo $backPage; ?>" class="back-btn">
    ← Back
</a>

            </div>

        </div>

    </div>

</div>

</body>
</html>