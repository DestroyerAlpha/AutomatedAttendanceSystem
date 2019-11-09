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
            $query  = "SELECT * FROM students";
            $result = $conn->query($query);
            if (!$result) die ("courses access failed");
            
            $rows = $result->num_rows;
            for ($j = 0 ; $j < $rows ; ++$j)
            {
            $row = $result->fetch_array(MYSQLI_NUM);
            $r0 = htmlspecialchars($row[0]);
            $r1 = htmlspecialchars($row[1]);
            $r2 = htmlspecialchars($row[2]);
            $r3 = htmlspecialchars($row[3]);
            $r4 = htmlspecialchars($row[4]);
            if($r0 == $unsafename){
                $_SESSION['stname']=$r1;
                $_SESSION['stbranch']=$r3;
                $_SESSION['stbatch']=$r4;
            }
            header('Location: ./../student/dashboard.php');
        }
    }
}
}
else {
    header('Location: ./../home/home.html');
}
?>