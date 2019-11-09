<?php
session_start();
require_once "./../sql_login/login.php";
$conn = mysqli_connect($hostname,$username,$password,$database);
$faculty_id = $_SESSION['username'];
if (!$conn)
{
    die('<p>Connection failed: <p>' . mysqli_connect_error());
}
?>
<?php
        $tdate = date("Y-m-d");
        echo "Today's date: ".$tdate."<br>";
        $course_code = $_GET['ccode'];
        if(!empty($_POST['check_list']))
        {
            $present = count($_POST['check_list']);
            echo "Updated attendance for ".$course_code."<br>";
            $query = "SELECT * FROM $course_code";
            $result = mysqli_query($conn, $query);
            $rows = mysqli_num_rows($result);
            $absentees = $rows - $present;
            $table_name = $course_code."_attendance";
            $query = "INSERT INTO $table_name VALUES('$tdate', '$present', '$absentees')";
            $result = mysqli_query($conn, $query);
            if(!$result)
            {
                echo "Couldn't add attendance for the day<br>".mysqli_error($conn);
            }
            foreach($_POST['check_list'] as $student)
            {
                $table1 = $student."present";
                $query1 = "INSERT INTO $table1 VALUES('$course_code','$tdate')";
                $result = mysqli_query($conn, $query1);
                if(!$result)
                {
                    echo "Couldn't mark $student present<br>".mysqli_error($conn);
                }
                $table2 = $student."m";
                $query2 = "SELECT * FROM $table2 WHERE course_code = '$couse_code'";
                $result = mysqli_query($conn,$query2);
                $row = mysqli_fetch_array($result);
                $present = $row['present'];
                $present = $present + 1;
                $newq = "UPDATE $table2 SET present=$present WHERE course_code = '$course_code'";
                $result = mysqli_query($conn,$newq);
                if(!$result)
                {
                    echo "Couldn't mark $student present in his table".mysqli_error($conn);
                }
            }
            $query2 = "SELECT * FROM $course_code";
            $result1 = mysqli_query($conn, $query2);
            if(!$result1)
            {
                echo mysqli_error($conn);
            }
            while($row = mysqli_fetch_array($result1))
            {
                $student_id = $row['student_id'];
                if(!in_array($student_id,$_POST['check_list']))
                {
                    $table2 = $student_id."absent";
                    $query2 = "INSERT INTO $table2 VALUES('$course_code','$tdate')";
                    $result = mysqli_query($conn,$query2);
                    if(!result)
                    {
                        echo "Couldn't mark $student_id absent<br>".mysqli_error($conn);
                    }
                    $table2 = $student_id."m";
                    $query2 = "SELECT * FROM $table2 WHERE course_code = '$couse_code'";
                    $result = mysqli_query($conn,$query2);
                    $row = mysqli_fetch_array($result);
                    $absent = $row['present'];
                    $absent = $absent + 1;
                    $newq = "UPDATE $table2 SET absent=$absent WHERE course_code = '$course_code'";
                    $result = mysqli_query($conn,$newq);
                    if(!$result)
                    {
                        echo "Couldn't mark $student_id present in his table".mysqli_error($conn);
                    }
                }
            }
        }
        else
        {
            $query2 = "SELECT * FROM $course_code";
            $result1 = mysqli_query($conn, $query2);
            if(!$result1)
            {
                echo mysqli_error($conn);
            }
            while($row = mysqli_fetch_array($result1))
            {
                $student_id = $row['student_id'];
                $table2 = $student_id."absent";
                $query2 = "INSERT INTO $table2 VALUES('$course_code','$tdate')";
                $result = mysqli_query($conn,$query2);
                if(!result)
                {
                    echo "Couldn't mark $student_id absent<br>".mysqli_error($conn);
                }
                $table2 = $student_id."m";
                $query2 = "SELECT * FROM $table2 WHERE course_code = '$couse_code'";
                $result = mysqli_query($conn,$query2);
                $row = mysqli_fetch_array($result);
                $absent = $row['present'];
                $absent = $absent + 1;
                $newq = "UPDATE $table2 SET absent=$absent WHERE course_code = '$course_code'";
                $result = mysqli_query($conn,$newq);
                if(!$result)
                {
                    echo "Couldn't mark $student_id present in his table".mysqli_error($conn);
                }
            }
        }
        echo "<a href=\"./../faculty/dashboard.php\">Go back!</a>";
?>