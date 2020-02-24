
<?php

class Rework_analysis_dept {
 
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        $data = json_decode(file_get_contents('php://input'), true);
        $month = $data['month'];
        $year = $data['year'];
        $type = $data['type'];
        $size_type = $data['size_type'];


        if ($type != 'NULL' AND $size_type != 'NULL') {
          $condition = " AND fg.type = '$type' AND fg.size_type = '$size_type'";
       }elseif ($type == 'NULL' AND $size_type != 'NULL') {
          $condition = " AND fg.size_type = '$size_type'";
       }elseif ($type != 'NULL' AND $size_type == 'NULL') {
          $condition = "AND fg.type = '$type'";
       }elseif ($type == 'NULL' AND $size_type == 'NULL') {
          $condition = " " ;
       }


$query = "SELECT max(date(ph.updated_at))as datee,jc.batch_no,jc.fg_code,fg.type,jc.ord_qty as st_qty,MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),'-'))apprvd_qty,
IFNULL(SUM(rew.qty),0)tot_rew,
  MAX(IF(ph.wrk_ctr_code = 103020,(rew.qty),'-'))final_insp_rew,round(((MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),'-'))/(jc.ord_qty))*100),2) as yield,
  MAX(IF(ph.wrk_ctr_code = 103020,(rew.qty),'-'))final_insp_rew,
  MAX(IF(ph.wrk_ctr_code = 103001,(rew.qty),'-'))STRAIGHT_CUT,
  MAX(IF(ph.wrk_ctr_code = 103002,(rew.qty),'-'))ROUGH_POINTING,
  MAX(IF(ph.wrk_ctr_code = 103003,(rew.qty),'-'))ENDCUT,
  MAX(IF(ph.wrk_ctr_code = 103004,(rew.qty),'-'))CENTERING,
  MAX(IF(ph.wrk_ctr_code = 103005,(rew.qty),'-'))CENTER_CHECK,          
  MAX(IF(ph.wrk_ctr_code = 103006,(rew.qty),'-'))MICRO_CENTERING,
  MAX(IF(ph.wrk_ctr_code = 103007,(rew.qty),'-'))MICRO_CENTRE_CHECK,
  MAX(IF(ph.wrk_ctr_code = 103008,(rew.qty),'-'))MICRO_DRILLING,
  MAX(IF(ph.wrk_ctr_code = 103009,(rew.qty),'-'))MICRO_GAUGE_CHECK,           
  MAX(IF(ph.wrk_ctr_code = 103010,(rew.qty),'-'))DRILLING,            
  MAX(IF(ph.wrk_ctr_code = 103011,(rew.qty),'-'))GAUGE_CHECK,            
  MAX(IF(ph.wrk_ctr_code = 103012,(rew.qty),'-'))PRESS,           
  MAX(IF(ph.wrk_ctr_code = 103013,(rew.qty),'-'))MANUAL_GRINDING,           
  MAX(IF(ph.wrk_ctr_code = 103014,(rew.qty),'-'))AUTO_GRINDING,           
  MAX(IF(ph.wrk_ctr_code = 103015,(rew.qty),'-'))AUTO_GRINDING_INSPECTION,           
  MAX(IF(ph.wrk_ctr_code = 103016,(rew.qty),'-'))BENDING,          
  MAX(IF(ph.wrk_ctr_code = 103017,(rew.qty),'-'))BENDING_INSPECTION,           
  MAX(IF(ph.wrk_ctr_code = 103018,(rew.qty),'-'))HARDENING_TEMPERING,           
  MAX(IF(ph.wrk_ctr_code = 103019,(rew.qty),'-'))MICRO,           
  MAX(IF(ph.wrk_ctr_code = 103020,(rew.qty),'-'))INSPECTION,          
  MAX(IF(ph.wrk_ctr_code = 103021,(rew.qty),'-'))PACKING_LABELLING,
  MAX(IF(ph.wrk_ctr_code = 103023,(rew.qty),'-'))EDM
  FROM tb_m_jobcard jc
  LEFT JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
  JOIN tb_t_job_status js on js.batch_no = jc.batch_no
  JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
  LEFT JOIN( SELECT  ph.batch_no, sum(pi.qty) as qty,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=501 GROUP BY          pi.batch_no,pi.wrk_ctr_code) rew on rew.batch_no = ph.batch_no and rew.wrk_ctr_code = ph.wrk_ctr_code
  WHERE (MONTH(js.updated_at)  = '$month') and YEAR(js.updated_at) = $year
 and js.status_code = 804 " .$condition."
  GROUP  BY jc.batch_no ORDER BY jc.updated_at DESC,jc.batch_no ASC";

    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }

   


        function read1(){
         $data = json_decode(file_get_contents('php://input'), true);
         $month = $data['month'];
         $year = $data['year'];
         $type = $data['type'];
         $size_type = $data['size_type'];
 
 
         if ($type != 'NULL' AND $size_type != 'NULL') {
           $condition = " AND fg.type = '$type' AND fg.size_type = '$size_type'";
        }elseif ($type == 'NULL' AND $size_type != 'NULL') {
           $condition = " AND fg.size_type = '$size_type'";
        }elseif ($type != 'NULL' AND $size_type == 'NULL') {
           $condition = "AND fg.type = '$type'";
        }elseif ($type == 'NULL' AND $size_type == 'NULL') {
           $condition = " " ;
        }
 
 
 $query = "SELECT 'TOTAL' as datee,
 count(DISTINCT(jc.batch_no))as batch_no,
 '-' as fg_code,'-' as type,
 IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103021' and ph.qlty_code = '620' THEN (jc.ord_qty) END),0) as st_qty,
 IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103021' and ph.qlty_code = '620' THEN (ph.qty) END),0)apprvd_qty,
 IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103020' and phh.qlty_type_code = 501 THEN (ph.qty) END),0)final_insp_rew,
 IFNULL(SUM(CASE WHEN phh.qlty_type_code = 501 THEN (ph.qty) END),0)tot_rew,
 round(((IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103021' and ph.qlty_code = '620' THEN (ph.qty) END),0)/(IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103021' and ph.qlty_code = '620' THEN (jc.ord_qty) END),0)))*100),2) as yield,
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103001 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)STRAIGHT_CUT,
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103002 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)ROUGH_POINTING,
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103003 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)ENDCUT,
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103004 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)CENTERING,
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103005 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)CENTER_CHECK,          
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103006 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)MICRO_CENTERING,
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103007 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)MICRO_CENTRE_CHECK,
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103008 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)MICRO_DRILLING,
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103009 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)MICRO_GAUGE_CHECK,           
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103010 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)DRILLING,            
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103011 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)GAUGE_CHECK,            
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103012 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)PRESS,           
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103013 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)MANUAL_GRINDING,           
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103014 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)AUTO_GRINDING,           
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103015 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)AUTO_GRINDING_INSPECTION,           
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103016 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)BENDING,          
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103017 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)BENDING_INSPECTION,           
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103018 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)HARDENING_TEMPERING,           
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103019 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)MICRO,           
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103020 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)INSPECTION,          
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103021 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)PACKING_LABELLING,
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = 103023 and phh.qlty_type_code = 501 THEN (ph.qty) END),0)EDM
   FROM tb_m_jobcard jc
   LEFT JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
   JOIN tb_t_prod_h phh on phh.batch_no = ph.batch_no and phh.sl_no = ph.sl_no
   JOIN tb_t_job_status js on js.batch_no = jc.batch_no
   JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
   WHERE (MONTH(js.updated_at)  = '$month') and YEAR(js.updated_at) = '$year'
   AND js.status_code = 804 " .$condition." 
   ORDER BY jc.updated_at DESC,jc.batch_no ASC";
 
     
     // prepare query statement
     $stmt = $this->conn->prepare($query);
    
     // execute query
     $stmt->execute();
    
     return $stmt;
 
         }
 
    
}

