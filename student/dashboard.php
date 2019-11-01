<?php
session_start();
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
                <h1>Course Register</h1>
                                <?php 
                                    require_once './../sql_login/login.php';
                                    $conn = new mysqli($hostname, $username, $password, $database);
                                    if ($conn->connect_error) die("Fatal Error");
                                    if (isset($_POST['register']) && isset($_POST['c_code']))
                                    {
                                        $course_code   = get_post($conn, 'c_code');
                                        $username = $_SESSION['stuser'];
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
                                            if (!$result) die ("Insert failed<br><br>");

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
                                                    $query  = "UPDATE students SET no_of_courses='$no_of_courses' WHERE username='$username'";  
                                                    $result = $conn->query($query); 
                                                    if (!$result) die ("Update in Students failed<br><br>");
                                                }
                                            }
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
                                    echo <<<_END
                                    <pre>
                                    Course_code $r0
                                    Course_name $r1
                                    Faculty_id $r2
                                    </pre>
                                    <form action='./../student/dashboard.php' method='post'>
                                    <input type='hidden' name='register' value='yes'>
                                    <input type='hidden' name='c_code' value='$r0'>
                                    <input type='submit' value='Register'></form>
_END;
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
                session_start();
                $user = $_SESSION['stuser'];
                echo "Welcome".$user; 
                ?>
            </p>
        </footer>
    </body>
</html>