
<?php

class employee_pie{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // object properties
    public $Employee;
    public $Department;
    public $Ok_Qnty;

     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        $batch_no = $_GET['batch_no'];
        
    // select all query
    $query = "SELECT users.name,tb_o_workcenter.wrk_ctr_desc,
    IFNULL(SUM(CASE WHEN qlty_type_desc =  'OK' THEN tb_t_prod_i.qty END), 0)OK_Qnty 
    FROM 
    " . $this->table_name . " 
    JOIN tb_m_qlty_code on tb_t_prod_i.qlty_code = tb_m_qlty_code.qlty_code 
    join tb_m_qlty_type on tb_m_qlty_type.qlty_type_code = tb_m_qlty_code.qlty_type_code 
    join tb_t_prod_h on tb_t_prod_i.sl_no = tb_t_prod_h.sl_no 
    join users on users.emp_id = tb_t_prod_h.emp_id join tb_o_workcenter on tb_t_prod_i.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code  where tb_t_prod_i.batch_no = '$batch_no'  and tb_m_qlty_type.qlty_type_code in (500,501,502)GROUP by  tb_t_prod_h.emp_id,tb_t_prod_i.wrk_ctr_code ORDER BY tb_t_prod_i.wrk_ctr_code";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
