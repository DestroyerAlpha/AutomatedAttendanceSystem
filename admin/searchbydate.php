<?php
session_start();
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");

$course = $_SESSION['course'];
echo $course."<br>";
$_SESSION['date'] = $_GET['date']; 
$_SESSION['date1'] = $_GET['date1'];
$date = $_SESSION['date'];
$date1 = $_SESSION['date1'];
// try{
//     $drop_query = "DROP TABLE searchbydate";
//     $res = mysqli_query($conn,$drop_query);
// }
// catch (Exception $exception){
    // echo "The given table doens't exist. <br/>";
// }

//$query3 = "CREATE TABLE searchbydate(Date date, present int, absent int, presentlist varchar(20), absentlist varchar(20))";
// if(!mysqli_query($conn,$query3))
// {
// 	echo (mysqli_error($conn));
// }
// $table = "searchbydate";
if(isset($_SESSION['date']) && isset($_SESSION['date1']))
{
	// $date = get_post($conn, 'date');
	// $course = get_post($conn, 'course');
	if($date=="" || $date1=="")
	{
		echo '<a href = "onecourse.php?course='.$course.'&searchpartcour=Search">Go Back</a>';
		exit("<br>DATE SELECTION IS NECESSARY<br>");

	}
	if($date > $date1)
	{
		echo '<a href = "onecourse.php?course='.$course.'&searchpartcour=Search">Go Back</a>';
		exit("<br>invalid dates selection<br>");

	}
	$table = $course."_attendance";
	$query = "SELECT * FROM $table WHERE attendance_date BETWEEN '$date' and '$date1'";
	$result1 = $conn->query($query);
	echo (mysqli_error($conn)."<br>");
	if($row1= mysqli_fetch_array($result1))
	{
		$table1 = $course."_attendance";
		$query1 = "SELECT * FROM $table1 WHERE attendance_date BETWEEN '$date' and '$date1'";
		$result2 = $conn->query($query1);
		echo "NET ATTENDANCE ON $date<br>";
		echo "<table border=1>";
		echo "<tr><th>Date</th><th>present</th><th>absent</th><th>present list</th><th>absent_list</th></tr>";
		echo (mysqli_error($conn)."<br>");
		while($row = mysqli_fetch_array($result2))
		{
			// $query4 = "INSERT INTO searchbydate values('".$row['attendance_date']."','".$row['present']."','".$row['absentees']."')";
			// $res1 = mysqli_query($conn,$query4);
			// if(!$res1)
			// {
			// 	echo (mysqli_error($conn)."<br>");
			// }
		    echo "<tr>";
		    echo "<td>";
		    echo $row['attendance_date'];
		    echo "</td>";
		    echo "<td>";
		    echo $row['present'];
		    echo "</td>";
		    echo "<td>";
		    echo $row['absentees'];
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
		echo (mysqli_error($conn)."<br>");
	}
}
echo<<<_END
<form action="toexcel.php" method="get">
	<input type = "hidden" name = "table" value = $table>
	<input type = "submit" name = submit value = "converttoxls">
</form>
_END;
echo '<a href = "onecourse.php?course='.$course.'">Go Back</a>';
$conn->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>