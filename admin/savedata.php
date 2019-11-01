<?php
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Fatal Error");

if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['DOB']) && isset($_POST['userid']) && isset($_POST['insert']) && isset($_POST['Password']))
{
    $fname    = get_post($conn, 'fname');
    $lname   = get_post($conn, 'lname');
    $dob     = get_post($conn, 'DOB');
    $userid     = get_post($conn, 'userid');
    $password = get_post($conn, 'Password');
	$query    = "INSERT INTO students VALUES" . "('$fname','$lname', '$dob', '$userid', '$password')";
	$result = $conn->query($query);
	if (!$result) 
		echo "INSERT failed<br><br>";
	else 
		echo "INSERTED successfully<br><br>";
}


echo <<<_END
<form action="savedata.php" method="post">
		First Name:    <input type="text" name="fname"><br><br>
		Last Name:     <input type="text" name="lname"><br><br>
		Date Of Birth: <input type="Date" name="DOB"><br><br>
		userID:        <input type="text" name="userid"><br><br>
		Password:      <input type="Password" name="Password"><br><br>
		<input type = "hidden" name = "insert" value = "yes">
		<input type="submit" value="Submit"><br>
</form>
_END;
$result->close();
$connection->close();
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>