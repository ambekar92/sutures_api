
<?php

class Oee_history{
 
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
            $mach_code = $data['mach_code'];
            $select = $data['select'];

   if($wrk_ctr_code == 'ALL' AND $mach_code == 'ALL' AND $select == 'DAILY' ){
    $query = "SELECT tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,tb_t_oee.date_,ifnull(AVG(NULLIF(availability_perc ,0)),0) as availability_perc,ifnull(AVG(NULLIF(performance_perc ,0)),0) as performance_perc,ifnull(AVG(NULLIF(quality_perc ,0)),0) as quality_perc,ifnull(AVG(NULLIF(oee_perc ,0)),0) as oee_perc FROM `tb_t_oee`
    join tb_o_workcenter on tb_t_oee.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code
   where date_ > DATE_SUB('$date', INTERVAL 30 DAY) AND date_ <= '$date' GROUP BY tb_o_workcenter.wrk_ctr_code,tb_t_oee.date_  
ORDER BY `tb_t_oee`.`date_`  DESC ";
   }else if($wrk_ctr_code == 'ALL' AND $mach_code == 'ALL' AND $select == 'WEEKLY' ) {
     $query = "SELECT concat('WEEK ',WEEK(date_,0),' ( ',DATE_FORMAT(MIN(date_),'%d-%m-%Y'),' - ',DATE_FORMAT(MAX(date_),'%d-%m-%Y'),' )') as weekly,WEEK(date_,0) as weeks,tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,ifnull(AVG(NULLIF(availability_perc ,0)),0) as availability_perc,ifnull(AVG(NULLIF(performance_perc ,0)),0) as performance_perc,ifnull(AVG(NULLIF(quality_perc ,0)),0) as quality_perc,ifnull(AVG(NULLIF(oee_perc ,0)),0) as oee_perc FROM `tb_t_oee`
    join tb_o_workcenter on tb_t_oee.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code
   WHERE date_ > DATE_SUB('$date', INTERVAL 4 WEEK) AND date_ <= '$date' GROUP BY tb_o_workcenter.wrk_ctr_code,weeks";
   }else if($wrk_ctr_code == 'ALL' AND $mach_code == 'ALL' AND $select == 'MONTHLY' ) {
    $query = "SELECT  MONTH(date_) as _month, DATE_FORMAT(date_, '%b''%y') as month_desc,tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,tb_t_oee.date_,ifnull(AVG(NULLIF(availability_perc ,0)),0) as availability_perc,ifnull(AVG(NULLIF(performance_perc ,0)),0) as performance_perc,ifnull(AVG(NULLIF(quality_perc ,0)),0) as quality_perc,ifnull(AVG(NULLIF(oee_perc ,0)),0) as oee_perc FROM `tb_t_oee`
    join tb_o_workcenter on tb_t_oee.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code
   WHERE date_ > DATE_SUB('$date', INTERVAL 11 MONTH) AND date_ <= '$date' GROUP BY tb_o_workcenter.wrk_ctr_code,_month";
   }else if($wrk_ctr_code != 'ALL' AND $mach_code == 'ALL' AND $select == 'DAILY' ) {
    $query = "SELECT tb_t_oee.date_,tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,tb_t_oee.mach_code,tb_m_machine.mach_desc,availability_perc,performance_perc,quality_perc,oee_perc 
    FROM `tb_t_oee`
        join tb_o_workcenter on tb_t_oee.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code
        join tb_m_machine on tb_m_machine.mach_code = tb_t_oee.mach_code WHERE  date_ > DATE_SUB('$date', INTERVAL 30 DAY) AND date_ <= '$date' AND tb_t_oee.wrk_ctr_code = '$wrk_ctr_code' GROUP by mach_code,date_";
   }else if($wrk_ctr_code != 'ALL' AND $mach_code == 'ALL' AND $select == 'WEEKLY' ) {
    $query = "SELECT concat('WEEK ',WEEK(date_,0),' ( ',DATE_FORMAT(MIN(date_),'%d-%m-%Y'),' - ',DATE_FORMAT(MAX(date_),'%d-%m-%Y'),' )') as weekly,WEEK(date_,0) as weeks, tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,tb_m_machine.mach_code,tb_m_machine.mach_desc,availability_perc,performance_perc,quality_perc,oee_perc 
    FROM `tb_t_oee`
        join tb_o_workcenter on tb_t_oee.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code 
        join tb_m_machine on tb_m_machine.mach_code = tb_t_oee.mach_code WHERE date_ > DATE_SUB('$date', INTERVAL 4 WEEK) AND date_ <= '$date' AND tb_t_oee.wrk_ctr_code = '$wrk_ctr_code' GROUP by mach_code,weeks";
   }else if($wrk_ctr_code != 'ALL' AND $mach_code == 'ALL' AND $select == 'MONTHLY' ) {
     $query = "SELECT MONTH(date_) as _month, DATE_FORMAT(date_, '%b''%y') as month_desc, tb_o_workcenter.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,tb_m_machine.mach_code,tb_m_machine.mach_desc,availability_perc,performance_perc,quality_perc,oee_perc 
    FROM `tb_t_oee`
        join tb_o_workcenter on tb_t_oee.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code 
        join tb_m_machine on tb_m_machine.mach_code = tb_t_oee.mach_code WHERE date_ > DATE_SUB('$date', INTERVAL 11 MONTH) AND date_ <= '$date' AND tb_t_oee.wrk_ctr_code = '$wrk_ctr_code' GROUP by mach_code,_month";
   }else if($wrk_ctr_code != 'ALL' AND $mach_code != 'ALL' AND $select == 'DAILY' ) {
    $query = "SELECT o.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,o.mach_code,tb_m_machine.mach_desc,o.plnd_prod_time,o.run_time,o.idle_time,o.	target_prod,actual_prod,o.	total_count,o.ok_qty,o.	rej_qty,o.availability_perc,o.performance_perc,o.quality_perc,o.oee_perc FROM `tb_t_oee` o
    left OUTER join tb_t_job_status js on js.to_dept = o.wrk_ctr_code and js.to_mach = o.mach_code and js.status_code = 802 and js.oper_status=806
    left join users U on js.emp_id = U.emp_id
    left join tb_m_jobcard jb on js.batch_no = jb.batch_no
    join tb_o_workcenter on tb_o_workcenter.wrk_ctr_code = o.wrk_ctr_code
    left join tb_t_mach_status_event me on me.mach_code = o.mach_code
    JOIN tb_m_machine on o.mach_code = tb_m_machine.mach_code and o.wrk_ctr_code = tb_m_machine.wrk_ctr_code
where o.mach_code = '$mach_code' and date_ > DATE_SUB('$date', INTERVAL 30 DAY) AND date_ <= '$date'";
   }else if($wrk_ctr_code != 'ALL' AND $mach_code != 'ALL' AND $select == 'WEEKLY' ) {
    $query = "SELECT concat('WEEK ',WEEK(date_,0),' ( ',DATE_FORMAT(MIN(date_),'%d-%m-%Y'),' - ',DATE_FORMAT(MAX(date_),'%d-%m-%Y'),' )') as weekly,WEEK(date_,0) as weeks,o.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,o.mach_code,tb_m_machine.mach_desc,o.plnd_prod_time,o.run_time,o.idle_time,o.	target_prod,actual_prod,o.	total_count,o.ok_qty,o.	rej_qty,o.availability_perc,o.performance_perc,o.quality_perc,o.oee_perc FROM `tb_t_oee` o
    left OUTER join tb_t_job_status js on js.to_dept = o.wrk_ctr_code and js.to_mach = o.mach_code and js.status_code = 802 and js.oper_status=806
    left join users U on js.emp_id = U.emp_id
    left join tb_m_jobcard jb on js.batch_no = jb.batch_no
    join tb_o_workcenter on tb_o_workcenter.wrk_ctr_code = o.wrk_ctr_code
    left join tb_t_mach_status_event me on me.mach_code = o.mach_code
    JOIN tb_m_machine on o.mach_code = tb_m_machine.mach_code and o.wrk_ctr_code = tb_m_machine.wrk_ctr_code
where o.mach_code = '$mach_code' and date_ > DATE_SUB('$date', INTERVAL 4 WEEK) AND date_ <= '$date' GROUP by weeks";
   }else if($wrk_ctr_code != 'ALL' AND $mach_code != 'ALL' AND $select == 'MONTHLY' ) {
    $query = "SELECT MONTH(date_) as _month, DATE_FORMAT(date_, '%b''%y') as month_desc,o.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc,o.mach_code,tb_m_machine.mach_desc,o.plnd_prod_time,o.run_time,o.idle_time,o.	target_prod,actual_prod,o.	total_count,o.ok_qty,o.	rej_qty,o.availability_perc,o.performance_perc,o.quality_perc,o.oee_perc FROM `tb_t_oee` o
    left OUTER join tb_t_job_status js on js.to_dept = o.wrk_ctr_code and js.to_mach = o.mach_code and js.status_code = 802 and js.oper_status=806
    left join users U on js.emp_id = U.emp_id
    left join tb_m_jobcard jb on js.batch_no = jb.batch_no
    join tb_o_workcenter on tb_o_workcenter.wrk_ctr_code = o.wrk_ctr_code
    left join tb_t_mach_status_event me on me.mach_code = o.mach_code
    JOIN tb_m_machine on o.mach_code = tb_m_machine.mach_code and o.wrk_ctr_code = tb_m_machine.wrk_ctr_code
where o.mach_code = '$mach_code' and date_ > DATE_SUB('$date', INTERVAL 11 MONTH) AND date_ <= '$date' GROUP by _month";
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
    $mach_code = $data['mach_code'];
    $select = $data['select'];
   
      if($wrk_ctr_code == 'ALL' AND $mach_code == 'ALL' AND $select == 'DAILY' ){
        $stmt1 = 'ALL_DAILY';
       }else if($wrk_ctr_code == 'ALL' AND $mach_code == 'ALL' AND $select == 'WEEKLY' ) {
        $stmt1 = 'ALL_WEEKLY';
       }else if($wrk_ctr_code == 'ALL' AND $mach_code == 'ALL' AND $select == 'MONTHLY' ) {
        $stmt1 = 'ALL_MONTHLY';
       }else if($wrk_ctr_code != 'ALL' AND $mach_code == 'ALL' AND $select == 'DAILY' ) {
        $stmt1 = 'W_DAILY';
       }else if($wrk_ctr_code != 'ALL' AND $mach_code == 'ALL' AND $select == 'WEEKLY' ) {
        $stmt1 = 'W_WEEKLY';
       }else if($wrk_ctr_code != 'ALL' AND $mach_code == 'ALL' AND $select == 'MONTHLY' ) {
        $stmt1 = 'W_MONTHLY' ;
       }else if($wrk_ctr_code != 'ALL' AND $mach_code != 'ALL' AND $select == 'DAILY' ) {
        $stmt1 = 'M_DAILY';
       }else if($wrk_ctr_code != 'ALL' AND $mach_code != 'ALL' AND $select == 'WEEKLY' ) {
        $stmt1 = 'M_WEEKLY';
       }else if($wrk_ctr_code != 'ALL' AND $mach_code != 'ALL' AND $select == 'MONTHLY' ) {
        $stmt1 = 'M_MONTHLY';
       }

    return $stmt1;
     }


}
