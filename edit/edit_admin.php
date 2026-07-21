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

if(isset($_POST['update']))
{
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    if(!empty($_FILES['photo']['name']))
    {
        $photo = time()."_".$_FILES['photo']['name'];
        $temp = $_FILES['photo']['tmp_name'];

        move_uploaded_file($temp,"../uploads/".$photo);

        mysqli_query($conn,"UPDATE admins
        SET
        username='$username',
        email='$email',
        photo='$photo'
        WHERE id='$id'");
    }
    else
    {
        mysqli_query($conn,"UPDATE admins
        SET
        username='$username',
        email='$email'
        WHERE id='$id'");
    }

    echo "<script>
        alert('Profile Updated Successfully');
        window.location='../profile/adminProfile.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Admin Profile</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="../css/responsiveness.css">
    <link rel="stylesheet" href="../css/editStyle.css">
</head>

<body>

<div class="container">

    <div class="form-box">

        <h2>Edit Profile</h2>

        <form method="POST" enctype="multipart/form-data">

            <div class="profile-preview">

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

            <div class="input-group">
                <label>Username</label>
                <input
                    type="text"
                    name="username"
                    value="<?php echo $row['username']; ?>"
                    required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="<?php echo $row['email']; ?>"
                    required>
            </div>

            <div class="input-group">
                <label>Profile Photo</label>
                <input type="file" name="photo">
            </div>

            <div class="button-group">

                <button type="submit" name="update" class="update-btn">
                    Update
                </button>

                <a href="../profile/adminProfile.php" class="cancel-btn">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>