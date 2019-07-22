
<?php

class Oee_dashboard_mach{
 
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
            $mach_code = $data['mach_code'];

              $query = "SELECT tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,tb_m_machine.mach_code,tb_m_machine.mach_desc,ifnull(js.batch_no,'-') as batch_no,ifnull(jb.fg_code,'-')as fg_code,if((js.status_code != 803 and js.oper_status != 807),U.name,'-') as operator,if((js.status_code != 803 and js.oper_status != 807),U.emp_id,'-') as operator_id,if(me.on_off_status = 1 or me.on_off_status is null,1,0) as on_off,ifnull(o.plnd_prod_time,0) as plnd_prod_time ,ifnull(o.run_time,0) as run_time ,ifnull(o.idle_time,0) as idle_time, ifnull(o.target_prod,0)as target_prod,ifnull(o.actual_prod,0)as actual_prod,ifnull(o.total_count,0)as total_count,ifnull(o.ok_qty,0) as ok_qty,ifnull(o.rej_qty,0) as rej_qty,ifnull(o.availability_perc,0)as availability_perc,ifnull(o.performance_perc,0)as performance_perc,ifnull(o.quality_perc,0) as quality_perc,ifnull(o.oee_perc,0) as oee_perc  FROM  tb_m_machine
              left join(select * from tb_t_oee where date_ = '$date') o on o.mach_code = tb_m_machine.mach_code and o.wrk_ctr_code = tb_m_machine.wrk_ctr_code
               left OUTER join tb_t_job_status js on  js.to_mach = tb_m_machine.mach_code and js.status_code =                                  802 and js.oper_status=806
               left join users U on js.emp_id = U.emp_id
               left join tb_m_jobcard jb on js.batch_no = jb.batch_no
               join tb_o_workcenter on tb_o_workcenter.wrk_ctr_code = tb_m_machine.wrk_ctr_code
               left join tb_t_mach_status_event me on me.mach_code = tb_m_machine.mach_code
where tb_m_machine.mach_code = '$mach_code'";
              
              
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    
    return $stmt;
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

}
}
