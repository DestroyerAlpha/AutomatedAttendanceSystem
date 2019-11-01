<?php
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");

$query = "SELECT * FROM students";
$result = $conn->query($query);
// $num_rows = mysqli_num_rows($result);
echo "<table border=1>";
echo "<tr><th>USERID</th><th>COURSE CODE</th></tr>";
while($row = mysqli_fetch_array($result))
{
	$table1 = $row['username']."m";
	$query1 = "SELECT course_code FROM $table1 WHERE absent>0.2*(absent+present)";
	$result1 = $conn->query($query1);
	while($row1 = mysqli_fetch_array($result1))
	{
		echo "<tr>";
		echo "<td>";
		echo $row['username'];
		echo "</td>";
		echo "<td>";
		echo $row1['course_code'];
		echo "</td>";
		echo "</tr>";
	}

}
echo "</table>";
echo '<a href = "admin.html">Go Back</a>';
$conn->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>