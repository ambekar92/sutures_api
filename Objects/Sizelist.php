
<?php

class Size_list{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_m_fg";
 
    // object properties
    public $Size;
    

     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        
    // select all query
    $query = "SELECT fg_code FROM tb_m_fg";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
