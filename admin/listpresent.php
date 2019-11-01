<?php
session_start();
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");
$course = $_SESSION['course'];
$date = $_SESSION['date'];
$query = "SELECT * FROM students";
$result = $conn->query($query);
echo "<table border=1>";
echo "<tr><th>USERID</th></tr>";
while($row = mysqli_fetch_array($result))
{
	$table = $row['username']."present";
	$query1 = "SELECT * FROM $table WHERE pdate = '$date' AND course_code='$course'";
	$result1 = $conn->query($query1);
	if($row1 = mysqli_fetch_array($result1))								//giving for all tables
	{
		echo "<tr>";
		echo "<td>";
		echo $row['username'];
		echo "</td>";
		echo "</tr>";
	}
}
echo "</table>";
echo '<a href = "searchbydate.php?date='.$date.'">Go Back</a>';
$conn->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>