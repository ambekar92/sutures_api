
<?php

class Rejection_analysis_data {
 
    
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

        $sql1= "SELECT tb_m_qlty_code.wrk_ctr_code,tb_m_qlty_code.qlty_code,tb_o_workcenter.wrk_ctr_desc,tb_m_qlty_code.qlty_code_desc FROM `tb_m_qlty_code` join tb_o_workcenter on tb_m_qlty_code.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code where tb_m_qlty_code.qlty_type_code = 502";
        
        $stmt1 = $this->conn->prepare($sql1);
        
        $stmt1->execute();
       
        $str = " ";

        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                
            extract($row1);

            $wrk_ctr_desc = preg_replace('/\s+/', '_', $wrk_ctr_desc);
            $qlty_code_desc = preg_replace('/\s+/', '_', $qlty_code_desc);

            $qlty_code_desc = str_replace('/', '', $qlty_code_desc);
            $wrk_ctr_desc = str_replace('&', '', $wrk_ctr_desc);

          
            
          $str .= "MAX(IF(ph.wrk_ctr_code = '$wrk_ctr_code' and ph.qlty_code = '$qlty_code',  (ph.qty),'0'))$wrk_ctr_desc".'_'."$qlty_code_desc,";


        }

        if ($type != 'NULL' AND $size_type != 'NULL') {
            $condition = " AND fg.type = '$type' AND fg.size_type = '$size_type'";
         }elseif ($type == 'NULL' AND $size_type != 'NULL') {
            $condition = " AND fg.size_type = '$size_type'";
         }elseif ($type != 'NULL' AND $size_type == 'NULL') {
            $condition = "AND fg.type = '$type'";
         }elseif ($type == 'NULL' AND $size_type == 'NULL') {
            $condition = " " ;
         }



 $query = "SELECT max(date(ph.updated_at))as datee,jc.batch_no,jc.fg_code,fg.type,jc.ord_qty as st_qty,MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),' - '))apprvd_qty,
    MAX(IF(ph.wrk_ctr_code = 103020,(rej.qty),' - '))final_insp_rej,round(((MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),' - '))/(jc.ord_qty))*100),2) as yield, ".$str." 
     MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code != 620,  (ph.qty),'0'))PACKING_LABELLING,
     MAX(IF(ph.wrk_ctr_code = 103023 and ph.qlty_code != 621,  (ph.qty),'0'))EDM    
    FROM    tb_m_jobcard jc
    LEFT JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
    JOIN tb_t_job_status js on js.batch_no = jc.batch_no
    JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
    LEFT JOIN( SELECT  ph.batch_no, sum(pi.qty) as qty,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=502 GROUP BY pi.batch_no,pi.wrk_ctr_code) rej on rej.batch_no = ph.batch_no and rej.wrk_ctr_code = ph.wrk_ctr_code
    WHERE (MONTH(js.updated_at)  = $month) and YEAR(js.updated_at) = $year
    and js.status_code = 804 " .$condition."
    GROUP  BY jc.batch_no ORDER BY max(date(jc.updated_at)) DESC";


    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }



         // read products
    function read1(){
      $data = json_decode(file_get_contents('php://input'), true);
      $month = $data['month'];
      $year = $data['year'];
      $type = $data['type'];
      $size_type = $data['size_type'];

      $sql1= "SELECT tb_m_qlty_code.wrk_ctr_code,tb_m_qlty_code.qlty_code,tb_o_workcenter.wrk_ctr_desc,tb_m_qlty_code.qlty_code_desc FROM `tb_m_qlty_code` join tb_o_workcenter on tb_m_qlty_code.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code where tb_m_qlty_code.qlty_type_code = 502";
      
      $stmt1 = $this->conn->prepare($sql1);
      
      $stmt1->execute();
     
      $str = " ";

      while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
              
          extract($row1);

          $wrk_ctr_desc = preg_replace('/\s+/', '_', $wrk_ctr_desc);
          $qlty_code_desc = preg_replace('/\s+/', '_', $qlty_code_desc);

          $qlty_code_desc = str_replace('/', '', $qlty_code_desc);
          $wrk_ctr_desc = str_replace('&', '', $wrk_ctr_desc);

        
          
        $str .= "IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '$wrk_ctr_code' and ph.qlty_code = '$qlty_code' THEN (ph.qty) END),0)$wrk_ctr_desc".'_'."$qlty_code_desc,";


      }

      if ($type != 'NULL' AND $size_type != 'NULL') {
          $condition = " AND fg.type = '$type' AND fg.size_type = '$size_type'";
       }elseif ($type == 'NULL' AND $size_type != 'NULL') {
          $condition = " AND fg.size_type = '$size_type'";
       }elseif ($type != 'NULL' AND $size_type == 'NULL') {
          $condition = "AND fg.type = '$type'";
       }elseif ($type == 'NULL' AND $size_type == 'NULL') {
          $condition = " " ;
       }



$query = "SELECT 
'TOTAL' as datee,
count(DISTINCT(jc.batch_no))as batch_no,
'0' as fg_code,'0' as type,
IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103021' and ph.qlty_code = '620' THEN (jc.ord_qty) END),0) as st_qty,
IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103021' and ph.qlty_code = '620' THEN (ph.qty) END),0)apprvd_qty,
IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103020' and phh.qlty_type_code = 502 THEN (ph.qty) END),0)final_insp_rej,
round(((IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103021' and ph.qlty_code = '620' THEN (ph.qty) END),0)/(IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103021' and ph.qlty_code = '620' THEN (jc.ord_qty) END),0)))*100),2) as yield, ".$str." 
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103021' and ph.qlty_code != '620' THEN (ph.qty) END),0)PACKING_LABELLING,
   IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '103023' and ph.qlty_code != '621' THEN (ph.qty) END),0)EDM     
   FROM    tb_m_jobcard jc
    LEFT JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
    JOIN tb_t_prod_h phh on phh.batch_no = ph.batch_no and phh.sl_no = ph.sl_no
    JOIN tb_t_job_status js on js.batch_no = jc.batch_no
    JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
    LEFT JOIN( SELECT  ph.batch_no, sum(pi.qty) as qty,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=502 GROUP BY pi.batch_no,pi.wrk_ctr_code) rej on rej.batch_no = ph.batch_no and rej.wrk_ctr_code = ph.wrk_ctr_code
    WHERE (MONTH(js.updated_at)  = 09) and YEAR(js.updated_at) = 2019
    and js.status_code = 804 " .$condition."";


  // prepare query statement  
  $stmt = $this->conn->prepare($query);
 
  // execute query
  $stmt->execute();
 
  return $stmt;

      }

}
