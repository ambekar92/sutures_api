
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
    $query = "SELECT js.batch_no,jc.fg_code,js.to_dept_desc as dept_desc,if(js.to_dept = A.present_dept,IFNULL(U1.name,'NOT ASSIGNED'),'YET TO START') as operator,if(js.to_dept = A.present_dept,IFNULL(U2.name,'NOT ASSIGNED'),'YET TO START')as team_lead ,date_format(js.updated_at,'%d-%m-%Y %H:%i:%s')as updated_at FROM tb_t_job_status js 
    JOIN tb_m_jobcard jc  on js.batch_no  =  jc.batch_no
    left OUTER join(select * from tb_t_job_card_trans where status_code = 802 and oper_status is null) A on A.batch_no = js.batch_no and (js.to_dept = A.present_dept)
    left OUTER join(select * from tb_t_job_card_trans where (status_code = 803 and oper_status = 807) or (status_code = 802 and oper_status = 806) ) B on B.batch_no = js.batch_no and                   js.to_dept = B.present_dept 
   LEFT JOIN users U1 on B.emp_id = U1.emp_id 
   LEFT JOIN users U2 on A.emp_id = U2.emp_id  
   where js.status_code <> '$status_code' and date(js.updated_at) < DATE_SUB( '$date',INTERVAL 10 DAY) ORDER BY updated_at ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 
}
