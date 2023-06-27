<?php

include_once "../config/Database.php";
include_once "../classes/Student.php";


//database object
$db = new Database();

$connection = $db->connect();


//student obj
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $student->name = "muhammad";
    $student->email = "ade@gmail.com";
    $student->mobile = "09031389842";

    if ($student->create_data()) {
       echo "student created successfully";
    }else {
        echo "failed to insert student";
    }
}else {
    
}


