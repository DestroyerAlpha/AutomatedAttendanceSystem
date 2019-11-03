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

?>