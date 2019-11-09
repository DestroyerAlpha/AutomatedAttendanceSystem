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
		function goBack() {
            window.location.href="./../student/studentattendance.php";
        }
        function goBack1() {
            alert("Your attendance has not been registered to this Course");
            window.location.href="./../student/studentattendance.php";
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
            <h1>Dates</h1>
                <?php 
                    require_once './../sql_login/login.php';
                    $conn = new mysqli($hostname, $username, $password, $database);
                    if ($conn->connect_error) die("Fatal Error");

                    if (isset($_POST['view']) && isset($_POST['c_code']))
                    {
                        $c_code = $_POST['c_code'];

                        $p = 0;
                        $k = 0;
                        $user_p = $_SESSION['stuser']."present";
                        $query  = "SELECT * FROM $user_p";
                        $result = $conn->query($query);
                        if (!$result) die ("Roll_present access failed");
                                    
                        
                        echo "<table border=1>";
                        echo "<tr><th>Present Date/s</th></tr>";
                        $rows = $result->num_rows;
                        for ($j = 0 ; $j < $rows ; ++$j)
                        {
                            $row = $result->fetch_array(MYSQLI_NUM);
                            $r0 = htmlspecialchars($row[0]);
                            $r1 = htmlspecialchars($row[1]);

                            if($r0 == $c_code){
                                $p=1;
                                echo "<tr>";
                                echo "<td>";
                                echo $r1;
                                echo "</td>";
                                echo "</tr>";
                            }
                        }

                        echo "</table> <br><br><br>";

                        $user_a = $_SESSION['stuser']."absent";
                        $query  = "SELECT * FROM $user_a";
                        $result = $conn->query($query);
                        if (!$result) die ("Roll_present access failed");
                                    
                        echo "<table border=1>";
                        echo "<tr><th>Absent Date/s</th></tr>";
                        $rows = $result->num_rows;
                        for ($j = 0 ; $j < $rows ; ++$j)
                        {
                            $row = $result->fetch_array(MYSQLI_NUM);
                            $r0 = htmlspecialchars($row[0]);
                            $r1 = htmlspecialchars($row[1]);

                            if($r0 == $c_code){
                                $k=1;
                                echo "<tr>";
                                echo "<td>";
                                echo $r1;
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        echo "</table>";

                        if($p==0 && $k==0){
                            echo "<script>goBack1();</script>";
                        }
                        $result->close();
                        $conn->close();
                        function get_post($conn, $var)
                        {
                        return $conn->real_escape_string($_POST[$var]);
                        }
                    }
                ?>
        </section>
        <aside class="right-pane">
            <h1> Back </h1>
            <button type="button" onclick="goBack();">Go Back</button>
        </aside>
    </section>
    <footer>
        <p><?php echo "Welcome".$_SESSION['stname']; ?></p>
    </footer>
</body>
</html>
