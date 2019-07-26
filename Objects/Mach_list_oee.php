
<?php

class mach_list{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_m_machine";
 
    // object properties
    public $Machine_code;
    public $Machine_desc;
    

     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){

        $data = json_decode(file_get_contents('php://input'), true);

        $wrk_ctr_code = $data['wrk_ctr_code'];
        
    // select all query
    $query = "SELECT mach_code,mach_desc FROM tb_m_machine where wrk_ctr_code = '$wrk_ctr_code' ";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
