
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



     $query = "SELECT jc.fg_code,round(jc.total_qty/12,0) as ord_qty,c.cust_name,jc.req_date,fg.type,jc.batch_no,
     MAX(IF(ph.wrk_ctr_code = 103001,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))STRAIGHT_CUT,
     MAX(IF(ph.wrk_ctr_code = 103002,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))ROUGH_POINTING,
     MAX(IF(ph.wrk_ctr_code = 103003,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))ENDCUT,
     MAX(IF(ph.wrk_ctr_code = 103004,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))CENTERING,
     MAX(IF(ph.wrk_ctr_code = 103005,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))CENTER_CHECK,
     MAX(IF(ph.wrk_ctr_code = 103006,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))MICRO_CENTERING, 
     MAX(IF(ph.wrk_ctr_code = 103007,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))MICRO_CENTRE_CHECK,
     MAX(IF(ph.wrk_ctr_code = 103008,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))MICRO_DRILLING,
     MAX(IF(ph.wrk_ctr_code = 103009,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))MICRO_GAUGE_CHECK,
     MAX(IF(ph.wrk_ctr_code = 103010,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))DRILLING,
     MAX(IF(ph.wrk_ctr_code = 103011,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))GAUGE_CHECK,
     MAX(IF(ph.wrk_ctr_code = 103012,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))PRESS,
     MAX(IF(ph.wrk_ctr_code = 103013,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))MANUAL_GRINDING,
     MAX(IF(ph.wrk_ctr_code = 103014,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))AUTO_GRINDING,
     MAX(IF(ph.wrk_ctr_code = 103015,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))AUTO_GRINDING_INSPECTION,
     MAX(IF(ph.wrk_ctr_code = 103016,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))BENDING,
     MAX(IF(ph.wrk_ctr_code = 103017,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))BENDING_INSPECTION,
     MAX(IF(ph.wrk_ctr_code = 103018,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))HARDENING_TEMPERING,
     MAX(IF(ph.wrk_ctr_code = 103019,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))MICRO,
     MAX(IF(ph.wrk_ctr_code = 103020,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))INSPECTION,
     MAX(IF(ph.wrk_ctr_code = 103021,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - ')) PACKING_LABELLING,
     MAX(IF(ph.wrk_ctr_code = 103023,  concat(DATE_FORMAT(ph.updated_at,'%d/%m'),' - (',(ok.qty),')'),' - '))EDM
     FROM    tb_m_jobcard jc
     LEFT OUTER JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
     LEFT OUTER JOIN( SELECT  ph.batch_no, ROUND(SUM(pi.qty)/12,0) as qty,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=500 GROUP BY pi.batch_no,pi.wrk_ctr_code ) ok on ok.batch_no = ph.batch_no and  ok.wrk_ctr_code = ph.wrk_ctr_code
     JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
     JOIN tb_m_customer c on c.cust_code = jc.cust_code
     WHERE (date(ph.updated_at) between  DATE_FORMAT('$date' ,'%Y-%m-01') AND '$date' )
     GROUP  BY jc.batch_no ORDER BY jc.updated_at DESC";
    

    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }

    
}
