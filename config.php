<?php
    $conx = mysqli_connect("localhost","root","","users");
    if(!$conx){
        echo 'Connection Failed';
    } 
    
    ?>
    
    <?php

    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');    
    define('DB_NAME', 'users');
    
    
    $con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 

    
    
    if ($con->connect_error) {
     
        error_log("Connection failed: " . $con->connect_error, 3, '/var/log/php_errors.log'); // Adjust path as needed
        die("ERROR: Could not connect. Please check the error log for details.");
    }
    ?>
    