
<?php

class jobcard_rejec{
 
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
    $query = "SELECT   tb_t_prod_i.batch_no,tb_m_jobcard.fg_code,tb_o_workcenter.wrk_ctr_code, tb_o_workcenter.wrk_ctr_desc,tb_m_employee.emp_id as team_lead_id,tb_m_employee.frst_name as team_lead,users.emp_id as operator_id,users.name as operator,
    IFNULL(SUM(CASE WHEN qlty_type_desc =  'OK' THEN tb_t_prod_i.qty END), 0) OK_Qnty, 
    IFNULL(SUM(CASE WHEN qlty_type_desc =  'REJECT' THEN tb_t_prod_i.qty END), 0) Reject_Qnty,
    IFNULL(SUM(CASE WHEN qlty_type_desc =  'REWORK' THEN tb_t_prod_i.qty END), 0)Rework_Qnty  
    FROM
    " . $this->table_name . " 
    JOIN tb_m_qlty_code on tb_t_prod_i.qlty_code = tb_m_qlty_code.qlty_code 
    JOIN tb_m_qlty_type on tb_m_qlty_type.qlty_type_code = tb_m_qlty_code.qlty_type_code 
    JOIN tb_o_workcenter on tb_t_prod_i.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code  
    JOIN tb_t_prod_h on tb_t_prod_i.sl_no = tb_t_prod_h.sl_no join users on tb_t_prod_h.emp_id = users.emp_id 
    JOIN tb_m_jobcard on tb_t_prod_i.batch_no = tb_m_jobcard.batch_no
    JOIN (select * from tb_t_job_card_trans where status_code = '802' and oper_status is null)A on A.batch_no = tb_t_prod_i.batch_no and A.present_dept = tb_t_prod_i.wrk_ctr_code
    JOIN tb_m_employee on tb_m_employee.emp_id = A.emp_id 
    where tb_t_prod_i.batch_no = '$batch_no' and tb_m_qlty_type.qlty_type_code in (500,501,502) group by tb_t_prod_i.wrk_ctr_code,users.name
    order by tb_t_prod_i.updated_at";
 
 //echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
