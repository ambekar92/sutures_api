
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
 
        
    // select all query
    $query = "SELECT mach_code,mach_desc FROM tb_m_machine";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
