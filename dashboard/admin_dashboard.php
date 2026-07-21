<?php
session_start();
include "../db.php";

// Students by Department
$deptData = mysqli_query($conn, "
    SELECT department, COUNT(*) AS total
    FROM students
    GROUP BY department
");

$departments = [];
$departmentCounts = [];

while($row = mysqli_fetch_assoc($deptData)){
    $departments[] = $row['department'];
    $departmentCounts[] = $row['total'];
}

// Students by Year
$yearData = mysqli_query($conn, "
    SELECT year, COUNT(*) AS total
    FROM students
    GROUP BY year
");

$years = [];
$yearCounts = [];

while($row = mysqli_fetch_assoc($yearData)){
    $years[] = "Year ".$row['year'];
    $yearCounts[] = $row['total'];
}

// Uncomment if you have login sessions
if(!isset($_SESSION['admin_id'])){
    header("Location: ../login/adminLogin.php");
    exit();
}

// Statistics
$totalStudents = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM students"));
$totalDepartments = mysqli_num_rows(mysqli_query($conn,"SELECT DISTINCT department FROM students"));
$totalYears = mysqli_num_rows(mysqli_query($conn,"SELECT DISTINCT year FROM students"));
$totalMale = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE gender='Male'"));

$totalFemale = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE gender='Female'"));

$totalImages = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE profile_image!=''"));

$totalToday = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE DATE(created_at)=CURDATE()"));


$search = isset($_GET['search']) ? mysqli_real_escape_string($conn,$_GET['search']) : "";
$department = isset($_GET['department']) ? mysqli_real_escape_string($conn,$_GET['department']) : "";
$year = isset($_GET['year']) ? (int)$_GET['year'] : 0;

$sql = "SELECT * FROM students WHERE 1=1";

if($search != "")
{
    $sql .= " AND (
        full_name LIKE '%$search%'
        OR roll_no LIKE '%$search%'
        OR email LIKE '%$search%'
        OR phone LIKE '%$search%'
    )";
}

if($department != "")
{
    $sql .= " AND department='$department'";
}

if($year > 0)
{
    $sql .= " AND year=$year";
}

// Pagination
$limit = 5; // Number of students per page

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page < 1){
    $page = 1;
}

$offset = ($page - 1) * $limit;

// Count total filtered records
$count_sql = str_replace("SELECT *", "SELECT COUNT(*) AS total", $sql);
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];

$total_pages = ceil($total_records / $limit);

// Add pagination to the query
$sql .= " ORDER BY id DESC LIMIT $offset, $limit";

$students = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../css/dashboardStyle.css">
<link rel="stylesheet" href="../css/responsiveness.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<div class="sidebar">

<h2>StudentMS</h2>

<ul>

<li class="active">
<a href="../dashboard/admin_dashboard.php">
<i class="fa fa-home"></i> Dashboard
</a>
</li>

<li>
<a href="../add_student.php">
<i class="fa fa-user-plus"></i> Add Student
</a>
</li>

<li>
<a href="../view/view_student.php">
<i class="fa fa-users"></i> View Students
</a>
</li>

<li>
<a href="../profile/adminProfile.php">
<i class="fa fa-user"></i> Admin Profile
</a>
</li>

<li>
    <a href="../profile/studentProfile.php">
        <i class="fa fa-user-graduate"></i> Student Profiles
    </a>
</li>

<li>
<a href="../logout.php" onclick="return logoutConfirm();">
<i class="fa fa-sign-out-alt"></i> Logout
</a>
</li>

</ul>

</div>

<div class="main">

<div class="topbar">

    <h2>Dashboard</h2>

   <form method="GET" class="search-form">

    <div class="search-box">
        <input type="text"
               name="search"
               placeholder="Search Student..."
               value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

        <button type="submit">
            <i class="fa fa-search"></i>
        </button>
    </div>

    <select name="department">
        <option value="">All Departments</option>
        <option value="CSE">CSE</option>
        <option value="ECE">ECE</option>
        <option value="EEE">EEE</option>
        <option value="MECH">MECH</option>
        <option value="CIVIL">CIVIL</option>
        <option value="IT">IT</option>
    </select>

    <select name="year">
        <option value="">All Years</option>
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>
        <option value="4">4th Year</option>
    </select>

    <button type="submit" class="filter-btn">
        Filter
    </button>

