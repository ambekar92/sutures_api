
<?php

class Machine_repo{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // object properties
    public $Machine;        
	public $Department; 
    public $Jobcard;
    public $Size;      
	public $Quality_type;        
    public $Quantity;

    
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        
        $mach_code = $_GET['mach_code'];
        
    // select all query
 $query = "SELECT tb_m_machine.mach_desc,tb_o_workcenter.wrk_ctr_desc,tb_o_workcenter.wrk_ctr_code,A.batch_no,tb_m_jobcard.fg_code,A.qty  as OK_QTY,IFNULL(B.qty,0) as REJ_QTY,date_format(M.TIME_FROM,'%d-%m-%Y %H:%i:%s')as time_from,date_format(M.TIME_TO,'%d-%m-%Y %H:%i:%s')time_To,M.duration from tb_m_qlty_code 
 join  (select tb_t_prod_i.wrk_ctr_code,batch_no,mach_code,SUM(qty)as qty,tb_t_prod_i.qlty_code from tb_t_prod_i join tb_m_qlty_code on tb_t_prod_i.qlty_code = tb_m_qlty_code.qlty_code where tb_m_qlty_code.qlty_type_code= '500' Group BY  tb_t_prod_i.wrk_ctr_code,tb_t_prod_i.batch_no ) A on tb_m_qlty_code.qlty_code = A.qlty_code
 LEFT join(select tb_t_prod_i.wrk_ctr_code,batch_no,SUM(qty)as qty from tb_t_prod_i join tb_m_qlty_code on tb_t_prod_i.qlty_code = tb_m_qlty_code.qlty_code where tb_m_qlty_code.qlty_type_code= '502' Group BY  tb_t_prod_i.wrk_ctr_code,tb_t_prod_i.batch_no ) B on A.batch_no = B.batch_no and A.wrk_ctr_code = B.wrk_ctr_code
join(SELECT A.batch_no,A.present_dept,A.updated_at as TIME_FROM,B.updated_at as TIME_TO,Time(ABS(timediff(B.updated_at,A.updated_at))) as duration FROM  `tb_t_job_card_trans` A 
	JOIN   `tb_t_job_card_trans` B ON  A.oper_status = 806 and B.oper_status = 807 AND A.batch_no=B.batch_no AND A.present_mach = B.present_mach AND A.emp_id=B.emp_id AND A.sl_no<B.sl_no group by A.batch_no )M on M.batch_no = A.batch_no 
  INNER JOIN tb_o_workcenter on A.wrk_ctr_code = tb_o_workcenter.wrk_ctr_code 
  INNER JOIN tb_m_machine on A.mach_code = tb_m_machine.mach_code 
  INNER JOIN tb_m_jobcard on A.batch_no = tb_m_jobcard.batch_no 
  where tb_m_machine.mach_code = '$mach_code'
 Group BY  A.batch_no,A.wrk_ctr_code order by M.TIME_FROM DESC  ";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
