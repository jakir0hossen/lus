<?php
    $conx = mysqli_connect("localhost","root","","users");
    if(!$conx){
        echo 'Connection Failed';
    }
