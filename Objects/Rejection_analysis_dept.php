
<?php

class Rejection_analysis_dept {
 
    
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

if($type != 'NULL'){
$query = "SELECT max(date(ph.updated_at))as datee,jc.batch_no,jc.fg_code,fg.type,jc.ord_qty as st_qty,MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),0))apprvd_qty,
  MAX(IF(ph.wrk_ctr_code = 103020,(rej.qty),0))final_insp_rej,round(((MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),0))/(jc.ord_qty))*100),2) as yield,
  MAX(IF(ph.wrk_ctr_code = 103020,(rej.qty),0))final_insp_rej,
  MAX(IF(ph.wrk_ctr_code = 103001,(rej.qty),0))STRAIGHT_CUT,
  MAX(IF(ph.wrk_ctr_code = 103002,(rej.qty),0))ROUGH_POINTING,
  MAX(IF(ph.wrk_ctr_code = 103003,(rej.qty),0))ENDCUT,
  MAX(IF(ph.wrk_ctr_code = 103004,(rej.qty),0))CENTERING,
  MAX(IF(ph.wrk_ctr_code = 103005,(rej.qty),0))CENTER_CHECK,          
  MAX(IF(ph.wrk_ctr_code = 103006,(rej.qty),0))MICRO_CENTERING,
  MAX(IF(ph.wrk_ctr_code = 103007,(rej.qty),0))MICRO_CENTRE_CHECK,
  MAX(IF(ph.wrk_ctr_code = 103008,(rej.qty),0))MICRO_DRILLING,
  MAX(IF(ph.wrk_ctr_code = 103009,(rej.qty),0))MICRO_GAUGE_CHECK,           
  MAX(IF(ph.wrk_ctr_code = 103010,(rej.qty),0))DRILLING,            
  MAX(IF(ph.wrk_ctr_code = 103011,(rej.qty),0))GAUGE_CHECK,            
  MAX(IF(ph.wrk_ctr_code = 103012,(rej.qty),0))PRESS,           
  MAX(IF(ph.wrk_ctr_code = 103013,(rej.qty),0))MANUAL_GRINDING,           
  MAX(IF(ph.wrk_ctr_code = 103014,(rej.qty),0))AUTO_GRINDING,           
  MAX(IF(ph.wrk_ctr_code = 103015,(rej.qty),0))AUTO_GRINDING_INSPECTION,           
  MAX(IF(ph.wrk_ctr_code = 103016,(rej.qty),0))BENDING,          
  MAX(IF(ph.wrk_ctr_code = 103017,(rej.qty),0))BENDING_INSPECTION,           
  MAX(IF(ph.wrk_ctr_code = 103018,(rej.qty),0))HARDENING_TEMPERING,           
  MAX(IF(ph.wrk_ctr_code = 103019,(rej.qty),0))MICRO,           
  MAX(IF(ph.wrk_ctr_code = 103020,(rej.qty),0))INSPECTION,          
  MAX(IF(ph.wrk_ctr_code = 103021,(rej.qty),0))PACKING_LABELLING,
  MAX(IF(ph.wrk_ctr_code = 103023,(rej.qty),0))EDM
  FROM tb_m_jobcard jc
  LEFT JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
  JOIN tb_t_job_status js on js.batch_no = jc.batch_no
  JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
  LEFT JOIN( SELECT  ph.batch_no, sum(pi.qty) as qty,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=502 GROUP BY          pi.batch_no,pi.wrk_ctr_code) rej on rej.batch_no = ph.batch_no and rej.wrk_ctr_code = ph.wrk_ctr_code
  WHERE (MONTH(ph.updated_at)  = '$month') and YEAR(js.updated_at) = $year
 and js.status_code = 804 and fg.type = '$type'

  GROUP  BY jc.batch_no ORDER BY jc.updated_at DESC,jc.batch_no ASC";
}else{
    $query = "SELECT max(date(ph.updated_at))as datee,jc.batch_no,jc.fg_code,fg.type,jc.ord_qty as st_qty,MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),0))apprvd_qty,
  MAX(IF(ph.wrk_ctr_code = 103020,(rej.qty),0))final_insp_rej,round(((MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),0))/(jc.ord_qty))*100),2) as yield,
  MAX(IF(ph.wrk_ctr_code = 103020,(rej.qty),0))final_insp_rej,
  MAX(IF(ph.wrk_ctr_code = 103001,(rej.qty),0))STRAIGHT_CUT,
  MAX(IF(ph.wrk_ctr_code = 103002,(rej.qty),0))ROUGH_POINTING,
  MAX(IF(ph.wrk_ctr_code = 103003,(rej.qty),0))ENDCUT,
  MAX(IF(ph.wrk_ctr_code = 103004,(rej.qty),0))CENTERING,
  MAX(IF(ph.wrk_ctr_code = 103005,(rej.qty),0))CENTER_CHECK,          
  MAX(IF(ph.wrk_ctr_code = 103006,(rej.qty),0))MICRO_CENTERING,
  MAX(IF(ph.wrk_ctr_code = 103007,(rej.qty),0))MICRO_CENTRE_CHECK,
  MAX(IF(ph.wrk_ctr_code = 103008,(rej.qty),0))MICRO_DRILLING,
  MAX(IF(ph.wrk_ctr_code = 103009,(rej.qty),0))MICRO_GAUGE_CHECK,           
  MAX(IF(ph.wrk_ctr_code = 103010,(rej.qty),0))DRILLING,            
  MAX(IF(ph.wrk_ctr_code = 103011,(rej.qty),0))GAUGE_CHECK,            
  MAX(IF(ph.wrk_ctr_code = 103012,(rej.qty),0))PRESS,           
  MAX(IF(ph.wrk_ctr_code = 103013,(rej.qty),0))MANUAL_GRINDING,           
  MAX(IF(ph.wrk_ctr_code = 103014,(rej.qty),0))AUTO_GRINDING,           
  MAX(IF(ph.wrk_ctr_code = 103015,(rej.qty),0))AUTO_GRINDING_INSPECTION,           
  MAX(IF(ph.wrk_ctr_code = 103016,(rej.qty),0))BENDING,          
  MAX(IF(ph.wrk_ctr_code = 103017,(rej.qty),0))BENDING_INSPECTION,           
  MAX(IF(ph.wrk_ctr_code = 103018,(rej.qty),0))HARDENING_TEMPERING,           
  MAX(IF(ph.wrk_ctr_code = 103019,(rej.qty),0))MICRO,           
  MAX(IF(ph.wrk_ctr_code = 103020,(rej.qty),0))INSPECTION,          
  MAX(IF(ph.wrk_ctr_code = 103021,(rej.qty),0))PACKING_LABELLING,
  MAX(IF(ph.wrk_ctr_code = 103023,(rej.qty),0))EDM
  FROM tb_m_jobcard jc
  LEFT JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
  JOIN tb_t_job_status js on js.batch_no = jc.batch_no
  JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
  LEFT JOIN( SELECT  ph.batch_no, sum(pi.qty) as qty,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=502 GROUP BY          pi.batch_no,pi.wrk_ctr_code) rej on rej.batch_no = ph.batch_no and rej.wrk_ctr_code = ph.wrk_ctr_code
  WHERE (MONTH(ph.updated_at)  = '$month') and YEAR(js.updated_at) = $year
 and js.status_code = 804 

  GROUP  BY jc.batch_no ORDER BY jc.updated_at DESC,jc.batch_no ASC";
}
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }

   
    
}
