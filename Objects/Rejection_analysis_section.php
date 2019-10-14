
<?php

class Rejection_analysis_section {
 
    
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


$query = "SELECT wc.wrk_ctr_code,wc.wrk_ctr_desc,qc.qlty_code,qc.qlty_code_desc,ifnull(sum(rej.qty),0) as qty_in_numz,ROUND(ifnull(sum(rej.qty)/12,0),2) as qty_in_doz,ROUND(ifnull(((sum(rej.qty)/sum(rej.ord_qty))*100),0),2) as per  FROM tb_o_workcenter wc 
JOIN tb_m_qlty_code qc on qc.wrk_ctr_code = wc.wrk_ctr_code
LEFT JOIN (select js.batch_no,pi.qlty_code,pi.qty,pi.wrk_ctr_code,jc.ord_qty from tb_t_prod_i pi 
                  JOIN  tb_t_job_status js on pi.batch_no = js.batch_no 
                  JOIN tb_m_jobcard jc on jc.batch_no = js.batch_no 
                  JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
           where js.status_code = 804 and (MONTH(js.updated_at)  = $month) and YEAR(js.updated_at) = $year " .$condition." ) rej on rej.wrk_ctr_code = wc.wrk_ctr_code and rej.qlty_code = qc.qlty_code
where qc.qlty_type_code = 502  GROUP BY qc.qlty_code" ;

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
    
    
    $query1 = "SELECT wc.wrk_ctr_code,wc.wrk_ctr_desc,ifnull(sum(rej.qty),0) as qty_in_numz,ROUND(ifnull(sum(rej.qty)/12,0),2) as qty_in_doz,ROUND(ifnull(((sum(rej.qty)/sum(rej.ord_qty))*100),0),2) as per  FROM tb_o_workcenter wc 
    JOIN tb_m_qlty_code qc on qc.wrk_ctr_code = wc.wrk_ctr_code
    LEFT JOIN (select js.batch_no,pi.qlty_code,pi.qty,pi.wrk_ctr_code,jc.ord_qty from tb_t_prod_i pi 
                      JOIN  tb_t_job_status js on pi.batch_no = js.batch_no 
                      JOIN tb_m_jobcard jc on jc.batch_no = js.batch_no          
                      JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
                      where js.status_code = 804 and (MONTH(js.updated_at)  = $month) and YEAR(js.updated_at) = $year " .$condition."  ) rej on rej.wrk_ctr_code = wc.wrk_ctr_code and rej.qlty_code = qc.qlty_code
               where qc.qlty_type_code = 502  GROUP BY wc.wrk_ctr_code" ;
    
        // prepare query statement
        $stmt1 = $this->conn->prepare($query1);
       
        // execute query
        $stmt1->execute();
       
        return $stmt1;
    
            }

   
    
}
