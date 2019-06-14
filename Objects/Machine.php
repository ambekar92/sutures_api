
<?php

class Machine{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // object properties
    public $Mach_desc;
    public $Ok_Qnty;
    public $Reject_Qnty;
    public $Rework_Qnty;
    
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        $batch_no = $_GET['batch_no'];
        
    // select all query
    $query = "SELECT  tb_m_machine.mach_desc, 
    IFNULL(SUM(CASE WHEN qlty_type_desc =  'OK' THEN tb_t_prod_i.qty END), 0)OK_Qnty, 
    IFNULL(SUM(CASE WHEN qlty_type_desc =  'REJECT' THEN tb_t_prod_i.qty END), 0) Reject_Qnty,
    IFNULL(SUM(CASE WHEN qlty_type_desc =  'REWORK' THEN tb_t_prod_i.qty END), 0) Rework_Qnty 
    FROM
    " . $this->table_name . "
    JOIN tb_m_qlty_code on tb_t_prod_i.qlty_code = tb_m_qlty_code.qlty_code 
    JOIN tb_m_qlty_type on tb_m_qlty_type.qlty_type_code = tb_m_qlty_code.qlty_type_code 
    JOIN tb_m_machine on tb_t_prod_i.mach_code = tb_m_machine.mach_code  
    where tb_t_prod_i.batch_no = '$batch_no' and tb_m_qlty_type.qlty_type_code in (500,501,502) group by tb_m_machine.mach_desc,tb_t_prod_i.mach_code 
	ORDER by tb_t_prod_i.updated_at";
 
 //echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
