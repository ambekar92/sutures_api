
<?php

class Oee_dashboard_workcenter{
 
    // database connection and table name
    private $conn;

 


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
 function read(){
             $data = json_decode(file_get_contents('php://input'), true);

            $wrk_ctr_code = $data['wrk_ctr_code'];
            $date = $data['date'];
        
    
             $query = "SELECT tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,tb_m_machine.mach_code,tb_m_machine.mach_desc,availability_perc,performance_perc,quality_perc,oee_perc FROM `tb_t_oee`
           join tb_o_workcenter on tb_t_oee.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code 
           join tb_m_machine on tb_m_machine.mach_code = tb_t_oee.mach_code WHERE date_ = '$date' AND tb_t_oee.wrk_ctr_code = '$wrk_ctr_code'";
        
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    
    return $stmt;
 }


 function read1(){
    $data = json_decode(file_get_contents('php://input'), true);

    $date = $data['date'];
    $wrk_ctr_code = $data['wrk_ctr_code'];

    $query1 = "SELECT ifnull(AVG(nullif(availability_perc,0)),0)as availability_perc ,ifnull(AVG(nullif(performance_perc,0)),0) as performance_perc,ifnull(avg(nullif(quality_perc,0)),0)as quality_perc,ifnull(avg(nullif(oee_perc,0)),0) as oee_perc  FROM `tb_t_oee`
    WHERE date_ = '$date' AND tb_t_oee.wrk_ctr_code = '$wrk_ctr_code' GROUP BY wrk_ctr_code";

    // prepare query statement
     $stmt1 = $this->conn->prepare($query1);

    // execute query

    $stmt1->execute();


    return $stmt1;
     }


}
