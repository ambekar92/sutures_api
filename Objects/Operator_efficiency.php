
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
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];


 
if ($emp_id == "NULL" AND $to_date != "NULL" ){
  $query = "SELECT ifnull(date_format(DATE(a_dur.end),'%d-%m-%Y'),date_format('$to_date','%d-%m-%Y'))as datee,ifnull(DATE(a_dur.end),'$to_date') as date_c,em.emp_id,em.frst_name,ifnull(a_dur.no_of_cards,0)no_of_cards,ifnull(a_dur.no_of_mach,0)no_of_mach,ifnull(SEC_TO_TIME(SUM(a_dur.duration)),'00:00:00') as acu_dur,ifnull(SUM(a_dur.duration),0) as acu_dur1,ifnull(SEC_TO_TIME(sum(a_qty.prod_time)*60),'00:00:00') as target_dur,round(ifnull((sum(a_qty.prod_time)*60),0),0) as target_dur1 from (SELECT  SUM(dr.duration)as duration,dr.emp_id,dr.end,COUNT(DISTINCT(dr.batch_no))as no_of_cards,COUNT(DISTINCT(dr.present_mach)) as no_of_mach from tb_m_jobcard jc 
  JOIN (SELECT a.batch_no,a.present_dept,a.present_mach,a.updated_at as strt,b.updated_at as end,a.emp_id, a.wrk_ctr_desc,TIME_TO_SEC(time(ABS(timediff(b.updated_at,a.updated_at)))) as duration from  tb_t_job_card_trans a join tb_t_job_card_trans b   on a.batch_no = b.batch_no and a.present_mach = b.present_mach and a.present_dept = b.present_dept and date(a.updated_at) = date(b.updated_at) and a.oper_status = 806 and b.oper_status = 807 and a.sl_no < b.sl_no and a.updated_at where  date(a.updated_at) = '$to_date' GROUP BY a.sl_no) dr on dr.batch_no = jc.batch_no
GROUP BY dr.emp_id)a_dur 
LEFT JOIN (SELECT qt.datee,qt.emp_id,sum(qt.prod_time)prod_time from 
    (SELECT date(ph.updated_at)as datee,ph.batch_no,ph.emp_id,ph.mach_code,
   (((IFNULL(SUM(CASE WHEN ph.qlty_type_code = '500' THEN pi.qty  END), 0) + IFNULL(SUM(CASE WHEN ph.qlty_type_code = '502' THEN pi.qty  END), 0)))*(fg.bnch_mrk_prod_time/2100)) as prod_time
    from tb_t_prod_i pi 
    JOIN tb_t_prod_h ph on ph.batch_no = pi.batch_no and pi.sl_no = ph.sl_no
    JOIN tb_m_jobcard jc on jc.batch_no = ph.batch_no 
    JOIN tb_m_fg_opr fg on fg.fg_code = jc.fg_code and ph.wrk_ctr_code = fg.wrk_ctr_code
    where date(ph.updated_at) = '$to_date' GROUP BY ph.batch_no,ph.mach_code)qt GROUP BY qt.emp_id)a_qty on a_qty.datee = date(a_dur.end) and a_qty.emp_id = a_dur.emp_id
RIGHT JOIN tb_m_employee em on em.emp_id = a_dur.emp_id 
where em.role_code = '101'
GROUP BY em.emp_id ORDER BY em.emp_id ";

}elseif($emp_id != "NULL" AND $to_date != "NULL" ){
    $query = "SELECT ifnull(date_format(DATE(a_dur.end),'%d-%m-%Y'),date_format('$to_date','%d-%m-%Y'))as datee,ifnull(DATE(a_dur.end),'$to_date') as date_c,em.emp_id,em.frst_name,a_dur.no_of_cards,a_dur.no_of_mach,SUM(a_dur.duration) as acu_dur1,SEC_TO_TIME(SUM(a_dur.duration)) as acu_dur,sum(a_qty.prod_time)*60 as target_dur1,SEC_TO_TIME(sum(a_qty.prod_time)*60) as target_dur from  (SELECT  jc.batch_no,SUM(dr.duration)as duration,dr.emp_id,dr.end,COUNT(DISTINCT(dr.batch_no))as no_of_cards,COUNT(DISTINCT(dr.present_mach)) as no_of_mach from tb_m_jobcard jc 
    JOIN (SELECT a.batch_no,a.present_dept,a.present_mach,a.updated_at as strt,b.updated_at as end,a.emp_id, a.wrk_ctr_desc,TIME_TO_SEC(time(ABS(timediff(b.updated_at,a.updated_at)))) as duration from  tb_t_job_card_trans a join tb_t_job_card_trans b   on a.batch_no = b.batch_no and a.present_mach = b.present_mach and a.present_dept = b.present_dept and date(a.updated_at) = date(b.updated_at) and a.oper_status = 806 and b.oper_status = 807 and a.sl_no < b.sl_no and a.updated_at where a.emp_id = '$emp_id' and date(a.updated_at) BETWEEN '$from_date' and '$to_date' GROUP BY a.sl_no) dr on dr.batch_no = jc.batch_no
GROUP BY date(dr.end))a_dur 
LEFT JOIN (SELECT qt.datee,qt.emp_id,sum(qt.prod_time)prod_time from 
 (SELECT date(ph.updated_at)as datee,ph.batch_no,ph.emp_id,ph.mach_code,
   (((IFNULL(SUM(CASE WHEN ph.qlty_type_code = '500' THEN pi.qty  END), 0) + IFNULL(SUM(CASE WHEN ph.qlty_type_code = '502' THEN pi.qty  END), 0)))*(fg.bnch_mrk_prod_time/2100)) as prod_time
    from tb_t_prod_i pi 
    JOIN tb_t_prod_h ph on ph.batch_no = pi.batch_no and pi.sl_no = ph.sl_no
    JOIN tb_m_jobcard jc on jc.batch_no = ph.batch_no 
    JOIN tb_m_fg_opr fg on fg.fg_code = jc.fg_code and ph.wrk_ctr_code = fg.wrk_ctr_code
    where ph.emp_id = '$emp_id'  and date(ph.updated_at) BETWEEN '$from_date' and '$to_date' GROUP BY ph.batch_no,ph.mach_code,datee)qt GROUP BY qt.datee)a_qty on a_qty.datee = date(a_dur.end)
