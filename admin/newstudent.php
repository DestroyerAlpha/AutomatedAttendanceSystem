<style>
<?php include './../home/css/stylesheet.css';?>
</style>
<?php
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");

if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['DOB']) && isset($_POST['userid']) && isset($_POST['insert']) && isset($_POST['Password']) && isset($_POST['branch']) && isset($_POST['batch']))
{
    $fname    = get_post($conn, 'fname');
    $lname   = get_post($conn, 'lname');
    $dob     = get_post($conn, 'DOB');
    $password = get_post($conn, 'Password');
    $userid     = get_post($conn, 'userid');
    $name = $fname . " " . $lname;
    $table = $userid."m";
    $branch = get_post($conn,'branch');
    $batch = get_post($conn,'batch');
	$query1    = "CREATE TABLE $table (course_code varchar(256) NOT NULL PRIMARY KEY,course_name varchar(256) NOT NULL,present int DEFAULT 0, absent int DEFAULT 0)";
	$result1 = $conn->query($query1);
	if (!$result1)
	{ 
		echo "      <script>
            alert('Error creating user account');
            window.location.href='./../admin/dashboard.php';
            </script>";
	}

	$present = $userid."present";
	$query2    = "CREATE TABLE $present (course_code varchar(256) NOT NULL,pdate date)";
	$result2 = $conn->query($query2);
	if (!$result2)
	{
		$query1    = "DROP TABLE $table";
		$result1 = $conn->query($query1);
		echo "      <script>
            alert('Error creating user account');
            window.location.href='./../admin/dashboard.php';
			</script>";
	}

	$absent = $userid."absent";
	$query3    = "CREATE TABLE $absent (course_code varchar(256) NOT NULL ,adate date)";
	$result3 = $conn->query($query3);
	if (!$result3)
	{ 
		$query1    = "DROP TABLE $table";
		$result1 = $conn->query($query1);
		$query1    = "DROP TABLE $present";
		$result1 = $conn->query($query1);
		echo "      <script>
            alert('Error creating user account');
            window.location.href='./../admin/dashboard.php';
			</script>";
	}
	$query4    = "INSERT INTO student_info VALUES" . "('$userid','$password')";
	$result4 = $conn->query($query4);
	if (!$result4)
	{ 
		$query1    = "DROP TABLE $table";
		$result1 = $conn->query($query1);
		$query1    = "DROP TABLE $present";
		$result1 = $conn->query($query1);
		$query1    = "DROP TABLE $absent";
		$result1 = $conn->query($query1);
		echo "      <script>
            alert('Error creating user account');
            window.location.href='./../admin/dashboard.php';
			</script>";
	}
	$query5    = "INSERT INTO students(username,name,dob,branch,batch) VALUES('$userid','$name','$dob','$branch','$batch')";					
	$result5 = $conn->query($query5);
	if (!$result5)
	{ 
		$query1    = "DROP TABLE $table";
		$result1 = $conn->query($query1);
		$query1    = "DROP TABLE $present";
		$result1 = $conn->query($query1);
		$query1    = "DROP TABLE $absent";
		$result1 = $conn->query($query1);
		$query1    = "DELETE FROM student_info WHERE username='$userid'";
		$result1 = $conn->query($query1);
		echo "      <script>
            alert('Error creating user account');
            window.location.href='./../admin/dashboard.php';
			</script>";
	}
	echo "      <script>
            alert('Successfully Created Student Account');
            window.location.href='./../admin/dashboard.php';
			</script>";
}

$conn->close();
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>