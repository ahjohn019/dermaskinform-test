<?php 
    //test server
    $conn = new mysqli('remotemysql.com','z3UPYAictr','5zZxKj7wNZ','z3UPYAictr') or die("Unable To Connect");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT * FROM dermaform_dev";
    $result = mysqli_query($conn, $sql);

    // Fetch all
    

    $row = mysqli_fetch_all( $result,MYSQLI_ASSOC);
    print_r($row[0]);


    
    $conn -> close();

?>