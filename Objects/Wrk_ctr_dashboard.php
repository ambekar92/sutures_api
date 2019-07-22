
<?php

class Wrk_ctr_dashboard{
 
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
         
        
              if ($wrk_ctr_code == "NULL"){
            $query = "SELECT D.wrk_ctr_code,D.wrk_ctr_desc,count(M.mach_code)as machine,ifnull(jp.U_pending_cards,0)as U_pending_cards,ifnull(jp.R_pending_cards,0)as R_pending_cards,ifnull(A.U_completed_cards,0)as U_completed_cards,ifnull(A.R_completed_cards,0)as R_completed_cards ,ifnull(ROUND((B.OK_Qnty)/12,2),0) as ok_qty,ifnull(ROUND((B.Reject_Qnty)/12,2),0) as rej_qty from tb_o_workcenter D
            JOIN tb_m_machine M on D.wrk_ctr_code = M.wrk_ctr_code
            left join (SELECT count((case when tb_m_jobcard.urgent = 0 then tb_m_jobcard.batch_no end)) as R_pending_cards,
                              count((case when tb_m_jobcard.urgent = 1 then tb_m_jobcard.batch_no end)) as u_pending_cards, 
                       to_dept from tb_t_job_status 
                       join tb_m_jobcard on tb_t_job_status.batch_no = tb_m_jobcard.batch_no
                       JOIN(select batch_no,present_dept from tb_t_job_card_trans GROUP BY batch_no,present_dept )tb_t_job_card_trans  on tb_t_job_status.batch_no = tb_t_job_card_trans.batch_no and tb_t_job_status.to_dept = tb_t_job_card_trans.present_dept  group by tb_t_job_card_trans.present_dept)jp on jp.to_dept = D.wrk_ctr_code 
            left join (SELECT Count((case when tb_m_jobcard.urgent = 1 then tb_m_jobcard.batch_no end)) as u_completed_cards,
       Count((case when tb_m_jobcard.urgent = 0 then tb_m_jobcard.batch_no end)) as R_completed_cards,present_dept  FROM `tb_t_job_card_trans` join tb_m_jobcard on tb_m_jobcard.batch_no = tb_t_job_card_trans.batch_no where status_code = 803 and oper_status = 807  and  date(tb_t_job_card_trans.updated_at) = '$date' group by present_dept) A on A.present_dept = D.wrk_ctr_code
            left OUTER join (SELECT IFNULL(SUM(CASE WHEN qlty_type_desc =  'OK' THEN tb_t_prod_i.qty END), 0) OK_Qnty, IFNULL(SUM(CASE WHEN qlty_type_desc =  'REJECT' THEN tb_t_prod_i.qty END), 0) Reject_Qnty,tb_t_prod_i.wrk_ctr_code FROM tb_t_prod_i JOIN tb_m_qlty_code on tb_t_prod_i.qlty_code = tb_m_qlty_code.qlty_code  JOIN tb_m_qlty_type on tb_m_qlty_type.qlty_type_code = tb_m_qlty_code.qlty_type_code where tb_m_qlty_type.qlty_type_code in (500,502) and date(tb_t_prod_i.updated_at) = '$date'group by tb_t_prod_i.wrk_ctr_code ) B on B.wrk_ctr_code  = D.wrk_ctr_code
group by D.wrk_ctr_code";
              }else{
                $query = "SELECT M.mach_code,WC.wrk_ctr_code,WC.wrk_ctr_desc,M.mach_desc,ifnull(js.batch_no,'-') as batch_no,ifnull(jb.fg_code,'-')as fg_code,if((js.status_code != 803 and js.oper_status != 807),U.name,'-') as operator,if((js.status_code != 803 and js.oper_status != 807),U.emp_id,'-') as operator_id,if(me.on_off_status = 1 or me.on_off_status is null,1,0) as on_off,ifnull(ROUND((B.OK_Qnty)/12,2),0) as ok_qty,ifnull(ROUND((B.Reject_Qnty)/12,2),0) as rej_qty from tb_m_machine M 
                left OUTER join tb_t_job_status js on js.to_dept = M.wrk_ctr_code and js.to_mach = M.mach_code and js.status_code = 802 and js.oper_status=806
                left join tb_m_jobcard jb on js.batch_no = jb.batch_no
                left join (SELECT IFNULL(SUM(CASE WHEN qlty_type_desc =  'OK' THEN tb_t_prod_i.qty END), 0) OK_Qnty, IFNULL(SUM(CASE WHEN qlty_type_desc =  'REJECT' THEN tb_t_prod_i.qty END), 0) Reject_Qnty,tb_t_prod_i.wrk_ctr_code,tb_t_prod_i.mach_code FROM tb_t_prod_i JOIN tb_m_qlty_code on tb_t_prod_i.qlty_code = tb_m_qlty_code.qlty_code  JOIN tb_m_qlty_type on tb_m_qlty_type.qlty_type_code = tb_m_qlty_code.qlty_type_code where tb_m_qlty_type.qlty_type_code in (500,502) and date(tb_t_prod_i.updated_at) = '$date' GROUP BY tb_t_prod_i.mach_code ) B on B.mach_code = M.mach_code
                left join users U on js.emp_id = U.emp_id
                left join tb_o_workcenter WC on WC.wrk_ctr_code = M.wrk_ctr_code
                left join tb_t_mach_status_event me on me.mach_code = M.mach_code
                where M.wrk_ctr_code = '$wrk_ctr_code'
                group by M.mach_code";
              }
              
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    
    return $stmt;
 }
 
 function read1(){
    $data = json_decode(file_get_contents('php://input'), true);
    
    $wrk_ctr_code = $data['wrk_ctr_code'];
           
    if ($wrk_ctr_code != "NULL"){
        $stmt1 = 1;
    }else{
        $stmt1 = 0;
    }
        return $stmt1;
   }

   function read2(){
    $data = json_decode(file_get_contents('php://input'), true);

    $wrk_ctr_code = $data['wrk_ctr_code'];
    $date = $data['date'];

    $query2 = "SELECT ifnull(B.completed_cards,0)as completed_cards ,wrk_ctr_code,ifnull(A.today_plan,0) as daily_target FROM tb_o_workcenter
    LEFT JOIN (select count(batch_no)as completed_cards,present_dept from tb_t_job_card_trans where status_code = 803 and oper_status = 807 and  date(updated_at) = '$date' group by present_dept) B on B.present_dept = tb_o_workcenter.wrk_ctr_code
    LEFT JOIN  (SELECT work_ctr_code,process,today_plan from  tb_t_prod_dash_h where date_ = '$date') A on tb_o_workcenter.wrk_ctr_code = A.work_ctr_code";

    // prepare query statement
     $stmt2 = $this->conn->prepare($query2);

    // execute query

    $stmt2->execute();


    return $stmt2;
     }

}
