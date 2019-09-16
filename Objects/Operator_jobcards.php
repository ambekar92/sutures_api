
<?php

class Operator_jobcards {
 
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        $data = json_decode(file_get_contents('php://input'), true);
        $emp_id = $data['emp_id'];

     $query = "SELECT A.batch_no,tb_m_jobcard.fg_code,A.wrk_ctr_desc as DEPT,A.present_dept as DEPT_code,ifnull(q.qty,0) as OK_QTY,ifnull    (r.qty,0) as REJ_QTY,mc.mach_desc as MACHINE_NAME,date_format(A.updated_at,'%d-%m-%Y %H:%i:%s') as  TIME_FROM,date_format(B.updated_at,'%d-%m-%Y %H:%i:%s') as TIME_TO,Time(ABS(timediff(B.updated_at,A.updated_at))) as duration,SEC_TO_TIME(tb_m_fg_opr.bnch_mrk_prod_time * 60) as target_time,ROUND((((SEC_TO_TIME(tb_m_fg_opr.bnch_mrk_prod_time * 60)/timediff(B.updated_at,A.updated_at)))*100),2) as efficiency FROM  `tb_t_job_card_trans` A 
     JOIN `tb_t_job_card_trans` B ON  A.oper_status = 806 and B.oper_status = 807 AND A.batch_no=B.batch_no AND A.present_mach =            B.present_mach AND A.emp_id=B.emp_id AND A.sl_no<B.sl_no 
     left JOIN  ( SELECT ph.mach_code, ph.batch_no, Sum(pi.qty) as qty, ph.emp_id, ph.created_at,ph.wrk_ctr_code FROM `tb_t_prod_h` ph 
     JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=500 group by ph.emp_id,ph.batch_no,ph.wrk_ctr_code ) AS q ON A.present_mach=q.mach_code AND A.batch_no = q.batch_no      and A.emp_id = q.emp_id
     left OUTER join ( SELECT ph.mach_code, ph.batch_no, Sum(pi.qty) as qty FROM `tb_t_prod_h` ph 
     JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=502 group by ph.emp_id,ph.batch_no,ph.wrk_ctr_code ) AS r ON A.present_mach=r.mach_code AND A.batch_no = r.batch_no      and A.emp_id = q.emp_id
     join tb_m_machine mc on  A.present_mach = mc.mach_code 
     join tb_m_jobcard on A.batch_no = tb_m_jobcard.batch_no
     join tb_m_fg_opr on tb_m_fg_opr.fg_code = tb_m_jobcard.fg_code and tb_m_fg_opr.wrk_ctr_code = A.present_dept
     WHERE A.emp_id = '$emp_id' group by A.batch_no,A.present_dept order by A.updated_at DESC";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }

    
}
