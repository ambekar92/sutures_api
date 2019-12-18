
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


//             $date = $data['date'];
//             $mach_code = $data['mach_code'];

//               $query = "SELECT tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,tb_m_machine.mach_code,tb_m_machine.mach_desc,ifnull(js.batch_no,'-') as batch_no,ifnull(jb.fg_code,'-')as fg_code,if((js.status_code != 803 and js.oper_status != 807),U.name,'-') as operator,if((js.status_code != 803 and js.oper_status != 807),U.emp_id,'-') as operator_id,if(me.on_off_status = 1 or me.on_off_status is null,1,0) as on_off,SEC_TO_TIME(ifnull(o.plnd_prod_time,0)) as plnd_prod_time,SEC_TO_TIME(ifnull(o.run_time,0)) as run_time,SEC_TO_TIME(ifnull(o.idle_time,0)) as idle_time, prd.mc_target as target_prod,prd.completed_cards as actual_prod,round((ifnull(o.total_count,0)/12),2)as total_count,round((ifnull(o.ok_qty,0)/12),2) as ok_qty,round((ifnull(o.rej_qty,0)/12),2) as rej_qty,ifnull(o.availability_perc,0)as availability_perc,ifnull(o.performance_perc,0)as performance_perc,ifnull(o.quality_perc,0) as quality_perc,ifnull(o.oee_perc,0) as oee_perc  FROM  tb_m_machine
//               left join(select * from tb_t_oee where date_ = '$date') o on o.mach_code = tb_m_machine.mach_code and o.wrk_ctr_code = tb_m_machine.wrk_ctr_code
//                left OUTER join tb_t_job_status js on  js.to_mach = tb_m_machine.mach_code and js.status_code = 802 and js.oper_status=806
//                left join users U on js.emp_id = U.emp_id
//                left join tb_m_jobcard jb on js.batch_no = jb.batch_no
//                join tb_o_workcenter on tb_o_workcenter.wrk_ctr_code = tb_m_machine.wrk_ctr_code
//                left join tb_t_mach_status_event me on me.mach_code = tb_m_machine.mach_code
//                left join (SELECT ifnull(B.completed_cards,0)as completed_cards,mc.wrk_ctr_code,mc.mach_code,ifnull(A.daily_target/mc_count,0) as mc_target ,ifnull(A.daily_target,0) as daily_target FROM tb_m_machine mc  
//     LEFT JOIN (select count(DISTINCT(batch_no))as completed_cards,present_dept,present_mach from tb_t_job_card_trans where status_code = 803 and oper_status = 807 and  date(updated_at) = '$date' group by present_mach) B on B.present_mach = mc.mach_code
//     LEFT JOIN  (SELECT pdh.work_ctr_code,pdh.daily_target from  tb_t_prod_dash_h pdh where date_ = '$date') A on mc.wrk_ctr_code = A.work_ctr_code
//     LEFT JOIN  (SELECT COUNT(mach_code) mc_count,wrk_ctr_code from tb_m_machine GROUP BY wrk_ctr_code)cm on cm.wrk_ctr_code = mc.wrk_ctr_code)prd on prd.mach_code = tb_m_machine.mach_code
// where tb_m_machine.mach_code = '$mach_code'";


                $mach_code = $data['mach_code'];
                $from_date = $data['from_date'];
                $to_date = $data['to_date'];

               $query = "SELECT tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,tb_m_machine.mach_code,tb_m_machine.mach_desc,ifnull(js.batch_no,'-') as batch_no,ifnull(jb.fg_code,'-')as fg_code,if((js.status_code != 803 and js.oper_status != 807),U.name,'-') as operator,if((js.status_code != 803 and js.oper_status != 807),U.emp_id,'-') as operator_id,if(me.on_off_status = 1 or me.on_off_status is null,1,0) as on_off,SEC_TO_TIME(ifnull(SUM(o.plnd_prod_time),0)) as plnd_prod_time,SEC_TO_TIME(ifnull(sum(o.run_time),0)) as run_time,SEC_TO_TIME(ifnull(sum(o.idle_time),0)) as idle_time, sum(prd.mc_target) as target_prod,prd.completed_cards as actual_prod,round((ifnull(sum(o.total_count),0)/12),2)as total_count,round((ifnull(sum(o.ok_qty),0)/12),2) as ok_qty,round((ifnull(sum(o.rej_qty),0)/12),2) as rej_qty,ifnull(((sum(run_time)/sum(plnd_prod_time))*100),0) as availability_perc,ifnull(((sum(target_dur)/sum(run_time))*100),0)as performance_perc,ifnull(((sum(ok_qty)/sum(total_count))*100),0)as quality_perc,ifnull(((sum(run_time)/sum(plnd_prod_time))*(sum(target_dur)/sum(run_time))*(sum(ok_qty)/sum(total_count))),0)*100 as oee_perc  FROM  tb_m_machine
                left join(select * from tb_t_oee where date_ between '$from_date' and '$to_date' and run_time <> 0 ) o on o.mach_code = tb_m_machine.mach_code and o.wrk_ctr_code = tb_m_machine.wrk_ctr_code
                 left OUTER join tb_t_job_status js on  js.to_mach = tb_m_machine.mach_code and js.status_code = 802 and js.oper_status=806
                 left join users U on js.emp_id = U.emp_id
                 left join tb_m_jobcard jb on js.batch_no = jb.batch_no
                 join tb_o_workcenter on tb_o_workcenter.wrk_ctr_code = tb_m_machine.wrk_ctr_code
                 left join tb_t_mach_status_event me on me.mach_code = tb_m_machine.mach_code
                 left join (SELECT ifnull(B.completed_cards,0)as completed_cards,mc.wrk_ctr_code,mc.mach_code,ifnull(A.daily_target/mc_count,0) as mc_target ,ifnull(A.daily_target,0) as daily_target FROM tb_m_machine mc  
      LEFT JOIN (select count(DISTINCT(batch_no))as completed_cards,present_dept,present_mach from tb_t_job_card_trans where status_code = 803 and oper_status = 807 and  date(updated_at) between '$from_date' and '$to_date' group by present_mach) B on B.present_mach = mc.mach_code
      LEFT JOIN  (SELECT pdh.work_ctr_code,pdh.daily_target from  tb_t_prod_dash_h pdh where date_ between '$from_date' and '$to_date') A on mc.wrk_ctr_code = A.work_ctr_code
      LEFT JOIN  (SELECT COUNT(mach_code) mc_count,wrk_ctr_code from tb_m_machine GROUP BY wrk_ctr_code)cm on cm.wrk_ctr_code = mc.wrk_ctr_code GROUP by mach_code)prd on prd.mach_code = tb_m_machine.mach_code
  where tb_m_machine.mach_code = '$mach_code' group by tb_m_machine.mach_code";
              
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
