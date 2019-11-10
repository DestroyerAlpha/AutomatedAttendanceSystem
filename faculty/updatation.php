<style>
<?php include './../home/css/stylesheet.css';?>
</style>
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
        // echo "Today's date: ".$tdate."<br>";
        $course_code = $_GET['ccode'];
        if(!empty($_POST['check_list']))
        {
            $present = count($_POST['check_list']);
            // echo "Updated attendance for ".$course_code."<br>";
            $query = "SELECT * FROM $course_code";
            $result = mysqli_query($conn, $query);
            $rows = mysqli_num_rows($result);
            $absentees = $rows - $present;
            $table_name = $course_code."_attendance";
            $query = "SELECT * FROM $table_name WHERE attendance_date = '$tdate'";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result)>0)
            {
                $query = "DELETE FROM $table_name WHERE attendance_date = '$tdate'";
                $result = mysqli_query($conn, $query);
            }
            $query = "INSERT INTO $table_name VALUES('$tdate', '$present', '$absentees')";
            $result = mysqli_query($conn, $query);
            if(!$result)
            {
                // echo "Couldn't add attendance for the day<br>".mysqli_error($conn);
                echo "      <script>
                    alert('Couldn't add attendance for the day');
                    window.location.href='./../faculty/dashboard.php';
                    </script>";
            }
            foreach($_POST['check_list'] as $student)
            {
                $table1 = $student."present";
                $table2 = $student."absent";
                $query = "SELECT * FROM $table1 WHERE pdate = '$tdate' AND course_code = '$course_code'";
                $result = mysqli_query($conn, $query);
                $query = "SELECT * FROM $table2 WHERE adate = '$tdate' AND course_code = '$course_code'";
                $result1 = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)>0 || mysqli_num_rows($result1)>0)
                {
                    $query = "DELETE FROM $table1 WHERE pdate = '$tdate' AND course_code = '$course_code'";
                    $result = mysqli_query($conn, $query);
                    $query = "DELETE FROM $table2 WHERE adate = '$tdate' AND course_code = '$course_code'";
                    $result = mysqli_query($conn, $query);
                }
                $query1 = "INSERT INTO $table1 VALUES('$course_code','$tdate')";
                $result = mysqli_query($conn, $query1);
                if(!$result)
                {
                    // echo "Couldn't mark $student present<br>".mysqli_error($conn);
                    echo "      <script>
                    alert('Couldn't mark $student present');
                    window.location.href='./../faculty/dashboard.php';
                    </script>";
                }
                $table3 = $student."m";
                $query = "SELECT * FROM $table1 WHERE course_code = '$course_code'";
                $result = mysqli_query($conn, $query);
                $query = "SELECT * FROM $table2 WHERE course_code = '$course_code'";
                $result1 = mysqli_query($conn, $query);
                $present = 0;
                if($result)
                    $present = mysqli_num_rows($result);
                $absent = 0;
                if($result1)
                    $absent = mysqli_num_rows($result1);
                // $query2 = "SELECT * FROM $table2 WHERE course_code = '$couse_code'";
                // $result = mysqli_query($conn,$query2);
                // $row = mysqli_fetch_array($result);
                // $present = $row['present'];
                // $present = $present + 1;
                $newq = "UPDATE $table3 SET present=$present , absent=$absent WHERE course_code = '$course_code'";
                $result = mysqli_query($conn,$newq);
                if(!$result)
                {
                    // echo "Couldn't mark $student present in his table".mysqli_error($conn);
                    echo "      <script>
                    alert('Couldn't mark $student present in his table');
                    window.location.href='./../faculty/dashboard.php';
                    </script>";
                }
            }
            $query2 = "SELECT * FROM $course_code";
            $result1 = mysqli_query($conn, $query2);
            while($row = mysqli_fetch_array($result1))
            {
                $student_id = $row['student_id'];
                if(!in_array($student_id,$_POST['check_list']))
                {
                    $table2 = $student_id."absent";
                    $table1 = $student_id."present";
                    $query = "SELECT * FROM $table2 WHERE adate = '$tdate' AND course_code = '$course_code'";
                    $result = mysqli_query($conn, $query);
                    $query = "SELECT * FROM $table1 WHERE pdate = '$tdate' AND course_code = '$course_code'";
                    $result1 = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result)>0 || mysqli_num_rows($result1)>0)
                    {
                        $query = "DELETE FROM $table2 WHERE adate = '$tdate' AND course_code = '$course_code'";
                        $result = mysqli_query($conn, $query);
                        $query = "DELETE FROM $table1 WHERE pdate = '$tdate' AND course_code = '$course_code'";
                        $result = mysqli_query($conn, $query);
                    }
                    $query2 = "INSERT INTO $table2 VALUES('$course_code','$tdate')";
                    $result = mysqli_query($conn,$query2);
                    if(!$result)
                    {
                        // echo "Couldn't mark $student_id absent<br>".mysqli_error($conn);
                        echo "      <script>
                            alert('Couldn't mark $student_id absent');
                            window.location.href='./../faculty/dashboard.php';
                            </script>";
                    }
                    $table3 = $student_id."m";
                    $query = "SELECT * FROM $table2 WHERE course_code = '$course_code'";
                    $result = mysqli_query($conn, $query);
                    $query = "SELECT * FROM $table1 WHERE course_code = '$course_code'";
                    $result1 = mysqli_query($conn, $query);
                    $present = 0;
                    if($result1)
                        $present = mysqli_num_rows($result);
                    $absent = 0;
                    if($result)
                        $absent = mysqli_num_rows($result1);
                    // $query2 = "SELECT * FROM $table2 WHERE course_code = '$course_code'";
                    // $result = mysqli_query($conn,$query2);
                    // $row = mysqli_fetch_array($result);
                    // $absent = $row['absent'];
                    // $absent = $absent + 1;
                    $newq = "UPDATE $table3 SET absent=$absent , present = $present WHERE course_code = '$course_code'";
                    $result = mysqli_query($conn,$newq);
                    if(!$result)
                    {
                        // echo "Couldn't mark $student_id present in his table".mysqli_error($conn);
                        echo "      <script>
                            alert('Couldn't mark $student_id present in his table');
                            window.location.href='./../faculty/dashboard.php';
                            </script>";
                    }
                }
            }
        }
        else
        {
            $present = count($_POST['check_list']);
            // echo "Updated attendance for ".$course_code."<br>";
            $query = "SELECT * FROM $course_code";
            $result = mysqli_query($conn, $query);
            $rows = mysqli_num_rows($result);
            $absentees = $rows - $present;
            $table_name = $course_code."_attendance";
            $query = "SELECT * FROM $table_name WHERE attendance_date = '$tdate'";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result)>0)
            {
                $query = "DELETE FROM $table_name WHERE attendance_date = '$tdate'";
                $result = mysqli_query($conn, $query);
            }
            $query = "INSERT INTO $table_name VALUES('$tdate', '$present', '$absentees')";
            $result = mysqli_query($conn, $query);
            if(!$result)
            {
                // echo "Couldn't add attendance for the day<br>".mysqli_error($conn);
                echo "      <script>
                    alert('Couldn't add attendance for the day');
                    window.location.href='./../faculty/dashboard.php';
                    </script>";
            }
            $query2 = "SELECT * FROM $course_code";
            $result1 = mysqli_query($conn, $query2);
            while($row = mysqli_fetch_array($result1))
            {
                $student_id = $row['student_id'];
                $table2 = $student_id."absent";
                $table1 = $student_id."present";
                $query = "SELECT * FROM $table2 WHERE adate = '$tdate' AND course_code = '$course_code'";
                $result = mysqli_query($conn, $query);
                $query = "SELECT * FROM $table1 WHERE pdate = '$tdate' AND course_code = '$course_code'";
                $result1 = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)>0 || mysqli_num_rows($result1)>0)
                {
                    $query = "DELETE FROM $table2 WHERE adate = '$tdate' AND course_code = '$course_code'";
                    $result = mysqli_query($conn, $query);
                    $query = "DELETE FROM $table1 WHERE pdate = '$tdate' AND course_code = '$course_code'";
                    $result = mysqli_query($conn, $query);
                }
                $query2 = "INSERT INTO $table2 VALUES('$course_code','$tdate')";
                $result = mysqli_query($conn,$query2);
                if(!$result)
                {
                    // echo "Couldn't mark $student_id absent<br>".mysqli_error($conn);
                    echo "      <script>
                            alert('Couldn't mark $student_id absent');
                            window.location.href='./../faculty/dashboard.php';
                            </script>";
                }
                $table3 = $student_id."m";
                $query = "SELECT * FROM $table1 WHERE course_code = '$course_code'";
                $result = mysqli_query($conn, $query);
                $query = "SELECT * FROM $table2 WHERE course_code = '$course_code'";
                $result1 = mysqli_query($conn, $query);
                $present = 0;
                if($result)
                    $present = mysqli_num_rows($result);
                $absent = 0;
                if($result1)
                    $absent = mysqli_num_rows($result1);
                // $query2 = "SELECT * FROM $table2 WHERE course_code = '$couse_code'";
                // $result = mysqli_query($conn,$query2);
                // $row = mysqli_fetch_array($result);
                // $absent = $row['absent'];
                // $absent = $absent + 1;
                $newq = "UPDATE $table3 SET absent=$absent , present = $present WHERE course_code = '$course_code'";
                $result = mysqli_query($conn,$newq);
                if(!$result)
                {
                    // echo "Couldn't mark $student_id present in his table".mysqli_error($conn);
                    echo "      <script>
                            alert('Couldn't mark $student_id present in his table');
                            window.location.href='./../faculty/dashboard.php';
                            </script>";
                }
            }
        }
        echo "      <script>
                    alert('Added Attendance for $course_code');
                    window.location.href='./../faculty/dashboard.php';
                    </script>";
?>