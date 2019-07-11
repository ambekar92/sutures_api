
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

              $query = "SELECT o.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,o.mach_code,tb_m_machine.mach_desc,ifnull(js.batch_no,'-') as batch_no,ifnull(jb.fg_code,'-')as fg_code,if((js.status_code != 803 and js.oper_status != 807),U.name,'-') as operator,if((js.status_code != 803 and js.oper_status != 807),U.emp_id,'-') as operator_id,if(me.on_off_status = 1 or me.on_off_status is null,1,0) as on_off,o.plnd_prod_time,o.run_time,o.idle_time,o.	target_prod,actual_prod,o.	total_count,o.ok_qty,o.	rej_qty,o.availability_perc,o.performance_perc,o.quality_perc,o.oee_perc FROM `tb_t_oee` o
                              left OUTER join tb_t_job_status js on js.to_dept = o.wrk_ctr_code and js.to_mach = o.mach_code and js.status_code = 802 and js.oper_status=806
                              left join users U on js.emp_id = U.emp_id
                              left join tb_m_jobcard jb on js.batch_no = jb.batch_no
                              join tb_o_workcenter on tb_o_workcenter.wrk_ctr_code = o.wrk_ctr_code
                              left join tb_t_mach_status_event me on me.mach_code = o.mach_code
                              JOIN tb_m_machine on o.mach_code = tb_m_machine.mach_code and o.wrk_ctr_code = tb_m_machine.wrk_ctr_code
               where o.mach_code = '$mach_code' and date_ = '$date'";
              
              
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    
    return $stmt;
 }
//    function read2(){
//     $data = json_decode(file_get_contents('php://input'), true);

//     $wrk_ctr_code = $data['wrk_ctr_code'];
//     $date = $data['date'];

//     $query2 = "SELECT ifnull(B.completed_cards,0)as completed_cards ,wrk_ctr_code,ifnull(A.today_plan,0) as daily_target FROM tb_o_workcenter
//     LEFT JOIN (select count(batch_no)as completed_cards,present_dept from tb_t_job_card_trans where status_code = 803 and oper_status = 807 and  date(updated_at) = '$date' group by present_dept) B on B.present_dept = tb_o_workcenter.wrk_ctr_code
//     LEFT JOIN  (SELECT work_ctr_code,process,today_plan from  tb_t_prod_dash_h where date_ = '$date') A on tb_o_workcenter.wrk_ctr_code = A.work_ctr_code";

//     // prepare query statement
//      $stmt2 = $this->conn->prepare($query2);

//     // execute query

//     $stmt2->execute();


//     return $stmt2;
//      }

}
