
<?php

class Production_status {
 
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        $data = json_decode(file_get_contents('php://input'), true);
        $date = $data['date'];



     $query = "SELECT jc.fg_code,round(jc.total_qty/12,0) as ord_qty,c.cust_name,jc.req_date,jc.plan,fg.type,jc.batch_no,
     concat(jc.ord_qty,'|',(MIN(ok.qty)*12))as op_qty,
     MAX(IF(ph.wrk_ctr_code = 103001,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))STRAIGHT_CUT,
     MAX(IF(ph.wrk_ctr_code = 103002,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))ROUGH_POINTING,
     MAX(IF(ph.wrk_ctr_code = 103003,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))ENDCUT,
     MAX(IF(ph.wrk_ctr_code = 103004,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))CENTERING,
     MAX(IF(ph.wrk_ctr_code = 103005,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))CENTER_CHECK,
     MAX(IF(ph.wrk_ctr_code = 103006,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))MICRO_CENTERING, 
     MAX(IF(ph.wrk_ctr_code = 103007,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))MICRO_CENTRE_CHECK,
     MAX(IF(ph.wrk_ctr_code = 103008,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))MICRO_DRILLING,
     MAX(IF(ph.wrk_ctr_code = 103009,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))MICRO_GAUGE_CHECK,
     MAX(IF(ph.wrk_ctr_code = 103010,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))DRILLING,
     MAX(IF(ph.wrk_ctr_code = 103011,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))GAUGE_CHECK,
     MAX(IF(ph.wrk_ctr_code = 103012,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))PRESS,
     MAX(IF(ph.wrk_ctr_code = 103013,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))MANUAL_GRINDING,
     MAX(IF(ph.wrk_ctr_code = 103014,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))AUTO_GRINDING,
     MAX(IF(ph.wrk_ctr_code = 103015,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))AUTO_GRINDING_INSPECTION,
     MAX(IF(ph.wrk_ctr_code = 103016,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))BENDING,
     MAX(IF(ph.wrk_ctr_code = 103017,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))BENDING_INSPECTION,
     MAX(IF(ph.wrk_ctr_code = 103018,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))HARDENING_TEMPERING,
     MAX(IF(ph.wrk_ctr_code = 103019,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))MICRO,
     MAX(IF(ph.wrk_ctr_code = 103020,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))INSPECTION,
     MAX(IF(ph.wrk_ctr_code = 103021,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - ')) PACKING_LABELLING,
     MAX(IF(ph.wrk_ctr_code = 103023,  DATE_FORMAT(ph.updated_at,'%d/%m'),' - '))EDM,
     MAX(IF(ph.wrk_ctr_code = 103021,  '1','0')) color,
     MAX(IF(ph.wrk_ctr_code = 103021,  'Completed','-'))completed
     FROM    tb_m_jobcard jc
     LEFT OUTER JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
     LEFT OUTER JOIN( SELECT  ph.batch_no, ROUND(SUM(pi.qty)/12,0) as qty,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=500 GROUP BY pi.batch_no,pi.wrk_ctr_code ) ok on ok.batch_no = ph.batch_no and  ok.wrk_ctr_code = ph.wrk_ctr_code
     JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
     JOIN tb_m_customer c on c.cust_code = jc.cust_code
     WHERE (date(ph.updated_at) between  DATE_FORMAT('$date' ,'%Y-%(m-3)-01') AND '$date' )
     GROUP  BY jc.batch_no ORDER BY jc.updated_at DESC,jc.batch_no ASC";
    

    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }

        function read1(){
            $data = json_decode(file_get_contents('php://input'), true);
            $date = $data['date'];
    
        $query1 = "SELECT jc.fg_code,round(jc.total_qty/12,0) as ord_qty,c.cust_name,jc.req_date,jc.plan,fg.type,jc.batch_no,
         concat(jc.ord_qty,'|',(MIN(ok.qty)*12))as op_qty,
         MAX(IF(ph.wrk_ctr_code = 103001,  (ok.qty),' - '))STRAIGHT_CUT,
         MAX(IF(ph.wrk_ctr_code = 103002,  (ok.qty),' - '))ROUGH_POINTING,
         MAX(IF(ph.wrk_ctr_code = 103003,  (ok.qty),' - '))ENDCUT,
         MAX(IF(ph.wrk_ctr_code = 103004,  (ok.qty),' - '))CENTERING,
         MAX(IF(ph.wrk_ctr_code = 103005,  (ok.qty),' - '))CENTER_CHECK,
         MAX(IF(ph.wrk_ctr_code = 103006,  (ok.qty),' - '))MICRO_CENTERING, 
         MAX(IF(ph.wrk_ctr_code = 103007,  (ok.qty),' - '))MICRO_CENTRE_CHECK,
         MAX(IF(ph.wrk_ctr_code = 103008,  (ok.qty),' - '))MICRO_DRILLING,
         MAX(IF(ph.wrk_ctr_code = 103009,  (ok.qty),' - '))MICRO_GAUGE_CHECK,
         MAX(IF(ph.wrk_ctr_code = 103010,  (ok.qty),' - '))DRILLING,
         MAX(IF(ph.wrk_ctr_code = 103011,  (ok.qty),' - '))GAUGE_CHECK,
         MAX(IF(ph.wrk_ctr_code = 103012,  (ok.qty),' - '))PRESS,
         MAX(IF(ph.wrk_ctr_code = 103013,  (ok.qty),' - '))MANUAL_GRINDING,
         MAX(IF(ph.wrk_ctr_code = 103014,  (ok.qty),' - '))AUTO_GRINDING,
         MAX(IF(ph.wrk_ctr_code = 103015,  (ok.qty),' - '))AUTO_GRINDING_INSPECTION,
         MAX(IF(ph.wrk_ctr_code = 103016,  (ok.qty),' - '))BENDING,
         MAX(IF(ph.wrk_ctr_code = 103017,  (ok.qty),' - '))BENDING_INSPECTION,
         MAX(IF(ph.wrk_ctr_code = 103018,  (ok.qty),' - '))HARDENING_TEMPERING,
         MAX(IF(ph.wrk_ctr_code = 103019,  (ok.qty),' - '))MICRO,
         MAX(IF(ph.wrk_ctr_code = 103020,  (ok.qty),' - '))INSPECTION,
         MAX(IF(ph.wrk_ctr_code = 103021,  (ok.qty),' - ')) PACKING_LABELLING,
         MAX(IF(ph.wrk_ctr_code = 103023,  (ok.qty),' - '))EDM
         FROM    tb_m_jobcard jc
         LEFT OUTER JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
         LEFT OUTER JOIN( SELECT  ph.batch_no, ROUND(SUM(pi.qty)/12,0) as qty,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=500 GROUP BY pi.batch_no,pi.wrk_ctr_code ) ok on ok.batch_no = ph.batch_no and  ok.wrk_ctr_code = ph.wrk_ctr_code
         JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
         JOIN tb_m_customer c on c.cust_code = jc.cust_code
         WHERE (date(ph.updated_at) between  DATE_FORMAT(('$date' - INTERVAL 3 MONTH) ,'%Y-%m-01') AND '$date' )
         GROUP  BY jc.batch_no ORDER BY jc.updated_at DESC,jc.batch_no ASC";
        

        // prepare query statement
        $stmt1 = $this->conn->prepare($query1);
       
        // execute query
        $stmt1->execute();
       
        return $stmt1;
    
            }

    
}
