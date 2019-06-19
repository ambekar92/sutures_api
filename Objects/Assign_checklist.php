
<?php



class Assign_checklist {
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
    $data = json_decode(file_get_contents('php://input'), true);

         $ticket = $data['ticket'];
         $machine_check_h_code = $data['machine_check_h_code'];
         $astatus = $data['aStatus'];


     //before assigning 
     if($astatus == 0){
          $query = "SELECT ticket,machine_check_h_code,checklist_desc,assigned_by,assigned_me,assigned_remarks,released_remarks,tb_t_mach_check_h.machine_code FROM `tb_t_mach_check_h` where ticket = '$ticket' and machine_check_h_code = '$machine_check_h_code' ";
   // after assigning 
     }elseif($astatus == 1){
          $query = " SELECT ticket,machine_check_h_code,checklist_desc,U1.name as assigned_by,U2.name as assigned_me,assigned_remarks,released_remarks,tb_t_mach_check_h.machine_code FROM `tb_t_mach_check_h` join users U1 on U1.emp_id = tb_t_mach_check_h.assigned_by 
        join users U2 on U2.emp_id = tb_t_mach_check_h.assigned_me  where ticket = '$ticket' and machine_check_h_code = '$machine_check_h_code'";
     }else{
         //if it is closed
    $query = "SELECT ticket,machine_check_h_code,checklist_desc,U1.name as assigned_by,U2.name as assigned_me,assigned_remarks,released_remarks,tb_t_mach_check_h.machine_code FROM `tb_t_mach_check_h` 
           join users U1 on U1.emp_id = tb_t_mach_check_h.assigned_by
           left join users U2 on U2.emp_id = tb_t_mach_check_h.assigned_me 
        where ticket = '$ticket' and machine_check_h_code = '$machine_check_h_code'";
     }

    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
    return $stmt;
   
}
        function read1(){
            $data = json_decode(file_get_contents('php://input'), true);
            $machine_check_h_code = $data['machine_check_h_code'];

         $query1 = "SELECT breakdown_desc FROM `tb_t_mach_check_i` where machine_check_h_code = '$machine_check_h_code'";
    
        // prepare query statement
        $stmt1 = $this->conn->prepare($query1);
        
        // execute query
      
        $stmt1->execute();
        

        return $stmt1;
            }

        function read2(){
            
            include_once '../environment_variables/environment_variables.php';

        $query2 = "SELECT emp_id,role_code,frst_name FROM `tb_m_employee` where role_code = '$role_code'";
        
        // prepare query statement
        $stmt2 = $this->conn->prepare($query2);
            
        // execute query
        $stmt2->execute();
            
    
            return $stmt2;
                }
     

}
