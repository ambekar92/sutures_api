
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
        
    
             $query = "SELECT tb_m_machine.mach_code,tb_m_machine.mach_desc,ifnull(tb_t_mach_status_event.on_off_status,1)as on_off_status,ifnull(availability_perc,0)as availability_perc,ifnull(performance_perc,0)as performance_perc,ifnull(quality_perc,0)as quality_perc,ifnull(oee_perc,0)as oee_perc FROM  tb_m_machine 
             join tb_o_workcenter on tb_m_machine.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code 
             left join(select * from tb_t_oee WHERE date_ = '$date' ) tb_t_oee on tb_m_machine.mach_code = tb_t_oee.mach_code
             left join tb_t_mach_status_event on tb_m_machine.mach_code = tb_t_mach_status_event.mach_code
             WHERE tb_o_workcenter.wrk_ctr_code = '$wrk_ctr_code'";
        
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

    $query1 = "SELECT tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc, ifnull(AVG(nullif(availability_perc,0)),0)as availability_perc ,ifnull(AVG(nullif(performance_perc,0)),0) as performance_perc,ifnull(avg(nullif(quality_perc,0)),0)as quality_perc,ifnull(avg(nullif(oee_perc,0)),0) as oee_perc  FROM tb_m_machine 
    join tb_o_workcenter on tb_m_machine.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code 
    left join(select * from tb_t_oee WHERE date_ = '$date' ) tb_t_oee on tb_m_machine.mach_code = tb_t_oee.mach_code
    WHERE tb_o_workcenter.wrk_ctr_code = '$wrk_ctr_code' GROUP BY wrk_ctr_code";

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
