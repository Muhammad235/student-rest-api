<?php

//headers
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/Database.php";
include_once "../classes/Student.php";

//database object
$db = new Database();

$connection = $db->connect();


//student obj
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD']  === "GET") {

    $data = $student->get_all_data();

    if ($data->num_rows > 0) {

        $students["records"] = array();
        while ($row  = $data->fetch_assoc()) {

            array_push($students["records"], array(

                "id" => $row['id'],
                "name" => $row['name'],
                "mobile" => $row['mobile'],
                "status" => $row['status'],
                "created_at" => date("Y-m-d", strtotime($row['created_at']))

            ));
        } 

        http_response_code(200); // Ok (success)

        echo json_encode(array(
            "status" => 200,
            "data" => $students['records']
        ));

    }


}else {

    http_response_code(405); // method not allowed

    echo json_encode(array(
        "status" => 0,
        "message" => "Access denied, only GET methd is allowed"
    ));
}

