
<?php

class Workcenter_list{
 
    // database connection and table name
    private $conn;
 

     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        
    // select all query
    $query = "SELECT wrk_ctr_code,wrk_ctr_desc FROM tb_o_workcenter";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
