<?php
session_start();
include("../db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login/adminLogin.php");
    exit();
}

$id = $_SESSION['admin_id'];

$query = mysqli_query($conn, "SELECT * FROM admins WHERE id='$id'");
$row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Admin Profile</title>
    <link rel="stylesheet" href="../css/viewStyle.css">
    <link rel="stylesheet" href="../css/responsiveness.css">
</head>

<body>

<h1 style="text-align:center;color:#2563eb;">Admin Profile</h1>

<div class="container">
    <div class="profile-card">

        <div class="profile-image">
            <?php
            if(!empty($row['photo']) && file_exists("../uploads/".$row['photo'])){
            ?>
                <img src="../uploads/<?php echo $row['photo']; ?>">
            <?php
            }else{
                echo strtoupper(substr($row['username'],0,1));
            }
            ?>
        </div>

        <div class="profile-details">
            <h2><?php echo $row['username']; ?></h2>

            <p><strong>ID:</strong> <?php echo $row['id']; ?></p>

            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>

            <div class="profile-buttons">
                <a href="../profile/adminProfile.php" class="back-btn">← Back</a>
            </div>
        </div>

    </div>
</div>


</body>
</html>