<?php
    require_once '../sql_login/login.php';
    $conn = mysqli_connect($hostname,$username,$password);
    
    if(!$conn)
        die("Connection failed : ".mysqli_connect_error());

    try{
        $drop_query = "DROP DATABASE {$database}";
        $res = mysqli_query($conn,$drop_query);
    }
    catch (Exception $exception){
        echo "The given database doens't exist. <br/>";
    }
    finally{
        $db_create = "CREATE DATABASE {$database}";
        if(!mysqli_query($conn,$db_create))
        echo "      <script>
        alert('There is some error!');
        </script>";

        mysqli_close($conn);

        $conn = mysqli_connect($hostname,$username,$password,$database);
        

        $tables = "CREATE TABLE student_info (username varchar(10) NOT NULL PRIMARY KEY, password varchar (15) NOT NULL)";

        if(!mysqli_query($conn,$tables))
            echo "      <script>
            alert('There is some error!');
            </script>";

        $tablea = "CREATE TABLE admin_info (username varchar(10) NOT NULL PRIMARY KEY, password varchar (15) NOT NULL)";

        if(!mysqli_query($conn,$tablea))
            echo "      <script>
            alert('There is some error!');
            </script>";
        $tablef = "CREATE TABLE faculty_info (username varchar(10) NOT NULL PRIMARY KEY, password varchar (15) NOT NULL, name varchar(256) NOT NULL)";

        if(!mysqli_query($conn,$tablef))
            echo "      <script>
            alert('There is some error!');
            </script>";
        
        $tableac = "CREATE TABLE courses (course_code varchar(10) NOT NULL PRIMARY KEY, course_name varchar(30) NOT NULL, faculty_id varchar (20) NOT NULL, no_of_students int(6) DEFAULT 0, batch year(4) NOT NULL, branch varchar(10) NOT NULL)";

        if(!mysqli_query($conn,$tableac))
            echo "      <script>
            alert('There is some error!');
            </script>";

        $tableac = "CREATE TABLE students (username varchar(10) NOT NULL PRIMARY KEY, name varchar(20) NOT NULL, dob date NOT NULL, no_of_courses int(6) DEFAULT 0, branch varchar(10) NOT NULL, batch year(4) NOT NULL)";

        if(!mysqli_query($conn,$tableac))
            echo "      <script>
            alert('There is some error!');
            </script>";
       
        $admindata = "INSERT INTO admin_info VALUES(\"\admin\",\"admin\")";
        if(!mysqli_query($conn,$admindata))
            echo "      <script>
            alert('There is some error!');
            </script>";
        
        echo "      <script>
        alert('Successfully Created the Automated Files. Login on admin using details admin:admin');
        window.location.href='./../hoome/home.html';
        </script>";
    }

?>