</form>

</div>

<div class="cards">

<div class="card">

<i class="fa fa-users"></i>

<h3><?php echo $totalStudents; ?></h3>

<p>Total Students</p>

</div>

<div class="card">

<i class="fa fa-building"></i>

<h3><?php echo $totalDepartments; ?></h3>

<p>Departments</p>

</div>

<div class="card">

<i class="fa fa-graduation-cap"></i>

<h3><?php echo $totalYears; ?></h3>

<p>Academic Years</p>

</div>

<div class="card">
    <i class="fa fa-mars"></i>
    <h3><?php echo $totalMale; ?></h3>
    <p>Male Students</p>
</div>

<div class="card">
    <i class="fa fa-venus"></i>
    <h3><?php echo $totalFemale; ?></h3>
    <p>Female Students</p>
</div>

<div class="card">
    <i class="fa fa-image"></i>
    <h3><?php echo $totalImages; ?></h3>
    <p>Profile Images</p>
</div>

<div class="card">
    <i class="fa fa-calendar-day"></i>
    <h3><?php echo $totalToday; ?></h3>
    <p>Today's Registrations</p>
</div>

<div class="card">

<i class="fa fa-user-shield"></i>

<h3>Admin</h3>

<p>Logged In</p>

</div>
</div> 

<div class="chart-container">

    <div class="chart-box">
        <h3>Students by Department</h3>
        <canvas id="departmentChart"></canvas>
    </div>

    <div class="chart-box">
        <h3>Students by Academic Year</h3>
        <canvas id="yearChart"></canvas>
    </div>

</div>

<div class="table-box">

    <div class="table-title">
        <h3>Recent Students</h3>

        <a href="../add_student.php" class="btn">
    <i class="fa-solid fa-user-plus"></i> Add Student
</a>
    </div>

    <table>

        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Roll No</th>
            <th>Department</th>
            <th>Year</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>

<?php

if(mysqli_num_rows($students) > 0){

    while($row = mysqli_fetch_assoc($students)){
?>

<tr>

    <td><?php echo $row['id']; ?></td>

    <td>

        <?php
        if(!empty($row['profile_image'])){
        ?>
            <img src="../uploads/<?php echo $row['profile_image']; ?>"
                 width="60"
                 height="60"
                 style="border-radius:50%; object-fit:cover;">
        <?php
        }else{
        ?>
            No Image
        <?php
        }
        ?>

    </td>

    <td><?php echo $row['full_name']; ?></td>

    <td><?php echo $row['roll_no']; ?></td>

    <td><?php echo $row['department']; ?></td>

    <td><?php echo $row['year']; ?></td>

    <td><?php echo $row['email']; ?></td>

    <td><?php echo $row['phone']; ?></td>

    <td><?php echo $row['gender']; ?></td>

   <td>
    <div class="action-buttons">
       <a href="../edit/edit_student.php?id=<?php echo $row['id']; ?>&source=admin_dashboard" class="edit">
            Edit
        </a>

        <a href="../delete_student.php?id=<?php echo $row['id']; ?>"
           class="delete"
           onclick="return confirm('Delete Student?')">
            Delete
        </a>
    </div>
</td>
</tr>

<?php
    }
}else{
?>

<tr>
    <td colspan="10" style="text-align:center;">
        No Students Found
    </td>
</tr>

<?php
}
?>

    </table>
<div class="pagination">
<?php
for($i = 1; $i <= $total_pages; $i++){
?>
    <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&department=<?php echo urlencode($department); ?>&year=<?php echo $year; ?>"
       class="<?php echo ($page == $i) ? 'active' : ''; ?>">
       <?php echo $i; ?>
    </a>
<?php
}
?>
</div>
</div>


<script src="../js/logoutConfirm.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const departments = <?php echo json_encode($departments); ?>;
const departmentCounts = <?php echo json_encode($departmentCounts); ?>;

const years = <?php echo json_encode($years); ?>;
const yearCounts = <?php echo json_encode($yearCounts); ?>;
</script>

<script src="../js/chart.js"></script>
</body>
</html>