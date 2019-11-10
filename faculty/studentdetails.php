<style>
<?php include './../home/css/stylesheet.css';?>
</style>
<?php
session_start();
require_once "./../sql_login/login.php";

$conn = mysqli_connect($hostname,$username,$password,$database);
if(!$conn)
{
    // echo "Connect Error:".mysqli_error($conn);
    echo "      <script>
            alert('Connect Error');
            window.location.href='./../faculty/dashboard.php';
            </script>";
    
}
$faculty_id = $_SESSION['username'];
$course_code = $_POST['course'];
$_SESSION['course'] = $course_code;
if($_POST['in']=="View Attendance")
{
    echo "<h1>".$course_code." Attendance</h1>";
    $query1 = "SELECT * FROM $course_code"."_attendance";
    $result2 = $conn->query($query1);
    echo "<table border=1>";
    echo "<tr><th>Date</th><th>present</th><th>absent</th></tr>";
    echo (mysqli_error($conn)."<br>");
    while($row = mysqli_fetch_array($result2))
    {
        $date = $row['attendance_date'];
        // $query4 = "INSERT INTO searchbydate values('".$row['attendance_date']."','".$row['present']."','".$row['absentees']."')";
        // $res1 = mysqli_query($conn,$query4);
        // if(!$res1)
        // {
        // 	echo (mysqli_error($conn)."<br>");
        // }
        echo "<tr>";
        echo "<td>";
        echo $row['attendance_date'];
        echo "</td>";
        echo "<td>";
        echo "<a href = './listpresent.php?date=".$date."'>".$row['present']."</a>";
        echo "</td>";
        echo "<td>";
        echo "<a href = './listabsent.php?date=".$date."'>".$row['absentees']."</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";
}
else
{
    // echo $course_code;
    $query = "DELETE FROM courses WHERE course_code = '$course_code'";
    $result = mysqli_query($conn,$query);
    if(!$result)
    {
        // echo "Couldn't delete<br>".mysqli_error($conn);
        echo "      <script>
            alert('Couldn't delete');
            window.location.href='./../faculty/dashboard.php';
            </script>";
    }
    else
    {
        echo "Course Deleted";
        $query = "DROP TABLE $course_code";
        $result = mysqli_query($conn,$query);
        if(!$result)
        {
            // echo "Course table couldn't be dropped. <br>";
            echo "      <script>
            alert('Course table couldn't be dropped.');
            window.location.href='./../faculty/dashboard.php';
            </script>";
        }
        $table_name = $course_code."_attendance";
        $query = "DROP TABLE $table_name";
        $result = mysqli_query($conn,$query);
        if(!$result)
        {
            // echo "Course attendance couldn't be dropped. <br>";
            echo "      <script>
            alert('Course attendance couldn't be dropped.');
            window.location.href='./../faculty/dashboard.php';
            </script>";
        }
    }
}
?>