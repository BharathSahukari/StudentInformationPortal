<?php
session_start();
include "../db.php";

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$department = isset($_GET['department']) ? mysqli_real_escape_string($conn, $_GET['department']) : "";
$year = isset($_GET['year']) ? (int)$_GET['year'] : 0;

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page < 1){
    $page = 1;
}
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM students WHERE 1=1";

if($search != ""){
    $sql .= " AND (
        full_name LIKE '%$search%'
        OR roll_no LIKE '%$search%'
        OR email LIKE '%$search%'
        OR phone LIKE '%$search%'
    )";
}

if($department != ""){
    $sql .= " AND department='$department'";
}

if($year > 0){
    $sql .= " AND year=$year";
}

$count_sql = str_replace("SELECT *", "SELECT COUNT(*) AS total", $sql);
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

$sql .= " ORDER BY id DESC LIMIT $offset,$limit";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>View Students</title>

<link rel="stylesheet" href="../css/studentViewStyle.css">
<link rel="stylesheet" href="../css/responsiveness.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="table-container">

<div class="table-header">

<h2>Student Records</h2>

</div>

<form method="GET" class="search-form">

    <input type="text" name="search"
           placeholder="Search Student..."
           value="<?php echo $search; ?>">

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

    <button type="submit">Search / Filter</button>

</form>

<br>

<table>

<thead>

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
<th>Address</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php
if(mysqli_num_rows($result)>0)
{
while($row=mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>

<?php
if(!empty($row['profile_image']))
{
?>
<img src="../uploads/<?php echo $row['profile_image']; ?>" width="60" height="60" style="border-radius:50%; object-fit:cover;">
<?php
}
else
{
    echo "No Image";
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

<td><?php echo $row['address']; ?></td>



<td>
   <a href="../edit/edit_student.php?id=<?php echo $row['id']; ?>&source=view_student" class="edit-btn">
        Edit
    </a>

    <a href="../delete_student.php?id=<?php echo $row['id']; ?>"
       class="delete-btn"
       onclick="return confirm('Are you sure you want to delete this student?');">
        Delete
    </a>
</td>



</tr>

<?php
}
}
else
{
?>

<tr>
<td colspan="10" style="text-align:center;">
No Students Found
</td>
</tr>

<?php
}
?>

</tbody>

</table>

<div class="pagination">
<?php
for($i=1;$i<=$total_pages;$i++){
?>
<a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&department=<?php echo urlencode($department); ?>&year=<?php echo $year; ?>"
class="<?php if($page==$i) echo 'active'; ?>">
<?php echo $i; ?>
</a>
<?php
}
?>
</div>


<br>

<a href="../dashboard/admin_dashboard.php" class="back-btn">
← Back to Dashboard
</a>

</div>

</div>

</body>
</html>