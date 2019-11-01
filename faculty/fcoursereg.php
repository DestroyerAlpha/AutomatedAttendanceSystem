<?php
session_start();
?>

<?php
require_once "./../sql_login/login.php";
$conn = mysqli_connect($hostname,$username,$password,$database);

if (!$conn)
{
    die('<p>Connection failed: <p>' . mysqli_connect_error());
}
$username = $_SESSION['username'];
$course_code = $_POST['ccode'];
$course_name = $_POST['cname'];

$query1 = 'INSERT INTO courses(course_code,course_name,faculty_id) VALUES(?,?,?)';
$query1 = prepared_query($conn, $query1, [$course_code,$course_name,$username]);

if(!$query1)
{
    // header('Location: ./../faculty/dashboard.php');
    echo "Failed to insert";
}
else
{
    $tableec = "CREATE TABLE $course_code (student_id varchar(256) NOT NULL PRIMARY KEY)";

    if(!mysqli_query($conn,$tableec))
    {
        // header('Location: ./../faculty/dashboard.php');
        echo "Failed to create the course table";
    }
        

    else 
    {
        $table_name = $course_code."_attendance";
        $tableca = "CREATE TABLE $table_name (attendance_date DATE NOT NULL, present  INT(6), absentees INT(6))";

        if(!mysqli_query($conn,$tableca))
        {
            // header('Location: ./../faculty/dashboard.php');
            echo "Failed to create course attendance table";
        }
        else
            echo "Course added successfully!";
            echo "<a href=\"./../faculty/dashboard.php\">Click here to go back</a>";
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