
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

          
            
          $str .= "MAX(IF(ph.wrk_ctr_code = '$wrk_ctr_code' and ph.qlty_code = '$qlty_code',  (ph.qty),' 0 '))$wrk_ctr_desc".'_'."$qlty_code_desc,";



        }
if($type != 'NULL'){
 $query = "SELECT max(date(ph.updated_at))as datee,jc.batch_no,jc.fg_code,fg.type,jc.ord_qty as st_qty,MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),' - '))apprvd_qty,
    MAX(IF(ph.wrk_ctr_code = 103020,(rej.qty),' - '))final_insp_rej,round(((MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),' - '))/(jc.ord_qty))*100),2) as yield, ".$str." 
     MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code != 620,  (ph.qty),' 0 '))PACKING_LABELLING,
     MAX(IF(ph.wrk_ctr_code = 103023 and ph.qlty_code != 621,  (ph.qty),' 0 '))EDM    
    FROM    tb_m_jobcard jc
    LEFT JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
    JOIN tb_t_job_status js on js.batch_no = jc.batch_no
    JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
    LEFT JOIN( SELECT  ph.batch_no, sum(pi.qty) as qty,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=502 GROUP BY          pi.batch_no,pi.wrk_ctr_code) rej on rej.batch_no = ph.batch_no and rej.wrk_ctr_code = ph.wrk_ctr_code
    WHERE (MONTH(js.updated_at)  = $month) and YEAR(js.updated_at) = $year
    and js.status_code = 804 and fg.type = '$type'
    GROUP  BY jc.batch_no ORDER BY max(date(jc.updated_at)) DESC";
}else{
    $query = "SELECT max(date(ph.updated_at))as datee,jc.batch_no,jc.fg_code,fg.type,jc.ord_qty as st_qty,MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),' - '))apprvd_qty,
    MAX(IF(ph.wrk_ctr_code = 103020,(rej.qty),' - '))final_insp_rej,round(((MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code = 620,(ph.qty),' - '))/(jc.ord_qty))*100),2) as yield, ".$str." 
     MAX(IF(ph.wrk_ctr_code = 103021 and ph.qlty_code != 620,  (ph.qty),' 0 '))PACKING_LABELLING,
     MAX(IF(ph.wrk_ctr_code = 103023 and ph.qlty_code != 621,  (ph.qty),' 0 '))EDM    
    FROM    tb_m_jobcard jc
    LEFT JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
    JOIN tb_t_job_status js on js.batch_no = jc.batch_no
    JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
    LEFT JOIN( SELECT  ph.batch_no, sum(pi.qty) as qty,ph.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=502 GROUP BY          pi.batch_no,pi.wrk_ctr_code) rej on rej.batch_no = ph.batch_no and rej.wrk_ctr_code = ph.wrk_ctr_code
    WHERE (MONTH(js.updated_at)  = $month) and YEAR(js.updated_at) = $year
    and js.status_code = 804 
    GROUP  BY jc.batch_no ORDER BY max(date(jc.updated_at)) DESC";
}


    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }

    //  function read1(){

    //     $sql2= "SELECT tb_m_qlty_code.wrk_ctr_code,tb_m_qlty_code.qlty_code,tb_o_workcenter.wrk_ctr_desc,tb_m_qlty_code.qlty_code_desc FROM `tb_m_qlty_code` join tb_o_workcenter on tb_m_qlty_code.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code where tb_m_qlty_code.qlty_type_code = 502";
        
    //     $stmt2 = $this->conn->prepare($sql2);
        
    //     $stmt2->execute();
    
    //     while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                
    //         extract($row2);

    //         $wrk_ctr_desc = preg_replace('/\s+/', '_', $wrk_ctr_desc);
    //         $qlty_code_desc = preg_replace('/\s+/', '_', $qlty_code_desc);

    //         $qlty_code_desc = str_replace('/', '', $qlty_code_desc);
    //         $wrk_ctr_desc = str_replace('&', '', $wrk_ctr_desc);

          
    //      $str1 .= "".'"'."$wrk_ctr_desc".'_'."$qlty_code_desc".'"'." => ".'$'."$wrk_ctr_desc".'_'."$qlty_code_desc,";
         
    //     }

    //     return $str1;
    //  }




        // function read1(){
        //     $data = json_decode(file_get_contents('php://input'), true);
        //     $month = $data['month'];
        //     $year = $data['year'];
        //     $c_p_status = $data['c_p_status'];
           

        //  if ($c_p_status != "PENDING"){
        //  $query1 = "";
        // }else{
        //    $query1 = "";
        // }

        

        // // prepare query statement
        // $stmt1 = $this->conn->prepare($query1);
       
        // // execute query
        // $stmt1->execute();
       
        // return $stmt1;
    
        //     }

    
}
