
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
      $query = "SELECT ifnull(date_format(dur.datee,'%d-%m-%Y'),date_format('$date','%d-%m-%Y'))as datee,em.emp_id,em.frst_name,ifnull(count(cnt.batch_no),0)as no_of_cards,ifnull(COUNT(DISTINCT(cnt.present_mach)),0)as mach,ifnull(sec_to_time(SUM(time_to_sec(actual_duration))),'00:00:00')as actual_duration,'08:00:00' as target_duration,round(ifnull(((SUM(time_to_sec(actual_duration))/28800)*100),0),2) as t_eff,round(ifnull(((SUM(cnt.bnch_mrk_prod_time)/(sum(time_to_sec(actual_duration))/60))*100),0),2)as w_eff from tb_m_employee em
      left join (SELECT A.batch_no,timediff(B.updated_at,A.updated_at)as actual_duration,date(A.updated_at)as datee,A.emp_id,A.sl_no,A.present_mach,A.present_dept FROM `tb_t_job_card_trans` A join tb_t_job_card_trans B on A.status_code = 802 and A.oper_status = 806 and B.oper_status = 807 and A.emp_id = B.emp_id and A.batch_no = B.batch_no and A.sl_no < B.sl_no where date(A.updated_at) = '$date' and date(B.updated_at) = '$date' GROUP BY A.sl_no,A.batch_no) dur  on dur.emp_id = em.emp_id 
      left join(select tb_t_job_card_trans.sl_no, tb_t_job_card_trans.batch_no, tb_t_job_card_trans.present_dept,tb_t_job_card_trans.present_mach, tb_t_job_card_trans.emp_id,tb_m_fg_opr.bnch_mrk_prod_time from  tb_t_job_card_trans 
           join tb_m_jobcard on tb_t_job_card_trans.batch_no = tb_m_jobcard.batch_no
           join tb_m_fg_opr on tb_m_fg_opr.fg_code = tb_m_jobcard.fg_code and tb_m_fg_opr.wrk_ctr_code = tb_t_job_card_trans.present_dept where date(tb_t_job_card_trans.updated_at) = '$date' GROUP BY tb_t_job_card_trans.batch_no, tb_t_job_card_trans.present_dept,tb_t_job_card_trans.emp_id)cnt on cnt.sl_no = dur.sl_no and cnt.emp_id = dur.emp_id
      where em.role_code = '101' GROUP BY em.emp_id";
// }elseif($emp_id != "NULL" AND $date == "NULL" ){
//      $query = "SELECT date_format(dur.datee,'%d-%m-%Y') as datee,em.emp_id,em.frst_name,ifnull(no_batch,0)as no_of_cards,ifnull(actual_duration,'00:00:00')as actual_duration,'08:00:00' as target_duration,round(ifnull(((actual_duration/SEC_TO_TIME(28800))*100),0),2) as efficiency  from tb_m_employee em
//      join (SELECT date(A.updated_at) as datee,Count(A.batch_no)as no_batch,SEC_TO_TIME(SUM(TIME_TO_SEC(timediff(B.updated_at,A.updated_at)))) as actual_duration,A.emp_id,A.updated_at,B.updated_at as b_update FROM  `tb_t_job_card_trans`A 
//      JOIN   `tb_t_job_card_trans` B ON  A.oper_status = 806 and B.oper_status = 807 AND A.batch_no=B.batch_no AND A.present_mach = B.present_mach AND A.emp_id=B.emp_id AND A.sl_no<B.sl_no where A.emp_id = '$emp_id' GROUP BY date(A.updated_at)) dur  on dur.emp_id = em.emp_id where em.role_code = '101'";
}elseif($emp_id != "NULL" AND $date != "NULL" ){
    $query = "SELECT ifnull(date_format(dur.datee,'%d-%m-%Y'),date_format('$date','%d-%m-%Y'))as datee,em.emp_id,em.frst_name,ifnull(count(cnt.batch_no),0)as no_of_cards,ifnull(dur.present_mach,'-')as mach,ifnull(sec_to_time(SUM(time_to_sec(actual_duration))),'00:00:00')as actual_duration,'08:00:00' as target_duration,round(ifnull(((SUM(time_to_sec(actual_duration))/28800)*100),0),2) as t_eff,round(ifnull(((avg(cnt.bnch_mrk_prod_time)*ifnull(count(cnt.batch_no),0))/(SUM(time_to_sec(actual_duration))/60)*100),0),2)as w_eff from tb_m_employee em
    join (SELECT A.batch_no,timediff(B.updated_at,A.updated_at)as actual_duration,date(A.updated_at)as datee,A.emp_id,A.sl_no,A.present_mach FROM `tb_t_job_card_trans` A join tb_t_job_card_trans B on A.status_code = 802 and A.oper_status = 806 and B.oper_status = 807 and A.emp_id = B.emp_id and A.batch_no = B.batch_no and A.sl_no < B.sl_no and date(A.updated_at) = date(B.updated_at) where A.emp_id = '$emp_id' and date(A.updated_at) between  DATE_FORMAT('$date' ,'%Y-%m-01') AND '$date'  GROUP BY A.sl_no,A.batch_no) dur  on dur.emp_id = em.emp_id 
   left join(select tb_t_job_card_trans.sl_no, tb_t_job_card_trans.batch_no, tb_t_job_card_trans.present_dept,                tb_t_job_card_trans.emp_id,tb_m_fg_opr.bnch_mrk_prod_time from  tb_t_job_card_trans 
       join tb_m_jobcard on tb_t_job_card_trans.batch_no = tb_m_jobcard.batch_no
         join tb_m_fg_opr on tb_m_fg_opr.fg_code = tb_m_jobcard.fg_code where tb_t_job_card_trans.emp_id = '$emp_id' and (date(tb_t_job_card_trans.updated_at) between  DATE_FORMAT('$date' ,'%Y-%m-01') AND '$date') GROUP BY tb_m_jobcard.batch_no,tb_t_job_card_trans.present_dept,tb_t_job_card_trans.emp_id)cnt on cnt.sl_no = dur.sl_no and cnt.emp_id = dur.emp_id
    where em.role_code = '101' GROUP BY dur.datee";
} 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
