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
		function goBack() {
            window.location.href="./../student/dashboard.php";
		}
	    </script>
    </head>

    <body>
        <header>
            <div class="site_name">
                <h1>Attendance </h1>
            </div>
        </header>

        <div class="sline"></div>
    <div class="sline"></div>
    <section class="outer-section">
        <section class="middle-pane">
        <h1>To Register</h1>
                <button class="submit-button" type="button" onclick="goBack();">Go Back</button>
        </section>
        <aside class="right-pane">
                <h1>Courses Attendance</h1>
                 <?php 
                    require_once './../sql_login/login.php';
                    $conn = new mysqli($hostname, $username, $password, $database);
                    if ($conn->connect_error) die("Fatal Error");
                    echo $_SESSION['stuser'];
                    $user_t = $_SESSION['stuser']."m";
                    $query  = "SELECT * FROM $user_t";
                    $result = $conn->query($query);
                    if (!$result) die ("Roll_No. access failed");
                                
                    $rows = $result->num_rows;
                    for ($j = 0 ; $j < $rows ; ++$j)
                    {
                        $row = $result->fetch_array(MYSQLI_NUM);
                        $r0 = htmlspecialchars($row[0]);
                        $r1 = htmlspecialchars($row[1]);
                        $r2 = htmlspecialchars($row[2]);
                        $r3 = htmlspecialchars($row[3]);
                        $per = ($r2)/($r2+$r3)*100;
                        echo <<<_END
                    <pre>
                        Course_code $r0
                        Course_name $r1
                        Present Days $r2
                        Absent Days $r3
                        Present percentage $per%
                    </pre>
                    <form action="./../student/studentattendance1.php" method="post">
                    <input type='hidden' name='view' value='yes'>
                    <input type='hidden' name='c_code' value='$r0'>
                    <input type='submit' value='View Dates'></form><br><br><br>
_END;
                    }
                    $result->close();
                    $conn->close();
                    function get_post($conn, $var)
                    {
                      return $conn->real_escape_string($_POST[$var]);
                    }
                ?>
        </aside>
    </section>
    <footer>
        <p><?php echo "Welcome ".$_SESSION["stname"]; ?></p>
    </footer>
</body>
</html>

