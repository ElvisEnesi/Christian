<?php
    // Database configuration
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'christian';
    // Create connection
    $conn = new mysqli($server, $username, $password, $database);
    // Check connection
    if (mysqli_error($conn)) {
        die("Connection failed: " . mysqli_error($conn));
    } else {
        //echo "Connected successfully";
    }
