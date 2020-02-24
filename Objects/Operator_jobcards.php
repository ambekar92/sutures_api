
<?php

class Operator_jobcards {
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $emp_id = $data['emp_id'];
    //     $date = $data['date'];

    // $query = "SELECT em.frst_name,jt.present_dept,jt.wrk_ctr_desc,jt.batch_no,jc.fg_code,mc.mach_desc,ifnull(qt.ok_qty,0) as ok_qty ,ifnull(qt.rej_qty,0) as rej_qty ,ifnull(qt.cons_qty,0) as cons_qty ,jt.strt as start_time,jt.end as end_time,SEC_TO_TIME(SUM(jt.duration))as duration,SUM(jt.duration)as duration_1,SEC_TO_TIME(fg.bnch_mrk_prod_time * 60)  as target_duration,fg.bnch_mrk_prod_time as target_duration_1 FROM tb_m_machine mc 
    // JOIN(SELECT a.batch_no,a.present_dept,a.present_mach,a.updated_at as strt,b.updated_at as end ,a.emp_id, a.wrk_ctr_desc,TIME_TO_SEC(time(ABS(timediff(b.updated_at,a.updated_at)))) as duration from  tb_t_job_card_trans a join tb_t_job_card_trans b   on a.batch_no = b.batch_no and a.present_mach = b.present_mach and a.present_dept = b.present_dept and date(a.updated_at) = date(b.updated_at) and a.oper_status = 806 and b.oper_status = 807 and a.sl_no < b.sl_no and a.updated_at where a.emp_id = '$emp_id'  and date(a.updated_at) = '$date' GROUP BY a.sl_no ) jt on mc.mach_code = jt.present_mach
    // left JOIN(SELECT ph.batch_no,ph.mach_code,ph.emp_id,ph.wrk_ctr_code,
    // IFNULL(SUM(CASE WHEN ph.qlty_type_code = '500' THEN pi.qty  END), 0)as ok_qty,
    // IFNULL(SUM(CASE WHEN ph.qlty_type_code = '502' THEN pi.qty  END), 0)as rej_qty,
    // IFNULL(SUM(CASE WHEN ph.qlty_type_code = '503' THEN pi.qty  END), 0)as cons_qty
    // from tb_t_prod_i pi 
    // JOIN tb_t_prod_h ph on ph.batch_no = pi.batch_no and pi.sl_no = ph.sl_no
    // where ph.emp_id = '$emp_id'  and date(ph.updated_at) = '$date' GROUP BY ph.batch_no,ph.mach_code) qt on qt.mach_code = jt.present_mach and jt.batch_no = qt.batch_no and  qt.wrk_ctr_code = jt.present_dept and qt.emp_id = jt.emp_id
    // join tb_m_employee em on em.emp_id = jt.emp_id
    // JOIN tb_m_jobcard jc on jc.batch_no = jt.batch_no 
    // JOIN tb_m_fg_opr fg on fg.fg_code = jc.fg_code and jt.present_dept = fg.wrk_ctr_code
    // GROUP BY jt.batch_no,jt.present_mach ";

    $data = json_decode(file_get_contents('php://input'), true);
    $emp_id = $data['emp_id'];
    $from_date = $data['from_date'];
    $to_date = $data['to_date'];


$query = "SELECT em.frst_name,jt.present_dept,jt.wrk_ctr_desc,jt.batch_no,jc.fg_code,mc.mach_desc,ifnull(qt.ok_qty,0) as ok_qty ,ifnull(qt.rej_qty,0) as rej_qty ,ifnull(qt.cons_qty,0) as cons_qty ,jt.strt as start_time,jt.end as end_time,SEC_TO_TIME(SUM(jt.duration))as duration,SUM(jt.duration)as duration_1,SEC_TO_TIME(fg.bnch_mrk_prod_time * 60)  as target_duration,fg.bnch_mrk_prod_time as target_duration_1 FROM tb_m_machine mc 
JOIN(SELECT a.batch_no,a.present_dept,a.present_mach,a.updated_at as strt,b.updated_at as end ,a.emp_id, a.wrk_ctr_desc,TIME_TO_SEC(time(ABS(timediff(b.updated_at,a.updated_at)))) as duration from  tb_t_job_card_trans a join tb_t_job_card_trans b   on a.batch_no = b.batch_no and a.present_mach = b.present_mach and a.present_dept = b.present_dept and date(a.updated_at) = date(b.updated_at) and a.oper_status = 806 and b.oper_status = 807 and a.sl_no < b.sl_no and a.updated_at where a.emp_id = '$emp_id'  and date(a.updated_at) BETWEEN '$from_date' AND '$to_date' GROUP BY a.sl_no ) jt on mc.mach_code = jt.present_mach
left JOIN(SELECT ph.batch_no,ph.mach_code,ph.emp_id,ph.wrk_ctr_code,
IFNULL(SUM(CASE WHEN ph.qlty_type_code = '500' THEN pi.qty  END), 0)as ok_qty,
IFNULL(SUM(CASE WHEN ph.qlty_type_code = '502' THEN pi.qty  END), 0)as rej_qty,
IFNULL(SUM(CASE WHEN ph.qlty_type_code = '503' THEN pi.qty  END), 0)as cons_qty
from tb_t_prod_i pi 
JOIN tb_t_prod_h ph on ph.batch_no = pi.batch_no and pi.sl_no = ph.sl_no
where ph.emp_id = '$emp_id'  and date(ph.updated_at) BETWEEN '$from_date' AND '$to_date' GROUP BY ph.batch_no,ph.mach_code) qt on qt.mach_code = jt.present_mach and jt.batch_no = qt.batch_no and  qt.wrk_ctr_code = jt.present_dept and qt.emp_id = jt.emp_id
join tb_m_employee em on em.emp_id = jt.emp_id
JOIN tb_m_jobcard jc on jc.batch_no = jt.batch_no 
JOIN tb_m_fg_opr fg on fg.fg_code = jc.fg_code and jt.present_dept = fg.wrk_ctr_code
GROUP BY jt.batch_no,jt.present_mach";

    // prepare query statementl
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }

    
}
