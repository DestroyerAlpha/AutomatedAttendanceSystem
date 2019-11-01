<?php
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");

if(isset($_POST['stuinfo']))
{
	$stuinfo = get_post($conn, 'stuinfo');
	if($stuinfo=="")
	{
		echo '<a href = "admin.html">Go Back</a>';
		exit("<br>USERID MUST BE FILLED<br>");

	}
	$table = $stuinfo."m";
	$query = "SELECT * FROM $table";
	$result1 = $conn->query($query);
	if (!$result1)
	{ 
		echo (mysqli_error($conn)."<br><br>");
	}
	else
	{
		echo "NET ATTENDANCE<br>";
		echo "<table border=1>";
		echo "<tr><th>course_code</th><th>course_name</th><th>present</th><th>absent</th></tr>";
		while($row = mysqli_fetch_array($result1))
		{
		    echo "<tr>";
		    echo "<td>";
		    echo $row['course_code'];
		    echo "</td>";
		    echo "<td>";
		    echo $row['course_name'];
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

	$table = $stuinfo."present";
	$query = "SELECT * FROM $table";
	$result2 = $conn->query($query);
	if (!$result2)
	{ 
		echo (mysqli_error($conn)."<br><br>");
	}
	else
	{
		echo "PRESENT<br>";
		echo "<table border=1>";
		echo "<tr><th>course_code</th><th>Date</th></tr>";
		while($row = mysqli_fetch_array($result2))
		{
		    echo "<tr>";
		    echo "<td>";
		    echo $row['course_code'];
		    echo "</td>";
		    echo "<td>";
		    echo $row['pdate'];
		    echo "</td>";
		    echo "<td>";
		}
		echo "</table>";
		echo "<br>";
	}

	$table = $stuinfo."absent";
	$query = "SELECT * FROM $table";
	$result3 = $conn->query($query);
	if (!$result3)
	{ 
		echo (mysqli_error($conn)."<br><br>");
	}
	else
	{
		echo "ABSENT<br>";
		echo "<table border=1>";
		echo "<tr><th>course_code</th><th>Date</th></tr>";
		while($row = mysqli_fetch_array($result3))
		{
		    echo "<tr>";
		    echo "<td>";
		    echo $row['course_code'];
		    echo "</td>";
		    echo "<td>";
		    echo $row['adate'];
		    echo "</td>";
		    echo "<td>";
		}
		echo "</table>";
		echo "<br>";
	}
}
echo '<a href = "admin.html">Go Back</a>';
$conn->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>