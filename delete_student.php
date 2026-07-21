<?php
session_start();
include "db.php";

// Check if ID is provided
if(isset($_GET['id']))
{
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Get profile image before deleting
    $result = mysqli_query($conn, "SELECT profile_image FROM students WHERE id='$id'");

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);

        // Delete uploaded image
        if(!empty($row['profile_image']) && file_exists("uploads/".$row['profile_image']))
        {
            unlink("uploads/".$row['profile_image']);
        }

        // Delete student record
        $delete = mysqli_query($conn, "DELETE FROM students WHERE id='$id'");

        if($delete)
        {
            echo "<script>
                    alert('Student Deleted Successfully!');
                    window.location='view/view_student.php';
                  </script>";
        }
        else
        {
            echo "<script>
                    alert('Failed to Delete Student!');
                    window.location='view/view_student.php';
                  </script>";
        }
    }
    else
    {
        echo "<script>
                alert('Student Not Found!');
                window.location='view/view_student.php';
              </script>";
    }
}
else
{
    header("Location: view/view_student.php");
    exit();
}
?>