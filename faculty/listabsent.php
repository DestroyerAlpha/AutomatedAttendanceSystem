<style>
<?php include './../home/css/stylesheet.css';?>
</style>
<?php
session_start();
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");
$course = $_SESSION['course'];
// echo $course;
$query = "SELECT * FROM students";
$result = $conn->query($query);
echo "<table border=1>";
echo "<tr><th>USERID</th></tr>";
while($row = mysqli_fetch_array($result))
{
	$table1 = $row['username']."absent";
	$query1 = "SELECT * FROM $table1 WHERE course_code='$course'";
    $result1 = $conn->query($query1);
	if($row1 = mysqli_fetch_array($result1))							
	{
		echo "<tr>";
		echo "<td>";
		echo $row['username'];
		echo "</td>";
		echo "</tr>";
}
}
echo "</table>";
?>
<a href="./../faculty/dashboard.php">Go back</a>