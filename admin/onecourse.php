<?php
session_start();
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");

$_SESSION['course']=$_GET['course'];
$course = $_GET['course'];
echo $course."<br>";
if(isset($_SESSION['course']))
{
	// $course = get_post($conn, 'course');
	if($course=="")
	{
		echo '<a href = "admin.html">Go Back</a>';
		exit("<br>COURSE_CODE MUST BE FILLED<br>");

	}
	$query = "SELECT * FROM $course"."_attendance";
	$result1 = $conn->query($query);
	if (!$result1)
	{ 
		echo '<a href = "admin.html">Go Back</a><br><br>';
		exit("DATA DOESN'T EXIST<br><br>");
	}
	else
	{
		echo "NET ATTENDANCE OF $course<br>";
		echo "<table border=1>";
		echo "<tr><th>Date</th><th>Total_present</th><th>Total_absent</th></tr>";
		while($row = mysqli_fetch_array($result1))
		{
		    echo "<tr>";
		    echo "<td>";
		    echo $row['Date'];
		    echo "</td>";
		    echo "<td>";
		    echo $row['present'];
		    echo "</td>";
		    echo "<td>";
		    echo $row['absent'];
		    echo "</td>";
		    echo "</tr>";
		}
		echo "</table>";
		echo "<br>";
	}
}

echo<<<_END
<form action="searchbydate.php" method="get">
	search by date
	<input type="date" name="date"><br><br> 
	<input type="submit" name="submit" value="Search">
</form>
_END;
echo '<a href = "admin.html">Go Back</a>';
$conn->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>