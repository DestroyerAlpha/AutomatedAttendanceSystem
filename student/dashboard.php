<?php
session_start();
if($_SESSION['login'] !== 'TRUE')
{
    echo "      <script>
                alert('Not Allowed to View this!');
                window.location.href='./../home/home.html';
                </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Automated Attendance System</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="./../home/css/stylesheet.css" media="screen">
        <script>
		function goBack(){
		   alert("You have already register.");
		}
	    </script>

    </head>

    <body>
        <header>
            <div class="site_name">
                <h1>Student Dashboard</h1>
            </div>
        </header>
            <br>
            <a href="./../student/logout.php"><button class="submit-button" style="float: right;">Log Out</button></a>
        <div class="sline"></div>
        <section class="outer-section">
            <aside class="left-pane">
                <h1>Students Detail </h1>
                    <form action="./../student/studentattendance.php" method="post">
                        <ul>
                            <li><input type="submit" class="submit-button" name="in" value="View Attendance" /></li>
                        </ul>
                    </form>
            </aside>
            <aside class="right-pane">
                <br>
                <h1>Course Register</h1>
                                <?php 
                                    require_once './../sql_login/login.php';
                                    $conn = new mysqli($hostname, $username, $password, $database);
                                    if ($conn->connect_error) die("Fatal Error");
                                    if (isset($_POST['register']) && isset($_POST['c_code']) && isset($_POST['c_name']))
                                    {
                                        $course_code   = get_post($conn, 'c_code');
                                        $course_name   = get_post($conn, 'c_name');
                                        $username = $_SESSION['stuser'];
                                        $usernamem = $_SESSION['stuser']."m";
                                        $usernamep = $_SESSION['stuser']."present";
                                        $usernamea = $_SESSION['stuser']."absent";
                                        // $username = "180010030";
                                        $k=0;
                                        $query  = "SELECT * FROM $course_code";
                                        $result = $conn->query($query);
                                        if (!$result) die ("c_code access failed");

                                        $rows = $result->num_rows;
                                        for ($j = 0 ; $j < $rows ; ++$j)
                                        {
                                            $row = $result->fetch_array(MYSQLI_NUM);
                                            $r0 = htmlspecialchars($row[0]);

                                            if($r0 === $username){
                                                $k=1;
                                            }
                                        }

                                        if($k==1){
                                            echo "<script>goBack();</script>";
                                        }
                                        else{
                                            $query    = "INSERT INTO $course_code VALUES ('$username')";
                                            $result   = $conn->query($query);
                                            if (!$result) die ("Insert cc failed<br><br>");

                                            $stbranch = $_SESSION['stbranch'];
                                            $stbatch = $_SESSION['stbatch'];
                                            $query    = "INSERT INTO $usernamem VALUES ('$course_code','$course_name',0,0)";
                                            $result   = $conn->query($query);
                                            if (!$result) die ("Insert m failed<br><br>");

                                            // $query    = "INSERT INTO $usernamep VALUES ('$course_code','')";
                                            // $result   = $conn->query($query);
                                            // if (!$result) die ("Insert pr failed<br><br>");

                                            // $query    = "INSERT INTO $usernamea VALUES ('$course_code','')";
                                            // $result   = $conn->query($query);
                                            // if (!$result) die ("Insert ab failed<br><br>");

                                            $query  = "SELECT * FROM students";
                                            $result = $conn->query($query);
                                            if (!$result) die ("students access failed");

                                            $rows = $result->num_rows;
                                            for ($j = 0 ; $j < $rows ; ++$j)
                                            {
                                                $row = $result->fetch_array(MYSQLI_NUM);
                                                $r0 = htmlspecialchars($row[0]);
                                                $r1 = htmlspecialchars($row[1]);
                                                $r2 = htmlspecialchars($row[2]);
                                                $r3 = htmlspecialchars($row[3]);

                                                if($r0 === $username){
                                                    $no_of_courses = $r3+1;
                                                    $query  = "UPDATE students SET no_of_courses=$no_of_courses WHERE username='$username'";  
                                                    $result = $conn->query($query); 
                                                    if (!$result) die ("Update in Students failed<br><br>");
                                                }
                                            }
                                          
                                            $query  = "SELECT * FROM courses";
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

                                                if($r0 === $course_code){
                                                    $no_of_students = $r3+1;
                                                    $query  = "UPDATE courses SET no_of_students=$no_of_students WHERE course_code='$course_code'";  
                                                    $result = $conn->query($query); 
                                                    if (!$result) die ("Update in Courses failed<br><br>");
                                                }
                                            }
                                        }
                                    }


                                    $i = 0;
                                    $query  = "SELECT * FROM courses";
                                    $result = $conn->query($query);
                                    if (!$result) die ("courses access failed");
                                    
                                    $rows = $result->num_rows;
                                    for ($j = 0 ; $j < $rows ; ++$j)
                                    {
                                    $row = $result->fetch_array(MYSQLI_NUM);
                                    $r0 = htmlspecialchars($row[0]);
                                    $r1 = htmlspecialchars($row[1]);
                                    $r2 = htmlspecialchars($row[2]);
                                    $r3 = htmlspecialchars($row[5]);
                                    $r4 = htmlspecialchars($row[4]);
                                    // echo $r3." ".$r4;
                                    // echo $_SESSION['stbranch']." ".$_SESSION['stbatch'];
                                    if($_SESSION['stbranch']==$r3 && $_SESSION['stbatch']==$r4){
                                        $i=1;
                                        echo <<<_END
                                        <pre>
                                        Course_code $r0
                                        Course_name $r1
                                        Faculty_id $r2
                                        </pre>
                                        <form action='./../student/dashboard.php' method='post'>
                                        <input type='hidden' name='register' value='yes'>
                                        <input type='hidden' name='c_code' value='$r0'>
                                        <input type='hidden' name='c_name' value='$r1'>
                                        <input type='submit' value='Register'></form>
_END;
}
}
                                    if($i==0){
                                        echo "No More Courses to Register!";
                                    }
                                    $result->close() ;
                                    $conn->close() ;
                                    function get_post($conn, $var)
                                    {
                                    return $conn->real_escape_string($_POST[$var]);
                                    }
                                ?>
            </aside>
        </section>
        <footer>
            <p>
                <?php 
                $user = $_SESSION['stname'];
                echo "Welcome ".$user; 
                ?>
            </p>
        </footer>
    </body>
</html>