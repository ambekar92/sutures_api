
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
    
             $query = "SELECT tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,round(ifnull(AVG(NULLIF(availability_perc ,0)),0),2) as availability_perc,round(ifnull(AVG(NULLIF(performance_perc ,0)),0),2)as performance_perc,round(ifnull(AVG(NULLIF(quality_perc ,0)),0),2) as quality_perc,round(ifnull(AVG(NULLIF(oee_perc ,0)),0),2) as oee_perc FROM tb_o_workcenter
             left join(select * from tb_t_oee where date_ = '$date' ) tb_t_oee  on tb_t_oee.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code
             GROUP BY wrk_ctr_code";
              

    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    
    return $stmt;
 }
 
   function read1(){
    $data = json_decode(file_get_contents('php://input'), true);

    $date = $data['date'];

    $query1 = "SELECT round(ifnull(AVG(NULLIF(availability_perc ,0)),0),2) as availability_perc,round(ifnull(AVG(NULLIF(performance_perc ,0)),0),2)as performance_perc,round(ifnull(AVG(NULLIF(quality_perc ,0)),0),2) as quality_perc,round(ifnull(AVG(NULLIF(oee_perc ,0)),0),2) as oee_perc FROM `tb_t_oee` where date_ = '$date'";

    // prepare query statement
     $stmt1 = $this->conn->prepare($query1);

    // execute query

    $stmt1->execute();


    return $stmt1;
     }


     function color_range($value) {
    
        $sql='select kpi_name,color,color_desc,from_range,to_range from tb_m_oee_color_range';
        
        $stmt1 = $this->conn->prepare($sql);
        
        $stmt1->execute();

        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
                
            extract($row);
    
                $from_range=$from_range;
                $to_range=$to_range; 
                // $color=$row['color'];
    
                if($value >= $from_range && $value <= $to_range) {
                    return  $color=$row['color'];
                }

                if($value >= 100){
                    return  $color = '#0ebc85';
                }
          }
    
        
        //   return $stmt1;
    
    }
}
