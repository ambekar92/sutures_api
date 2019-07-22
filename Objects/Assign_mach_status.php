
<?php

class Assign_mach_status {
 
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

     $machine_code = $data['machine_code'];

        $query = "UPDATE tb_t_mach_status_event SET  on_off_status = IF((SELECT COUNT(*)as cnt FROM `tb_t_mach_check_h` where machine_code = '$machine_code' and release_for_production = 'NO') > 0 , 0, 1) 
        WHERE mach_code = '$machine_code'";
    
    
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
