
<?php

class jobcard_list{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_m_jobcard";
 
    // object properties
    public $jobacard_list;
    

     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        
    // select all query
    $query = "SELECT batch_no FROM tb_m_jobcard";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
