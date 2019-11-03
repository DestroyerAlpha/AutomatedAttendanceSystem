<?php
session_start();
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");

$course = $_SESSION['course'];
echo $course."<br>";
$_SESSION['date'] = $_GET['date']; 
$date = $_SESSION['date'];
echo $date."<br>";
if(isset($_SESSION['date']))
{
	// $date = get_post($conn, 'date');
	// $course = get_post($conn, 'course');
	if($date=="")
	{
		echo '<a href = "onecourse.php?course=$course&searchpartcour=Search">Go Back</a>';
		exit("<br>DATE SELECTION IS NECESSARY<br>");

	}
	$table = $course."_attendance";
	$query = "SELECT * FROM $table WHERE Date='$date'";
	$result1 = $conn->query($query);
	if($row1= mysqli_fetch_array($result1))
	{
		$table1 = $course."_attendance";
		$query1 = "SELECT * FROM $table1 WHERE Date='$date'";
		$result2 = $conn->query($query1);
		echo "NET ATTENDANCE ON $date<br>";
		echo "<table border=1>";
		echo "<tr><th>Date</th><th>present</th><th>absent</th><th>present list</th><th>absent_list</th></tr>";
		echo (mysqli_error($conn)."<br>");
		while($row = mysqli_fetch_array($result2))
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
		    echo "<td>";
		    echo "<a href = 'listpresent.php'>list</a>";
		    echo "</td>";
		    echo "<td>";
		    echo "<a href = 'listabsent.php'>list</a>";
		    echo "</td>";
		    echo "</tr>";
		}
		echo "</table>";
		echo "<br>";
	}
	else
	{
		echo "DATA DOESN'T EXIST<br><br>";
	}
}
echo '<a href = "onecourse.php?course='.$course.'">Go Back</a>';
$conn->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>