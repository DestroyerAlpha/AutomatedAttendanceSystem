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
        if(mysqli_query($conn,$db_create))
            echo "Database created.</br>";
        else 
            die("Error creating database.".mysqli_error($conn));

        mysqli_close($conn);

        $conn = mysqli_connect($hostname,$username,$password,$database);
        

        $tables = "CREATE TABLE student_info (username varchar(10) NOT NULL PRIMARY KEY, password varchar (15) NOT NULL)";

        if(mysqli_query($conn,$tables))
            echo "Successfuly created authentication table. </br>";
        else 
            die("Error while making authentication table.".mysqli_error($conn));
        
        $tablea = "CREATE TABLE admin_info (username varchar(10) NOT NULL PRIMARY KEY, password varchar (15) NOT NULL)";

        if(mysqli_query($conn,$tablea))
            echo "Successfuly created authentication table. </br>";
        else 
            die("Error while making authentication table.".mysqli_error($conn));
        
        $tablef = "CREATE TABLE faculty_info (username varchar(10) NOT NULL PRIMARY KEY, password varchar (15) NOT NULL)";

        if(mysqli_query($conn,$tablef))
            echo "Successfuly created authentication table. </br>";
        else 
            die("Error while making authentication table.".mysqli_error($conn));

        $tableas = "CREATE TABLE students (username varchar(10) NOT NULL PRIMARY KEY, name varchar (20) NOT NULL, dob date NOT NULL, no_of_courses int(6) DEFAULT 0)";

        if(mysqli_query($conn,$tableas))
            echo "Successfuly created authentication table. </br>";
        else 
            die("Error while making authentication table.".mysqli_error($conn));

        $tableac = "CREATE TABLE courses (course_code varchar(10) NOT NULL PRIMARY KEY, course_name varchar(30) NOT NULL, faculty_id varchar (20) NOT NULL, no_of_students int(6) DEFAULT 0)";

        if(mysqli_query($conn,$tableac))
            echo "Successfuly created authentication table. </br>";
        else 
            die("Error while making authentication table.".mysqli_error($conn));

    }

?>