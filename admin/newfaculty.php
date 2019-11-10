<style>
<?php include './../home/css/stylesheet.css';?>
</style>
<?php
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");

if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['DOB']) && isset($_POST['userid']) && isset($_POST['insert']) && isset($_POST['Password']))
{
    $fname    = get_post($conn, 'fname');
    $lname   = get_post($conn, 'lname');
    $dob     = get_post($conn, 'DOB');
    $password = get_post($conn, 'Password');
	$userid     = get_post($conn, 'userid');
	$name = $fname." ".$lname;
 	$query    = "INSERT INTO faculty_info VALUES" . "('$userid','$password','$name')";
	$result = $conn->query($query);
	if (!$result)
	{
		echo "      <script>
            alert('Error creating user account');
            window.location.href='./../admin/dashboard.php';
			</script>";
	}
	echo "      <script>
            alert('Successfully Created');
            window.location.href='./../admin/dashboard.php';
			</script>";
}
$result->close();
$connection->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>