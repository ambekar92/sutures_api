
<?php
include_once '../Config/database.php';

class jobcard_rejec_reas{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // object properties
    public $Jobcard;    
    public $Size;        
	public $Department_code; 
	public $Department;      
	public $Operator;        
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
    $query = "SELECT tb_t_prod_i.batch_no,tb_m_jobcard.fg_code,tb_t_prod_i.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,tb_t_prod_i.mach_code,tb_m_machine.mach_desc, tb_m_qlty_code.qlty_code_desc,tb_t_prod_i.qty 
     FROM tb_m_qlty_code 
    INNER JOIN tb_t_prod_i on tb_t_prod_i.qlty_code = tb_m_qlty_code.qlty_code 
    INNER JOIN  tb_o_workcenter on tb_t_prod_i.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code 
    INNER JOIN  tb_m_machine on tb_t_prod_i.mach_code = tb_m_machine.mach_code 
    INNER JOIN tb_m_jobcard on tb_t_prod_i.batch_no = tb_m_jobcard.batch_no
    where tb_t_prod_i.batch_no = '$batch_no' and tb_m_qlty_code.qlty_type_code = '502'
    order by tb_t_prod_i.updated_at ";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
