
<?php

class Plan_list{
 
     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        
    // select all query
    $query = "SELECT plan_code,plan_desc FROM `tb_m_plan_type`";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
