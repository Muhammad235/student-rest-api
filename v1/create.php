<?php

//headers
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once "../config/Database.php";
include_once "../classes/Student.php";

//database object
$db = new Database();

$connection = $db->connect();

//student obj
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->name) && !empty($data->email) && !empty($data->mobile)) {

        $student->name = $data->name;
        $student->email = $data->email;
        $student->mobile =  $data->mobile;

        if ($student->create_data()) {

            http_response_code(201); //OK

            echo json_encode(array(
                "status" => 1,
                "message" => "Student created successfully"
            ));

         }else {
            http_response_code(500); //internal server error

            echo json_encode(array(
                "status" => 0,
                "message" => "Failed to create student"
            ));
            
         }
    }else {
        http_response_code(400); //bad request

        echo json_encode(array(
            "status" => 0,
            "message" => "Provide all parameters"
        ));
    }
    
}else {
    http_response_code(405); // method not allowed

    echo json_encode(array(
        "status" => 0,
        "message" => "Access denied, only POST methd is allowed"
    ));
}