<?php

class Student
{
    public $name;
    public $email;
    public $mobile;

    private $conn;
    private $table_name;

    //constructor
    public function __construct($db) {
        $this->conn = $db;
        $this->table_name = "student";
    }

    public function create_data(){
        //insert data

        $query = "INSERT INTO ". $this->table_name . " SET name = ?, email = ?, mobile = ?";

        //prepare query
        $obj = $this->conn->prepare($query);

        //sanitize input 
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));

        //binding parameter
        $obj->bind_param("ssi", $this->name, $this->email, $this->mobile);

        if ($obj->execute()) {
           return true;
        }else {
            return false;
        }
    }


}
