<?php 
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "farmers";

    $conn = new mysqli($host,$user,$password,$database);

    if($conn->connect_error){
        die("Connection error while connnecting to database : " . $conn->connect_error);
    }
?>