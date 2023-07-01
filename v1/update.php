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
    
    if (!empty($data->id) && !empty($data->name) && !empty($data->email) && !empty($data->mobile)) {

        $student->id = $data->id;
        $student->name = $data->name;
        $student->email = $data->email;
        $student->mobile =  $data->mobile;

        if ($student->update_student()) {

            http_response_code(200); // OK

            echo json_encode(array(
                "status" => 200,
                "message" => "Student updated successfully"
            ));
            
        }else {
            http_response_code(500); //internal server error

            echo json_encode(array(
                "status" => 500,
                "message" => "Failed to create student"
            ));    
        }

    }else {
        
        http_response_code(400); //bad request

        echo json_encode(array(
            "status" => 400,
            "message" => "Provide all parameters"
        ));
    }

}else {
    http_response_code(405); // method not allowed

    echo json_encode(array(
        "status" => 405,
        "message" => "Access denied, only POST methd is allowed"
    ));
}