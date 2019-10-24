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
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css" media="screen">
    </head>

    <body>
        <header>
            <div class="site_name">
                <h1>Faculty Dashboard</h1>
            </div>
        </header>

        <div class="sline"></div>
    <div class="sline"></div>
    <section class="outer-section">
        <aside class="left-pane">
            <h1>Students Detail </h1>
                <form action="./../authentication/studentdetails.php" method="post">
                    <ul>
                        <li><input type="submit" class="submit-button" name="in" value="View/Attendance" /></li>
                    </ul>
                </form>
        </aside>
        <aside class="right-pane">
            <h1>Course Register</h1>
                <form action="./../faculty/fcoursereg.php" method="post">
                    <ul>
                        <li>Course Name:- <input class="text-fields" type="text" name="cname" placeholder="Course Name" required/> </li>
                        <li>Course Code:- <input class="text-fields" type="text" name="ccode" placeholder="Course Code" required/></li>
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
