
<?php

class Dept_mn_cp_jobcards{
 
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
             $month = $data['month'];
             $year = $data['year'];

        
        
              $query = "SELECT wc.wrk_ctr_desc as wrk_ctr_code,tb_t_job_card_trans.batch_no,tb_m_jobcard.fg_code,tb_m_jobcard.cust_name,tb_m_jobcard.plan,tb_m_plan_type.plan_desc,tb_m_jobcard.req_date,if(tb_m_jobcard.urgent = 0,'REGULAR','URGENT')as type,a.qty as ok_qty,ifnull(sum(b.qty),0) as reject_qty,  date_format(tb_t_job_card_trans.updated_at,'%d-%m-%Y %H:%i:%s')as updated_at FROM `tb_t_job_card_trans` 
              join tb_m_jobcard on tb_t_job_card_trans.batch_no = tb_m_jobcard.batch_no
              join(  SELECT ph.mach_code, ph.batch_no, pi.qty, ph.emp_id, ph.created_at,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON  pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=500 ) a on a.batch_no = tb_t_job_card_trans.batch_no and               tb_t_job_card_trans.present_mach=a.mach_code
              left OUTER join ( SELECT ph.mach_code, ph.batch_no, pi.qty, ph.emp_id, ph.created_at,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi  ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=502 ) b on b.batch_no = tb_t_job_card_trans.batch_no and tb_t_job_card_trans.present_mach=b.mach_code
              JOIN tb_m_plan_type on tb_m_jobcard.plan_code = tb_m_plan_type.plan_code
              join tb_o_workcenter wc on wc.wrk_ctr_code =  tb_t_job_card_trans.present_dept 
              where present_dept = '$wrk_ctr_code' and status_code = 803 and oper_status = 807 and MONTH(tb_t_job_card_trans.updated_at) = '$month' AND YEAR(tb_t_job_card_trans.updated_at) = '$year'  GROUP by batch_no order by tb_t_job_card_trans.updated_at DESC";
              
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    
    return $stmt;
 }
 

   function read1(){
    $data = json_decode(file_get_contents('php://input'), true);
    
    $wrk_ctr_code = $data['wrk_ctr_code'];
    // $date = $data['date'];

     
     $query1 = "SELECT wc.wrk_ctr_desc as wrk_ctr_code ,tb_t_job_status.batch_no,tb_m_jobcard.fg_code,tb_m_jobcard.cust_name,tb_m_jobcard.plan,tb_m_plan_type.plan_desc,tb_m_jobcard.req_date,if(tb_m_jobcard.urgent = 0,'REGULAR','URGENT')as type,date_format(tb_t_job_status.updated_at,'%d-%m-%Y %H:%i:%s') updated_at  from tb_t_job_status 
     join tb_m_jobcard on tb_t_job_status.batch_no = tb_m_jobcard.batch_no
     JOIN tb_t_job_card_trans on tb_t_job_status.batch_no = tb_t_job_card_trans.batch_no and tb_t_job_status.to_dept = tb_t_job_card_trans.present_dept 
     JOIN tb_m_plan_type on tb_m_jobcard.plan_code = tb_m_plan_type.plan_code
     join tb_o_workcenter wc on wc.wrk_ctr_code =  tb_t_job_card_trans.present_dept 
     where to_dept = '$wrk_ctr_code'  GROUP BY tb_t_job_status.batch_no  order  by tb_t_job_status.updated_at ASC";
     

$stmt1 = $this->conn->prepare($query1);
// execute query
$stmt1->execute();

return $stmt1;


}

}