<?php
session_start();
// echo $_SESSION['login'];
if($_SESSION['login'] !== TRUE)
{
    echo "      <script>
                alert('Not Allowed to View this!');
                window.location.href='./../home/home.html';
                </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css" media="screen">
</head>
<body>
	<header>
            <div class="site_name">
                <h1>Attendance Management System</h1>
            </div>
    </header>
     <div class="sline"></div>
    <div class="sline"></div>
    <section class="outer-section">
        <aside class="left-pane">
            <h1>Admin Dashboard</h1>
            <h2>Student's Attendance</h2>
            <ul>
                <div class="onestudent">
                    <h3>Check for one student</h3>
                    <form name="onestudent" action="onestudent.php" method="get">
                        <li><input type="text" name="stuinfo" placeholder="Search by userID"></li><br>
                        <li><input type="submit" name="submit" value="Search" class="submit-button"></li><br>
                    </form>
                </div>
                
                <li><button onclick="window.location.href='defaulter.php'" class="submit-button">Defaulter List</button></li><br><br>
                
                <div class="onestudent">
                    <h3>Attendance Data for a particular course</h3>
                    <form name="course" action="onecourse.php" method="get">
                        <li><input type="text" name="course" placeholder="Search by course-code"></li><br>
                        <li><input type="submit" name="searchpartcour" value="Search" class="submit-button"></li><br>
                    </form>
                </div>

            </ul>
        </aside>
        <ul>    
    		<li><button onclick="window.location.href='newstudent.html'" class="submit-button">Add a new student</button>
    		<br><br><br><br><br></li>
    		<li><button onclick="window.location.href='newfaculty.html'" class="submit-button">Add a new faculty</button><br><br><br><br></li>
            <li><a href="./../admin/logout.php"><button class="submit-button">Log Out</button></a></li>
    	</ul>
    </section>
    <footer>
        <p>Attendance Management System</p>
    </footer>
</body>
</html>