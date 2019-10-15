
<?php

class Consumables_resns {
 
    
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

echo  $query = "SELECT date(pi.updated_at)as datee,pi.batch_no,jc.fg_code,em.frst_name,pi.mach_code,mc.mach_desc,pi.wrk_ctr_code,wc.wrk_ctr_desc,qc.qlty_code_desc,sum(pi.qty) as qty FROM `tb_t_prod_i` pi  
join tb_t_prod_h ph on  pi.batch_no = ph.batch_no and pi.sl_no = ph.sl_no
join tb_m_qlty_code qc on qc.qlty_code = pi.qlty_code
join tb_m_employee em on em.emp_id = ph.emp_id
join tb_m_jobcard jc on jc.batch_no = ph.batch_no 
join tb_o_workcenter wc on wc.wrk_ctr_code = pi.wrk_ctr_code
join tb_m_machine mc on mc.mach_code = pi.mach_code
join tb_m_fg fg on fg.fg_code = jc.fg_code
where ph.qlty_type_code	= '503' 
and month(ph.updated_at) = $month AND YEAR(ph.updated_at) = $year " .$condition."
GROUP BY pi.mach_code,pi.batch_no order by pi.updated_at";

    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }

   


       
    
}

