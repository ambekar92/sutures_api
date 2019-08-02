
<?php

class Reasons_report{
 
    // database connection and table name
    private $conn;
   
 
  

     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){

        // $data = json_decode(file_get_contents('php://input'), true);

        $date = $_GET['date'];
        
    // select all query
    $query = "SELECT date_,tb_o_workcenter.wrk_ctr_desc,tb_m_prod_reason.prod_reas_descp,start_time,end_time,remarks FROM `tb_t_reason_entry` 
    join tb_m_prod_reason on tb_t_reason_entry.reason_code = tb_m_prod_reason.prod_reas_code
    join tb_o_workcenter on tb_o_workcenter.wrk_ctr_code = tb_t_reason_entry.wrk_ctr_code
    where date_ = ' $date'";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
