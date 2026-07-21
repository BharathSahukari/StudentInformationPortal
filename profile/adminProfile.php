<?php
session_start();
include("../db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../login/adminLogin.php");
    exit();
}

$id = $_SESSION['admin_id'];

$query = mysqli_query($conn,"SELECT * FROM admins WHERE id='$id'");
$row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile</title>
    <link rel="stylesheet" href="../css/profileStyle.css">
    <link rel="stylesheet" href="../css/responsiveness.css">
</head>

<body>

<div class="container">

    <h2 class="page-title">My Profile</h2>

    <div class="profile-card">

        <div class="profile-image">
            <?php
            if(!empty($row['photo']) && file_exists("../uploads/".$row['photo'])){
            ?>
                <img src="../uploads/<?php echo $row['photo']; ?>" class="profile-img">
            <?php
            }else{
                $letter = strtoupper(substr($row['username'],0,1));
            ?>
                <div class="profile-avatar"><?php echo $letter; ?></div>
            <?php
            }
            ?>
        </div>

        <div class="profile-details">
            <h3><?php echo $row['username']; ?></h3>
            <p><?php echo $row['email']; ?></p>

            <div class="profile-buttons">
                <a href="../view/view_admin.php" class="view-btn">View</a>
                <a href="../edit/edit_admin.php" class="update-btn">Update</a>
            </div>
        </div>

    </div>

    <a href="../dashboard/admin_dashboard.php" class="back-btn">
        ← Back to Dashboard
    </a>

</div>


</body>
</html>