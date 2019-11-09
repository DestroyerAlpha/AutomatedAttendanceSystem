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
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Automated Attendance System</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css" media="screen">
    </head>

    <body>
        <header>
            <div class="site_name">
                <h1>Faculty Dashboard</h1>
            </div>
        </header>
        <nav>
            <a href="./../home/home.html"><input type="submit" value="Logout"></a>
        </nav>
        <div class="sline"></div>
    <div class="sline"></div>
    <section class="outer-section">
        <aside class="left-pane">
            <h1>Courses Floated</h1>
                <form action="./../faculty/studentdetails.php" method="post">
                <ul>
                <?php
                    $query = "SELECT * FROM courses";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                    {
                        if ($faculty_id == $row['faculty_id'])
                        {
                            $course_code = $row['course_code'];
                            echo "<li><input name=\"course\" type=\"radio\" value=$course_code>&emsp;".$row['course_name']."</li><br>";
                        } 
                    }
                ?>
                </ul>
                    <ul>
                        <li><input type="submit" class="submit-button" name="in" value="View/Attendance" /></li><br>
                        <li><input type="submit" class="submit-button" name="in" value="Delete Course" onclick="return confirm('Are you sure?');" /></li>
                    </ul>
                </form>
        </aside>
        <section class="middle-pane">
            <h1>Add Attendance</h1>
            <h3>Select Course:-</h3>
            <form action="./../faculty/attendance.php" method="post">
                <ul>
                <?php
                    $query = "SELECT * FROM courses";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                    {
                        if ($faculty_id == $row['faculty_id'])
                        {
                            $course_code = $row['course_code'];
                            echo "<li><input name=\"course\" type=\"radio\" value=$course_code>&emsp;".$row['course_name']."</li><br>";
                        }
                    }
                ?>
                </ul>
                    <ul>
                        <li><input type="submit" class="submit-button" name="in" value="Add Attendance" /></li>
                    </ul>
            </form>
		</section>
        <aside class="right-pane">
            <h1>Course Register</h1>
                <form action="./../faculty/fcoursereg.php" method="post">
                    <ul>
                        <li>Course Name:- <input class="text-fields" type="text" name="cname" placeholder="Course Name" required/> </li>
                        <li>Course Code:- <input class="text-fields" type="text" name="ccode" placeholder="Course Code" required/></li>
                        <li>Course Batch:- <input class="text-fields" type="text" name="cbatch" placeholder="Course Batch" required/></li>
                        <li>Course Branch:- <input class="text-fields" type="text" name="cbranch" placeholder="Course Branch" required/></li>

                        <li><input type="submit" class="submit-button" name="in" value="Register" /></li>
                    </ul>
                </form>
        </aside>
    </section>
    <footer>
        <p>Faculty: <?php echo $_SESSION['username']; ?></p>
    </footer>
</body>
</html>
