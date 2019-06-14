
<?php

class Operator_efficiency{
 
    
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        $data = json_decode(file_get_contents('php://input'), true);
        $emp_id = $data['emp_id'];
        $date = $data['date'];


 
if ($emp_id == "NULL" AND $date != "NULL" ){
      $query = "SELECT ifnull(date_format(dur.datee,'%d-%m-%Y'),date_format('$date','%d-%m-%Y'))as datee,em.emp_id,em.frst_name,ifnull(no_batch,0)as no_of_cards,ifnull(actual_duration,'00:00:00')as actual_duration,'08:00:00' as target_duration,round(ifnull(((actual_duration/SEC_TO_TIME(28800))*100),0),2) as efficiency  from tb_m_employee em
  left join (SELECT Count(A.batch_no)  as no_batch,SEC_TO_TIME(SUM(TIME_TO_SEC(timediff(B.updated_at,A.updated_at)))) as actual_duration,A.emp_id,date(A.updated_at)as datee FROM  `tb_t_job_card_trans` A 
  JOIN   `tb_t_job_card_trans` B ON  A.oper_status = 806 and B.oper_status = 807 AND A.batch_no=B.batch_no AND A.present_mach = B.present_mach AND A.emp_id=B.emp_id AND A.sl_no<B.sl_no where date(A.updated_at) = '$date' GROUP BY A.emp_id  ) dur  on dur.emp_id = em.emp_id where em.role_code = '101' group by em.emp_id";
// }elseif($emp_id != "NULL" AND $date == "NULL" ){
//      $query = "SELECT date_format(dur.datee,'%d-%m-%Y') as datee,em.emp_id,em.frst_name,ifnull(no_batch,0)as no_of_cards,ifnull(actual_duration,'00:00:00')as actual_duration,'08:00:00' as target_duration,round(ifnull(((actual_duration/SEC_TO_TIME(28800))*100),0),2) as efficiency  from tb_m_employee em
//      join (SELECT date(A.updated_at) as datee,Count(A.batch_no)as no_batch,SEC_TO_TIME(SUM(TIME_TO_SEC(timediff(B.updated_at,A.updated_at)))) as actual_duration,A.emp_id,A.updated_at,B.updated_at as b_update FROM  `tb_t_job_card_trans`A 
//      JOIN   `tb_t_job_card_trans` B ON  A.oper_status = 806 and B.oper_status = 807 AND A.batch_no=B.batch_no AND A.present_mach = B.present_mach AND A.emp_id=B.emp_id AND A.sl_no<B.sl_no where A.emp_id = '$emp_id' GROUP BY date(A.updated_at)) dur  on dur.emp_id = em.emp_id where em.role_code = '101'";
}elseif($emp_id != "NULL" AND $date != "NULL" ){
    $query = "SELECT date_format(dur.datee,'%d-%m-%Y') as datee,em.emp_id,em.frst_name,ifnull(no_batch,0)as no_of_cards,ifnull(actual_duration,'00:00:00')as actual_duration,'08:00:00' as target_duration,round(ifnull(((actual_duration/SEC_TO_TIME(28800))*100),0),2) as efficiency  from tb_m_employee em
     join (SELECT date(A.updated_at) as datee,Count(A.batch_no)as no_batch,SEC_TO_TIME(SUM(TIME_TO_SEC(timediff(B.updated_at,A.updated_at)))) as actual_duration,A.emp_id,A.updated_at,B.updated_at as b_update FROM  `tb_t_job_card_trans`A 
    JOIN   `tb_t_job_card_trans` B ON  A.oper_status = 806 and B.oper_status = 807 AND A.batch_no=B.batch_no AND A.present_mach = B.present_mach AND A.emp_id=B.emp_id AND A.sl_no<B.sl_no where A.emp_id = '$emp_id' and (date(A.updated_at) between  DATE_FORMAT('$date' ,'%Y-%m-01') AND '$date' ) GROUP BY date(A.updated_at)) dur  on dur.emp_id = em.emp_id where em.role_code = '101' order BY dur.datee DESC";
} 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
