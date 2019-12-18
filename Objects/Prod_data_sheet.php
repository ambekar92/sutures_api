
<?php

class Prod_data_sheet {
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // object properties
    public $Department;        
	public $Date; 
	public $Operator;      
    public $Qty_nos;
    public $Mc_no;        
    public $Mach_name;
    public $Time_from;
    public $Time_to;
    

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        $batch_no = $_GET['batch_no'];

        // $query = "SELECT A.wrk_ctr_desc as DEPT,q.wrk_ctr_code as DEPT_CODE,date_format(B.updated_at,'%d-%m-%Y') as DATEE,u1.name as team_lead,u1.emp_id as team_lead_id,u.name as OPERATOR,u.emp_id as OPERATOR_id,q.qty as OK_QTY,ifnull(r.qty,0) as REJ_QTY,mc.mach_desc as MACHINE_NAME,time(A.updated_at)as TIME_FROM,time(B.updated_at) as TIME_TO,Time(ABS(timediff(B.updated_at,A.updated_at))) as duration FROM  `tb_t_job_card_trans` A 
        // JOIN   `tb_t_job_card_trans` B ON  A.oper_status = 806 and B.oper_status = 807 AND A.batch_no=B.batch_no AND A.present_mach = B.present_mach AND A.emp_id=B.emp_id AND A.sl_no<B.sl_no 
        // JOIN users u on A.emp_id = u.emp_id 
        // JOIN (SELECT * FROM tb_t_job_card_trans WHERE status_code = '802' and oper_status is null)T on T.batch_no = A.batch_no and A.present_dept = T.present_dept
        // JOIN users u1 on T.emp_id = u1.emp_id 
        // JOIN ( SELECT ph.mach_code, ph.batch_no, SUM(pi.qty) as qty, ph.emp_id, ph.created_at,ph.wrk_ctr_code FROM `tb_t_prod_h` ph 
        // JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=500 group by ph.emp_id,ph.batch_no,ph.wrk_ctr_code ) AS q ON A.present_mach=q.mach_code AND A.batch_no = q.batch_no and A.emp_id = q.emp_id
        // left OUTER join ( SELECT ph.mach_code, ph.batch_no, SUM(pi.qty) as qty,ph.emp_id FROM `tb_t_prod_h` ph 
        // JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no  AND ph.qlty_type_code=502 group by ph.emp_id,ph.batch_no,ph.wrk_ctr_code  ) AS r ON A.present_mach=r.mach_code AND A.batch_no = r.batch_no  and r.emp_id = q.emp_id and A.emp_id = q.emp_id   join tb_m_machine mc on  A.present_mach = mc.mach_code    
        // where A.batch_no = '$batch_no' group by A.emp_id,A.present_mach order by A.sl_no";

        $query = "SELECT A.wrk_ctr_desc as DEPT,q.wrk_ctr_code as DEPT_CODE,date_format(B.updated_at,'%d-%m-%Y') as DATEE,u1.name as team_lead,u1.emp_id as team_lead_id,u.name as OPERATOR,u.emp_id as OPERATOR_id,q.qty as OK_QTY,ifnull(r.qty,0) as REJ_QTY,mc.mach_desc as MACHINE_NAME,time(A.updated_at)as TIME_FROM,time(B.updated_at) as TIME_TO,Time(ABS(timediff(B.updated_at,A.updated_at))) as duration FROM  `tb_t_job_card_trans` A 
JOIN   `tb_t_job_card_trans` B ON  A.oper_status = 806 and B.oper_status = 807 AND A.batch_no=B.batch_no AND A.present_mach = B.present_mach AND A.emp_id=B.emp_id AND A.sl_no<B.sl_no 
JOIN users u on A.emp_id = u.emp_id 
JOIN (SELECT * FROM tb_t_job_card_trans WHERE status_code = '802' and oper_status is null and batch_no = '$batch_no' )T on T.batch_no = A.batch_no and A.present_dept = T.present_dept
JOIN users u1 on T.emp_id = u1.emp_id 
JOIN ( SELECT ph.mach_code, ph.batch_no, SUM(pi.qty) as qty, ph.emp_id, ph.created_at,ph.wrk_ctr_code FROM `tb_t_prod_h` ph 
JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=500 and ph.batch_no = '$batch_no' group by ph.emp_id,ph.batch_no,ph.wrk_ctr_code ) AS q ON A.present_mach=q.mach_code AND A.batch_no = q.batch_no and A.emp_id = q.emp_id
left OUTER join ( SELECT ph.mach_code, ph.batch_no, SUM(pi.qty) as qty,ph.emp_id FROM `tb_t_prod_h` ph 
JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no  AND ph.qlty_type_code=502 and ph.batch_no = '$batch_no'  group by ph.emp_id,ph.batch_no,ph.wrk_ctr_code  ) AS r ON A.present_mach=r.mach_code AND A.batch_no = r.batch_no  and r.emp_id = q.emp_id and A.emp_id = q.emp_id   join tb_m_machine mc on  A.present_mach = mc.mach_code    
where A.batch_no = '$batch_no' group by A.emp_id,A.present_mach order by A.sl_no";

        
    // prepare query statement
    $stmt = $this->conn->prepare($query);
   
    // execute query
    $stmt->execute();
   
    return $stmt;

        }
 
        function read1(){
            $batch_no = $_GET['batch_no'];
    
    
            $query1 = "SELECT batch_no,fg_code,ord_qty,cust_name,date_format(req_date,'%d-%m-%Y') as req_date, if(urgent = 0,'REGULAR','URGENT')as state,plan FROM tb_m_jobcard WHERE  batch_no = '$batch_no'";
    
        // prepare query statement
        $stmt1 = $this->conn->prepare($query1);
        
        // execute query
      
        $stmt1->execute();
        

        return $stmt1;
            }
     

}
