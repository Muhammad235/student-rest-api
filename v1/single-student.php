<?php

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once "../config/Database.php";
include_once "../classes/Student.php";

//database object
$db = new Database();

$connection = $db->connect();


//student obj
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD']  === "GET") {

    $data = $student->get_single_data();

    $student_id = isset($_GET['id']) ? intval($_GET['id']) : " ";

    if (!empty($student_id)) {

        $student->id = $student_id;

        $student_data =  $student->get_single_data();

        if(!empty($student_data)) {

            http_response_code(200); // Ok (success)

            echo json_encode(array(
                "status" => 200,
                "data" => $student_data
            ));
    
        }else{

            http_response_code(404); // data not found

            echo json_encode(array(
                "status" => 404,
                "message" => "Student not found"
            ));
            
        }
        
    }else{

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
        "message" => "Access denied, only GET methd is allowed"
    ));
}

