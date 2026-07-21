<?php
session_start();
include("../db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../login/adminLogin.php");
    exit();
}

$query = mysqli_query($conn,"SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profiles</title>
    <link rel="stylesheet" href="../css/responsiveness.css">
    <link rel="stylesheet" href="../css/profileStyle.css">
</head>
<body>

<div class="container">

    <h2 class="page-title">Student Profiles</h2>

    <div class="profile-list">

    <?php
    if(mysqli_num_rows($query)>0){

        while($row=mysqli_fetch_assoc($query)){
    ?>

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

                <p><?php echo $row['email']; ?></p>

                <p>
                    <strong>Roll No :</strong>
                    <?php echo $row['roll_no']; ?>
                </p>

                <p>
                    <strong>Department :</strong>
                    <?php echo $row['department']; ?>
                </p>

                <p>
                    <strong>Year :</strong>
                    <?php echo $row['year']; ?>
                </p>

                <div class="profile-buttons">

                    <a href="../view/view_student.php?id=<?php echo $row['id']; ?>" class="view-btn">
                        View
                    </a>

                  <a href="../edit/edit_student.php?id=<?php echo $row['id']; ?>&source=studentProfiles" class="update-btn">
                        Update
                    </a>

                </div>

            </div>

        </div>

    <?php
        }
    }
    else{
        echo "<h3>No Students Found</h3>";
    }
    ?>

    </div>

    <a href="../dashboard/admin_dashboard.php" class="back-btn">
        ← Back to Dashboard
    </a>

</div>

</body>
</html>