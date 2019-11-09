<?php
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");

$query = "SELECT * FROM students";
$result = $conn->query($query);
// $num_rows = mysqli_num_rows($result);
// $query2 = "DROP TABLE IF EXISTS defaulter";
// if($conn->query($query2))
// {
// 	echo "create defaulter dropped successfully<br>";
// }
// $res = mysqli_query($conn,$query2);
// if(!$res)
// {
// 	echo (mysqli_error($conn));
// }
 try{
    $drop_query = "DROP TABLE defaulter";
    $res = mysqli_query($conn,$drop_query);
}
catch (Exception $exception){
    echo "The given table doens't exist. <br/>";
}

$query3 = "CREATE TABLE defaulter(username varchar(20), course_code varchar(20))";
if(!mysqli_query($conn,$query3))
{
	echo (mysqli_error($conn));
}
// if($conn->query($query3))
// {
// 	echo "table defaulter created successfully<br>";
// }
$table = "defaulter";
echo "<table border=1>";
echo "<tr><th>USERID</th><th>COURSE CODE</th></tr>";
while($row = mysqli_fetch_array($result))
{
	$table1 = $row['username']."m";
	$query1 = "SELECT course_code FROM $table1 WHERE absent>0.2*(absent+present)";
	$result1 = $conn->query($query1);
	while($row1 = mysqli_fetch_array($result1))
	{
		$query4 = "INSERT INTO defaulter values('".$row['username']."','".$row1['course_code']."')";
		$res1 = mysqli_query($conn,$query4);
		if(!$res1)
		{
			echo (mysqli_error($conn)."<br>");
		}
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
// echo $table."<br>";
echo<<<_END
<form action="toexcel.php" method="get">
	<input type = "hidden" name = "table" value = $table>
	<input type = "submit" name = submit value = "converttoxls">
</form>
_END;
echo "</table>";
echo '<a href = "admin.html">Go Back</a>';
$conn->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>