
<?php

class Customer_list{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_m_customer";
 
    // object properties
    public $Customer_list;
    

     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        
    // select all query
    $query = "SELECT cust_name FROM tb_m_customer";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
