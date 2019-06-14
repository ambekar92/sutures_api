
<?php

class employee_dur{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // object properties
    public $Employee;
    public $Department;
    public $Ok_Qnty;
    public $Duration;

     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        $batch_no = $_GET['batch_no'];
        
    // select all query
  $query = "SELECT u.name,a.wrk_ctr_desc,q.qty,Time(ABS(timediff(b.updated_at,a.updated_at)))as diff, concat(u.name,' (',a.wrk_ctr_desc,')') as empname FROM `tb_t_job_card_trans` a 
   JOIN   `tb_t_job_card_trans` b ON  a.oper_status = 806 and b.oper_status = 807 AND a.batch_no=b.batch_no AND a.present_mach = b.present_mach AND a.emp_id=b.emp_id AND a.sl_no<b.sl_no 
   join users u on a.emp_id = u.emp_id
   join (SELECT ph.mach_code,ph.batch_no, pi.qty, ph.emp_id, ph.created_at,pi.wrk_ctr_code FROM `tb_t_prod_h` ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=500 ) AS q ON a.present_mach=q.mach_code AND  a.batch_no = q.batch_no  where a.batch_no = '$batch_no' group by a.present_mach,q.batch_no,a.emp_id order by a.updated_at";
 
 //echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    
    //print_r($stmt);

    return $stmt;
        }

        
}
