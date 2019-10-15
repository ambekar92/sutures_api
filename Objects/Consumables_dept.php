
<?php

class Consumables_dept
{


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read products
    function read()
    {
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


        $sql1 = "SELECT tb_m_qlty_code.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc FROM `tb_m_qlty_code` 
        join tb_o_workcenter on tb_m_qlty_code.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code
        where tb_m_qlty_code.qlty_type_code = 503";

        $stmt1 = $this->conn->prepare($sql1);

        $stmt1->execute();

        $str = " ";

        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

            extract($row1);

            $wrk_ctr_desc = preg_replace('/\s+/', '_', $wrk_ctr_desc);

            $wrk_ctr_desc = str_replace('&', '', $wrk_ctr_desc);



            $str .= ",IFNULL(SUM(CASE WHEN ph.wrk_ctr_code = '$wrk_ctr_code' THEN (ph.qty) END),0)$wrk_ctr_desc";
        }

    
 $query = "SELECT max(date(ph.updated_at))as datee,jc.batch_no,jc.fg_code,fg.type
 " . $str . " 
 FROM tb_m_jobcard jc
 LEFT JOIN  tb_t_prod_i ph  on ph.batch_no = jc.batch_no
 JOIN  tb_t_prod_h phh  on phh.batch_no = ph.batch_no and phh.sl_no = ph.sl_no and phh.qlty_type_code = 503
 JOIN tb_t_job_status js on js.batch_no = jc.batch_no
 JOIN tb_m_fg fg on fg.fg_code = jc.fg_code
 -- WHERE (MONTH(ph.updated_at)  = '$month') and YEAR(ph.updated_at) = $year " .$condition."

GROUP  BY jc.batch_no ORDER BY jc.updated_at DESC,jc.batch_no ASC";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    // read products
    function read1(){


        $sql="SELECT tb_m_qlty_code.wrk_ctr_code,tb_o_workcenter.wrk_ctr_desc FROM `tb_m_qlty_code` 
        join tb_o_workcenter on tb_m_qlty_code.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code
        where tb_m_qlty_code.qlty_type_code = 503";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();

        return $stmt;
    }
}
