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

    }

?>