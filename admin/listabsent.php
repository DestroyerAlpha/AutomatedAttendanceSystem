<?php
session_start();
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");
$course = $_SESSION['course'];
$date = $_SESSION['date'];
$date1 = $_SESSION['date1'];
try{
    $drop_query = "DROP TABLE absent";
    $res = mysqli_query($conn,$drop_query);
}
catch (Exception $exception){
    echo "The given table doens't exist. <br/>";
}

$query3 = "CREATE TABLE absent(username varchar(20))";
if(!mysqli_query($conn,$query3))
{
	echo (mysqli_error($conn));
}
$query = "SELECT * FROM students";
$result = $conn->query($query);
$table = "absent";
$query = "SELECT * FROM students";
$result = $conn->query($query);
echo "<table border=1>";
echo "<tr><th>USERID</th></tr>";
while($row = mysqli_fetch_array($result))
{
	$table = $row['username']."absent";
	$query1 = "SELECT * FROM $table WHERE adate = '$date' AND course_code='$course'";
	$result1 = $conn->query($query1);
	if($row1 = mysqli_fetch_array($result1))								
	{
		$query4 = "INSERT INTO absent values('".$row['username']."')";
		$res1 = mysqli_query($conn,$query4);
		if(!$res1)
		{
			echo (mysqli_error($conn)."<br>");
		}
		echo "<tr>";
		echo "<td>";
		echo $row['username'];
		echo "</td>";
		echo "</tr>";
	}
}
echo "</table>";
echo<<<_END
<form action="toexcel.php" method="get">
	<input type = "hidden" name = "table" value = $table>
	<input type = "submit" name = submit value = "converttoxls">
</form>
_END;
echo '<a href = "searchbydate.php?date='.$date.'&date1='.$date1.'">Go Back</a>';
echo '<a href = "searchbydate.php?date='.$date.'">Go Back</a>';
$conn->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>