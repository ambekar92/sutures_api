
<?php

class Operator_jobcards_chart{
 
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        $data = json_decode(file_get_contents('php://input'), true);
        $emp_id = $data['emp_id'];
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

 if ($from_date == $to_date) {
     $query = "SELECT mc.mach_code as mach_code,mc.mach_desc as mach_name,A.wrk_ctr_desc as wrk_ctr_desc,concat(A.batch_no,'(',tb_m_jobcard.fg_code,')') as batch_no,date_format(A.updated_at,'%d-%m-%Y %H:%i') as  time_from,date_format(B.updated_at,'%d-%m-%Y %H:%i') as time_to,Time(ABS(timediff(B.updated_at,A.updated_at))) as duration FROM  `tb_t_job_card_trans` A 
     JOIN `tb_t_job_card_trans` B ON  A.oper_status = 806 and B.oper_status = 807 AND A.batch_no=B.batch_no AND A.present_mach = B.present_mach AND A.emp_id=B.emp_id AND A.sl_no<B.sl_no 
     join tb_m_machine mc on  A.present_mach = mc.mach_code 
     join tb_m_jobcard on A.batch_no = tb_m_jobcard.batch_no
     WHERE A.emp_id = '$emp_id' and date(A.updated_at) = '$to_date' group by A.batch_no,A.present_dept order by A.updated_at DESC";
 }elseif ($from_date != $to_date) {
    $query = "SELECT mc.mach_code as mach_code,mc.mach_desc as mach_name,A.wrk_ctr_desc as wrk_ctr_desc,concat(A.batch_no,'(',tb_m_jobcard.fg_code,')') as batch_no,date_format(A.updated_at,'%d-%m-%Y %H:%i') as  time_from,date_format(B.updated_at,'%d-%m-%Y %H:%i') as time_to,Time(ABS(timediff(B.updated_at,A.updated_at))) as duration FROM  `tb_t_job_card_trans` A 
     JOIN `tb_t_job_card_trans` B ON  A.oper_status = 806 and B.oper_status = 807 AND A.batch_no=B.batch_no AND A.present_mach = B.present_mach AND A.emp_id=B.emp_id AND A.sl_no<B.sl_no 
     join tb_m_machine mc on  A.present_mach = mc.mach_code 
     join tb_m_jobcard on A.batch_no = tb_m_jobcard.batch_no
     WHERE A.emp_id = '$emp_id' and date(A.updated_at)  BETWEEN '$from_date' and '$to_date' group by A.batch_no,A.present_dept order by A.updated_at DESC";
 }
    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }

    
}
