<?php
session_start();
require_once "./../sql_login/login.php";

$conn = mysqli_connect($hostname,$username,$password,$database);
if(!$conn)
{
    echo "Connect Error:".mysqli_error($conn);
}
$faculty_id = $_SESSION['username'];
$course_code = $_POST['course'];
<<<<<<< HEAD
if($_POST['in']=="View/Attendance")
{
    echo "<h1>".$course_code." Attendance</h1>";
    $query = "SELECT * FROM $course_code"."_attendance";
    $result = mysqli_query($conn,$query);
    echo "<table border=1>";
    echo "<tr><th>Date</th><th>Present</th><th>Absent</th></tr>";
    while($row = mysqli_fetch_array($result))
    {
        echo "<tr>";
        echo "<td>";
        echo $row['attendance_date'];
        echo "</td>";
        echo "<td>";
        echo $row['present'];
        echo "</td>";
        echo "<td>";
        echo $row['absentees'];
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
else
{
    // echo $course_code;
    $query = "DELETE FROM courses WHERE course_code = '$course_code'";
    $result = mysqli_query($conn,$query);
    if(!$result)
    {
        echo "Couldn't delete<br>".mysqli_error($conn);
    }
    else
    {
        echo "Course Deleted";
        $query = "DROP TABLE $course_code";
        $result = mysqli_query($conn,$query);
        if(!$result)
        {
            echo "Course table couldn't be dropped. <br>";
        }
        $table_name = $course_code."_attendance";
        $query = "DROP TABLE $table_name";
        $result = mysqli_query($conn,$query);
        if(!$result)
        {
            echo "Course attendance couldn't be dropped. <br>";
        }
    }
}
=======
echo "<h1>".$course_code." Attendance</h1>";
$query = "SELECT * FROM $course_code"."_attendance";
$result = mysqli_query($conn,$query);
echo "<table border=1>";
echo "<tr><th>Date</th><th>Present</th><th>Absent</th></tr>";
while($row = mysqli_fetch_array($result))
{
    echo "<tr>";
    echo "<td>";
    echo $row['attendance_date'];
    echo "</td>";
    echo "<td>";
    echo $row['present'];
    echo "</td>";
    echo "<td>";
    echo $row['absentees'];
    echo "</td>";
    echo "</tr>";
}
echo "</table>";

>>>>>>> bf1330951adb182f5beb29bba2755db4860354b9
?>