<?php
session_start();
require_once "./../sql_login/login.php";
$course_code = $_POST['course'];
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Add Attendance</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./css/stylesheet.css">
    </head>
    <body>
        <form action="./../faculty/updatation.php?ccode=<?php echo $course_code?>" method="POST">
    <?php
        $conn = mysqli_connect($hostname,$username,$password,$database);
        if(!$conn)
        {
            echo "Connect Error:".mysqli_error($conn);
        }
        $faculty_id = $_SESSION['username'];
        echo $course_code;
        $query = "SELECT * FROM $course_code";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result))
        {
            $student_id = $row['student_id'];
            echo "<li><input type=\"checkbox\" name=\"check_list[]\" value=$student_id>&emsp;".$student_id."</li><br>";
        }
    ?>
    <input type="submit" class="submit-button" name="submit">
    </form>
    </body>
</html>