
<?php

class Batch_status_update {
 
    // database connection and table name
    private $conn;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
     $data = json_decode(file_get_contents('php://input'), true);

     $batch_no = $data['batch_no'];
     $reason = $data['reason'];
     $remarks = $data['remarks'];
     $batch_status = $data['batch_status'];

     $query = "UPDATE `tb_m_jobcard` SET batch_status = '$batch_status',batch_reason = '$reason',batch_remarks = '$remarks'where batch_no = '$batch_no'";
    
      
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    

    // execute query
    if ($stmt->execute()) { 
        return $stmt = 1;
     } else {
        return $stmt = 0;
     }
    
   
}
}