<?php
session_start();
require_once "./../sql_login/login.php";
$conn = mysqli_connect($hostname,$username,$password,$database);
$_SESSION['login'] = "TRUE";

if (!$conn) {
    die('<p>Connection failed: <p>' . mysqli_connect_error());
}
if (!empty($_POST['name']) && !empty($_POST['pass'])) {
    $unsafename = $_POST['name'];
    $unsafepass = $_POST['pass'];

    // reference for sql injection : https://www.w3schools.com/php/php_mysql_prepared_statements.asp
    $query = $conn->prepare("SELECT * FROM faculty_info WHERE username = ? AND password = ?");
    if ($query) {
        $query->bind_param('ss', $unsafename, $unsafepass);
        
        $query->execute();
        $result = $query->get_result();
        // $row = $result->fetch_array();
        $num_rows = $result->num_rows;
        if (!$num_rows) {
            echo "<script>
                alert('Incorrect login details!');
                window.location.href='./../home/home.html';
                </script>";
        }
        else {
            $_SESSION['username'] = $unsafename;
            $_SESSION['password'] = $unsafepass;
            // $_SESSION['name'] = $row['name'];
            header('Location: ./../faculty/dashboard.php');
        }
    }
}
else {
    echo "<script>
                alert('Please fill in all the details!');
                window.location.href='./../home/home.html';
                </script>";
}
?>