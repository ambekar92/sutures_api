
<?php

class ageing{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // object properties
    public $Jobcard;
    public $Size;
    public $Department;
    public $Employee_name;
    public $Idle_from;

     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        include_once '../environment_variables/environment_variables.php';

        $date = $_GET['date'];
        
    // select all query
    $query = "SELECT js.batch_no,jc.fg_code,jc.plan,tb_m_plan_type.plan_desc,if(jc.urgent = 0,'REGULAR','URGENT')as type,if(js.to_dept = A.present_dept,IFNULL(js.to_dept_desc,'PACKING AND LABELLING'),IFNULL(js.from_dept_desc,'STRAIGHT CUT'))as to_dept_desc,if(js.to_dept = A.present_dept,IFNULL(U1.name,'NOT ASSIGNED'),'COMPLETED') as operator,if(js.to_dept = A.present_dept,IFNULL(U2.name,'NOT ASSIGNED'),'COMPLETED')as team_lead,if(js.to_dept = A.present_dept,'-','NOT ACK')as ack_status,date_format(jc.updated_at,'%d-%m-%Y %H:%i:%s')as created_on,date_format(js.updated_at,'%d-%m-%Y %H:%i:%s')as idle_from,DATEDIFF(CURRENT_DATE,jc.updated_at) as jobcard_cyl_days,DATEDIFF(CURRENT_DATE,js.updated_at) as no_of_idle_days FROM tb_t_job_status js 
    JOIN tb_m_jobcard jc  on js.batch_no  =  jc.batch_no
   left OUTER join(select * from tb_t_job_card_trans where status_code = 802 and oper_status is null) A on A.batch_no = js.batch_no and (js.to_dept = A.present_dept)
left OUTER join(select * from tb_t_job_card_trans where (status_code = 803 and oper_status = 807) or (status_code = 802 and oper_status = 806) ) B on B.batch_no = js.batch_no and js.to_dept = B.present_dept
   LEFT JOIN users U1 on B.emp_id = U1.emp_id 
   LEFT JOIN users U2 on A.emp_id = U2.emp_id 
   JOIN tb_m_plan_type on jc.plan_code = tb_m_plan_type.plan_code
   where js.status_code <> '804' and date(js.updated_at) < DATE_SUB( '$date',INTERVAL 03 DAY) ORDER BY jc.updated_at ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 
}
