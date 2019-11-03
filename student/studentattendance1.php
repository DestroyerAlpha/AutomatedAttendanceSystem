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
            alert("You have not register the Course");
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
                    echo <<<_END
                    <pre>
                        Present Dates
                    </pre>
_END;
                    }
                    $p = 0;
                    $k = 0;
                    $user_t = $_SESSION['stuser']."present";
                    $query  = "SELECT * FROM $user_t";
                    $result = $conn->query($query);
                    if (!$result) die ("Roll_present access failed");
                                
                    $rows = $result->num_rows;
                    for ($j = 0 ; $j < $rows ; ++$j)
                    {
                        $row = $result->fetch_array(MYSQLI_NUM);
                        $r0 = htmlspecialchars($row[0]);
                        $r1 = htmlspecialchars($row[1]);
                        if($r0 == $_POST['c_code']){
                            $p=1;
                            echo <<<_END
                            <pre>
                                $r1,
                            </pre>
_END;
                        }
                    }
                    echo <<<_END
                    <pre>
                        Absent Dates
                    </pre>
_END;
                    }
                    $user_t = $_SESSION['stuser']."absent";
                    $query  = "SELECT * FROM $user_t";
                    $result = $conn->query($query);
                    if (!$result) die ("Roll_present access failed");
                                
                    $rows = $result->num_rows;
                    for ($j = 0 ; $j < $rows ; ++$j)
                    {
                        $row = $result->fetch_array(MYSQLI_NUM);
                        $r0 = htmlspecialchars($row[0]);
                        $r1 = htmlspecialchars($row[1]);
                        if($r0 == $_POST['c_code']){
                            $k=1;
                            echo <<<_END
                            <pre>
                                $r1,
                            </pre>
_END;
                        }
                    }
                    if($p==0 && $k==0){
                        echo "<script>goBack1();</script>";
                    }
                    $result->close();
                    $conn->close();
                    function get_post($conn, $var)
                    {
                      return $conn->real_escape_string($_POST[$var]);
                    }
                ?>
        </section>
    </section>
    <footer>
        <p><?php echo "Welcome".$_SESSION['stuser']; ?></p>
    </footer>
</body>
</html>