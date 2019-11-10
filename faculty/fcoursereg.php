<style>
<?php include './../home/css/stylesheet.css';?>
</style>
<?php
session_start();
?>

<?php
require_once "./../sql_login/login.php";
$conn = mysqli_connect($hostname,$username,$password,$database);

if (!$conn)
{
    // die('<p>Connection failed: <p>' . mysqli_connect_error());
    echo "      <script>
        alert('Connection failed');
        window.location.href='./../faculty/dashboard.php';
        </script>";
}
$username = $_SESSION['username'];
$course_code = $_POST['ccode'];
$course_name = $_POST['cname'];
$course_batch = $_POST['cbatch'];
$course_branch = $_POST['cbranch'];

// $query1 = 'INSERT INTO courses(course_code,course_name,faculty_id,batch,branch) VALUES(?,?,?,?,?)';
// $query1 = prepared_query($conn, $query1, [$course_code,$course_name,$username,$course_batch,$course_branch]);
if(!isset($_POST['ccode']) && !isset($_POST['cname']) && !isset($_POST['cbatch']) && !isset($_POST['cbranch']))
{
    echo "      <script>
        alert('Please fill some entry to insert course');
        window.location.href='./../faculty/dashboard.php';
        </script>";
}

$query1 = "INSERT INTO courses VALUES('$course_code','$course_name','$username',0,$course_batch,'$course_branch')";
$result = mysqli_query($conn,$query1);


if(!$result)
{
    // header('Location: ./../faculty/dashboard.php');
    // echo "Failed to insert".mysqli_error($conn);
    echo "      <script>
        alert('Failed to insert');
        window.location.href='./../faculty/dashboard.php';
        </script>";
}
else
{
    $tableec = "CREATE TABLE $course_code (student_id varchar(256) NOT NULL PRIMARY KEY)";

    if(!mysqli_query($conn,$tableec))
    {
        // header('Location: ./../faculty/dashboard.php');
        // echo "";
        echo "      <script>
        alert('Failed to create the course table');
        window.location.href='./../faculty/dashboard.php';
        </script>";
        $query1 = "DELETE FROM courses WHERE course_code='$course_code'";
        $result = mysqli_query($conn,$query1);
    }
        

    else 
    {
        $table_name = $course_code."_attendance";
        $tableca = "CREATE TABLE $table_name (attendance_date DATE NOT NULL, present  INT(6), absentees INT(6))";

        if(!mysqli_query($conn,$tableca))
        {
            // header('Location: ./../faculty/dashboard.php');
            // echo "";
            echo "      <script>
                alert('Failed to create course attendance table');
                window.location.href='./../faculty/dashboard.php';
                </script>";
            $query1 = "DROP TABLE '$course_code'";
            $result = mysqli_query($conn,$query1);
        }
        else
        {
            echo "      <script>
                alert('Course Added Succesfully');
                window.location.href='./../faculty/dashboard.php';
                </script>";
        }
    }
}

function prepared_query($mysqli, $sql, $params, $types = "")
{
    $types = $types ?: str_repeat("s", count($params));
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt;
}
?>