JOIN tb_m_employee em on em.emp_id = a_qty.emp_id
GROUP BY datee order by date_c ";
} 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 
function read1(){
            $data = json_decode(file_get_contents('php://input'), true);
            $emp_id = $data['emp_id'];
            $from_date = $data['from_date'];
            $to_date = $data['to_date'];
    
    
     
    if ($emp_id == "NULL" AND $to_date != "NULL" ){
      $query1 = "SELECT em.emp_id, ifnull(SEC_TO_TIME(sum(secs)),0) as tim,ifnull(sum(secs),0)as tim_sec,ifnull(date(strt),'2019-11-21') as day
      from (select t.*, 
                   @time := if(@sum = 0, 0, TIME_TO_SEC(TIMEDIFF(strt, @prevtime))) as secs,
                   @prevtime := strt,
                   @sum := @sum + isstart
            from ((select emp_id, strt, 1 as isstart
                   from (SELECT a.updated_at as strt,b.updated_at as end,a.emp_id from  tb_t_job_card_trans a join tb_t_job_card_trans b   on a.batch_no = b.batch_no and a.present_mach = b.present_mach and a.present_dept = b.present_dept and date(a.updated_at) = date(b.updated_at) and a.oper_status = 806 and b.oper_status = 807 and a.sl_no < b.sl_no  where  date(a.updated_at) = '$to_date'  GROUP BY a.sl_no) t
                  ) union all
                  (select emp_id, end, -1
                   from (SELECT a.updated_at as strt,b.updated_at as end,a.emp_id from  tb_t_job_card_trans a join tb_t_job_card_trans b   on a.batch_no = b.batch_no and a.present_mach = b.present_mach and a.present_dept = b.present_dept and date(a.updated_at) = date(b.updated_at) and a.oper_status = 806 and b.oper_status = 807 and a.sl_no < b.sl_no  where  date(a.updated_at) = '$to_date'  GROUP BY a.sl_no) t
                  )
                 ) t cross join
                 (select @sum := 0, @time := 0, @prevtime := 0) vars
            order by 1, 2
           ) t
           RIGHT join tb_m_employee  em on em.emp_id = t.emp_id
           where em.role_code = '101'
      group by emp_id ORDER BY em.emp_id";
    
    }elseif($emp_id != "NULL" AND $to_date != "NULL" ){
        $query1 = "SELECT emp_id, SEC_TO_TIME(sum(secs)) as tim,sum(secs) as tim_sec,date(strt) as day
        from (select t.*, 
                     @time := if(@sum = 0, 0, TIME_TO_SEC(TIMEDIFF(strt, @prevtime))) as secs,
                     @prevtime := strt,
                     @sum := @sum + isstart
              from ((select emp_id, strt, 1 as isstart
                     from (SELECT a.updated_at as strt,b.updated_at as end,a.emp_id from  tb_t_job_card_trans a join tb_t_job_card_trans b   on a.batch_no = b.batch_no and a.present_mach = b.present_mach and a.present_dept = b.present_dept and date(a.updated_at) = date(b.updated_at) and a.oper_status = 806 and b.oper_status = 807 and a.sl_no < b.sl_no  where  date(a.updated_at) BETWEEN '$from_date' and '$to_date' and a.emp_id = '$emp_id'  GROUP BY a.sl_no) t
                    ) union all
                    (select emp_id, end, -1
                     from (SELECT a.updated_at as strt,b.updated_at as end,a.emp_id from  tb_t_job_card_trans a join tb_t_job_card_trans b   on a.batch_no = b.batch_no and a.present_mach = b.present_mach and a.present_dept = b.present_dept and date(a.updated_at) = date(b.updated_at) and a.oper_status = 806 and b.oper_status = 807 and a.sl_no < b.sl_no  where  date(a.updated_at) BETWEEN '$from_date' and '$to_date' and a.emp_id = '$emp_id'   GROUP BY a.sl_no) t
                    )
                   ) t cross join
                   (select @sum := 0, @time := 0, @prevtime := 0) vars
              order by 1, 2
             ) t
        group by emp_id,day ORDER BY day ";
    } 
        // prepare query statement
        $stmt1 = $this->conn->prepare($query1);
        // execute query
        $stmt1->execute();
        
    
        return $stmt1;
            }
     
}
