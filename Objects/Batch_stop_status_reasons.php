
<?php

class Batch_stop_status_reasons{
 
     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        
    // select all query
 $query = "SELECT prod_reas_code,prod_reas_descp FROM `tb_m_prod_reason` where prod_resn_type_code = 2";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
