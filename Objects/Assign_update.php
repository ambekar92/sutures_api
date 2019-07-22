
<?php

class Assign_update {
 
    // database connection and table name
    private $conn;
    ///private $table_name = "tb_t_prod_i";


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
     $data = json_decode(file_get_contents('php://input'), true);

     $ticket = $data['ticket'];
     $machine_check_h_code = $data['machine_check_h_code'];
     $assigned_by = $data['assigned_by'];
     $assigned_me = $data['assigned_me'];
     $assigned_date = $data['assigned_date'];
     $assigned_remarks = $data['assigned_remarks'];
     $assigned_status = $data['assigned_status'];
     $release_for_production = $data['release_for_production'];
     $machine_code = $data['mach_code'];

     if($assigned_me == 1){
        $query = "update `tb_t_mach_check_h` set assigned_by = '$assigned_by',assigned_date = '$assigned_date',assigned_remarks='$assigned_remarks',assigned_status='$assigned_status',release_for_production = '$release_for_production' where ticket = '$ticket' and machine_check_h_code = '$machine_check_h_code'";
     }else{
        $query = "update `tb_t_mach_check_h` set assigned_by = '$assigned_by',assigned_me = '$assigned_me',assigned_date = '$assigned_date',assigned_remarks='$assigned_remarks',assigned_status='$assigned_status',release_for_production = '$release_for_production' where ticket = '$ticket' and machine_check_h_code = '$machine_check_h_code'";
     }
    
    
      $query1 = "UPDATE tb_t_mach_status_event SET  on_off_status = IF((SELECT COUNT(*)as cnt FROM `tb_t_mach_check_h` where machine_code = '$machine_code' and release_for_production = 'NO') > 0 , 0, 1) 
        WHERE mach_code = '$machine_code'";

    // prepare query statement
    $stmt = $this->conn->prepare($query);
    $stmt1 = $this->conn->prepare($query1);
  
    
    // execute query
    if ($stmt->execute() && $stmt1->execute() ) { 
        return $stmt = 1;
     } else {
        return $stmt = 0;
     }
    
   
}
 
}
