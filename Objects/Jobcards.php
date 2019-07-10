
<?php

class Jobcard{
    
   
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // private $qlty_type_desc_ok;
    
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        include_once '../environment_variables/environment_variables.php';

        $batch_no = $_GET['batch_no'];
        
    // select all query
  $query = "SELECT
                tb_o_workcenter.wrk_ctr_desc, IFNULL(SUM(CASE WHEN qlty_type_desc = '$qlty_type_desc_ok' THEN tb_t_prod_i.qty END), 0) OK_Qnty, IFNULL(SUM(CASE WHEN qlty_type_desc =  '$qlty_type_desc_reject' THEN tb_t_prod_i.qty END), 0) Reject_Qnty,IFNULL(SUM(CASE WHEN qlty_type_desc =  '$qlty_type_desc_rework' THEN tb_t_prod_i.qty END), 0)Rework_Qnty 
            FROM
                " . $this->table_name . " 
                JOIN tb_m_qlty_code on tb_t_prod_i.qlty_code = tb_m_qlty_code.qlty_code 
                JOIN tb_m_qlty_type on tb_m_qlty_type.qlty_type_code = tb_m_qlty_code.qlty_type_code 
                JOIN tb_o_workcenter on tb_t_prod_i.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code where batch_no = '$batch_no' and tb_m_qlty_type.qlty_type_code in ('$qlty_type_code_ok','$qlty_type_code_reject','$qlty_type_code_rework') group by tb_t_prod_i.batch_no,tb_t_prod_i.wrk_ctr_code";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
    
        }
 

}
