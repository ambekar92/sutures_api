
<?php

class Addemployee {
 
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

    $password =  '$2y$10$uYiX.9f.ZvYK7M7sLvRvJOmmKfxwajiWeO./NZKz9rtGTXcv2jNqi';

     $emp_id = $data['emp_id'];
     $emp_name = $data['emp_name'];
     $emp_role = $data['emp_role'];
     $emp_desg = $data['emp_desg'];
     $emp_email = $data['emp_email'];
     $emp_no = $data['emp_no'];
    
     if(is_int($emp_no) == false ){
        $emp_c_no = 0;
     }else{
        $emp_c_no = $emp_no;
     }

     
    
    $query = "CALL sp_insert_emp('$emp_id','$emp_name','$emp_role','$emp_desg','$emp_email','$emp_c_no','$password');";
 

        $stmt = $this->conn->prepare($query);

        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute();
            return 1;
        }catch (PDOException $exception) {
            
            if ($exception->errorInfo[1] == 1062) {
                return 'Entry is already present for Employee ID which you are trying to add';
             } else {
                return 'Erorr Accured While adding User';
                // return  $exception->getMessage();
             }
        }
    
  
}

}
