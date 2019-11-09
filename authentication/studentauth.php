<?php
session_start();

require_once "./../sql_login/login.php";
$conn = mysqli_connect($hostname,$username,$password,$database);

if (!$conn) {
    die('<p>Connection failed: <p>' . mysqli_connect_error());
}
if (!empty($_POST['name']) && !empty($_POST['pass'])) {
    $unsafename = $_POST['name'];
    $unsafepass = $_POST['pass'];
    $_SESSION['stuser']= $unsafename;

    // reference for sql injection : https://www.w3schools.com/php/php_mysql_prepared_statements.asp
    $query = $conn->prepare("SELECT * FROM student_info WHERE username = ? AND password = ?");
   
    if ($query) {
        $query->bind_param('ss', $unsafename, $unsafepass);
        
        $query->execute();
        $result = $query->get_result();
        $num_rows = $result->num_rows;
        if (!$num_rows) {
            header('Location: ./../home/home.html');
        }
        else {
            header('Location: ./../student/dashboard.php');
        }
    }
}
else {
    header('Location: ./../home/home.html');
}
?>