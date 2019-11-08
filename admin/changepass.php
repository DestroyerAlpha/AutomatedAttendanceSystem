<?php
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");

$_SESSION['userid'] = $_GET['userid'];
$userid = $_SESSION['userid'];

if(isset($_POST['password']) && $_POST['userid'])
{
	$userid = $_POST['userid'];
	$password = $_POST['password'];
	$query = "UPDATE student_info SET password = '$password' WHERE username = '$userid'";
	$result = mysqli_query($conn,$query);
	if($result)
	{
		echo '<a href = "changepass.php?userid='.$userid.'&submit=Change+Password">Go Back</a><br><br>';
		exit("password updated successfully!<br>");
	}
	else
	{
		echo '<a href = "changepass.php?userid='.$userid.'&submit=Change+Password">Go Back</a><br><br>';
		echo (mysqli_error($conn)."<br>");
		exit();
	}
}

echo<<<_END
<form action = "changepass.php?userid=$userid&submit=Change+Password" method="post">
	New Password<br>
	<input type = "password" name = "password" placeholder = "enter new password">
	<input type = "hidden" name = "userid" value = "$userid">
	<input type = "submit" name = "submit"  value = "Update">
</form>
_END;

echo '<br><br><a href = "onestudent.php?stuinfo='.$userid.'&submit=Search">Go Back</a>';

$conn->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>
