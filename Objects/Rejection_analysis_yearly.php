
<?php
class Rejection_analysis_yearly {
 
    
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



  $query = "SELECT MONTH(js.updated_at) as _month, DATE_FORMAT(js.updated_at, '%b''%y') as month_desc,sum(ord_qty) as tot_batch_qty,sum(ord_qty/12) as tot_batch_qty_doz,SUM(A.tot_apprvd_qty) as tot_apprvd_qty,SUM(A.tot_apprvd_qty/12) as tot_apprvd_qty_doz,((SUM(A.tot_apprvd_qty)/(sum(ord_qty))*100))as tot_apprvd_qty_per,SUM(A.tot_rej_qty) as tot_rej,SUM(A.tot_rej_qty/12) as tot_rej_doz,((SUM(A.tot_rej_qty)/sum(ord_qty))*100)as tot_rej_per,COUNT(jc.batch_no) as tot_batch_crd_issued,
  (SUM(A.tot_apprvd_qty)/SUM(ord_qty)*100) as avg_yield
  FROM `tb_t_job_status` js
  LEFT JOIN (select ph.batch_no,MAX(IF(pi.wrk_ctr_code = 103021 and pi.qlty_code = 620,(pi.qty),
 0))tot_apprvd_qty,
 IFNULL(SUM(CASE WHEN qlty_type_code =  '502' THEN pi.qty END),
 0) tot_rej_qty
 from tb_t_prod_i pi 
 JOIN tb_t_prod_h ph on ph.batch_no = pi.batch_no and pi.sl_no = ph.sl_no GROUP BY ph.batch_no) A on A.batch_no = js.batch_no
 JOIN tb_m_jobcard jc on jc.batch_no = js.batch_no 
 JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
 Where year(js.updated_at) = '$year' and js.status_code = 804 " .$condition."   GROUP BY _month";

    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }

   
    
}
