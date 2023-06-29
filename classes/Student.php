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
        $prepare = $this->conn->prepare($query);

        //sanitize input 
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));

        //binding parameter
        $prepare->bind_param("ssi", $this->name, $this->email, $this->mobile);

        if ($prepare->execute()) {
           return true;
        }else {
            return false;
        }
    }

    public function get_all_data(){
        //ge6 data
        $query = "SELECT * FROM ". $this->table_name ." ";

        //prepare query
        $prepare = $this->conn->prepare($query);

        $prepare->execute();

        return $prepare->get_result();   
    }

    public function get_single_data(){
        //ge6 data
        $query = "SELECT * FROM ". $this->table_name ." WHERE id = ?";

        //prepare query
        $prepare = $this->conn->prepare($query);

        $prepare->bind_param("i", $this->id);
        $prepare->execute();

        $result = $prepare->get_result();

        return $result->fetch_assoc();   
    }

}
