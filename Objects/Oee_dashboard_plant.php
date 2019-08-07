
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
    
             $query = "SELECT tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,ifnull((((sum(tot_count)*AVG(NULLIF(idle_cycl_time,0)))/sum(run_time/60))*100),0)as performance_perc,ifnull(((sum(run_time)/sum(plnd_prod_time))*100),0) as availability_perc,ifnull(((sum(ok_qty)/sum(total_count))*100),0)as quality_perc,ifnull(((ifnull(((sum(tot_count)*AVG(idle_cycl_time))/sum(run_time/60)),0))*(ifnull((sum(run_time)/sum(plnd_prod_time)),0))*(ifnull((sum(ok_qty)/sum(total_count)),0)))*100,0) as oee_perc FROM tb_o_workcenter
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

    $query1 = "SELECT ifnull((((sum(tot_count)*AVG(NULLIF(idle_cycl_time,0)))/sum(run_time/60))*100),0)as performance_perc,ifnull(((sum(run_time)/sum(plnd_prod_time))*100),0) as availability_perc,ifnull(((sum(ok_qty)/sum(total_count))*100),0)as quality_perc,ifnull(((ifnull(((sum(tot_count)*AVG(NULLIF(idle_cycl_time,0)))/sum(run_time/60)),0))*(ifnull((sum(run_time)/sum(plnd_prod_time)),0))*(ifnull((sum(ok_qty)/sum(total_count)),0)))*100,0) as oee_perc  from `tb_t_oee` where date_ = '$date'";

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
