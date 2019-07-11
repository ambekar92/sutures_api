
<?php

class Oee_dashboard_plant{
 
    // database connection and table name
    private $conn;

 


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
 function read(){
             $data = json_decode(file_get_contents('php://input'), true);


            $date = $data['date'];
    
             $query = "SELECT tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,ifnull(AVG(NULLIF(availability_perc ,0)),0) as availability_perc,ifnull(AVG(NULLIF(performance_perc ,0)),0) as performance_perc,ifnull(AVG(NULLIF(quality_perc ,0)),0) as quality_perc,ifnull(AVG(NULLIF(oee_perc ,0)),0) as oee_perc FROM `tb_t_oee`
             join tb_o_workcenter on tb_t_oee.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code
            where date_ = '$date' GROUP BY wrk_ctr_code";
              
              
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    
    return $stmt;
 }
 
   function read1(){
    $data = json_decode(file_get_contents('php://input'), true);

    $date = $data['date'];

    $query1 = "SELECT ifnull(AVG(NULLIF(availability_perc ,0)),0) as availability_perc,ifnull(AVG(NULLIF(performance_perc ,0)),0) as performance_perc,ifnull(AVG(NULLIF(quality_perc ,0)),0) as quality_perc,ifnull(AVG(NULLIF(oee_perc ,0)),0) as oee_perc FROM `tb_t_oee` where date_ = '$date'";

    // prepare query statement
     $stmt1 = $this->conn->prepare($query1);

    // execute query

    $stmt1->execute();


    return $stmt1;
     }

}
