
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
    $query = "SELECT js.batch_no,jc.fg_code,js.to_dept_desc,
    IFNULL(js.emp_id,'Not Yet Started') as emp,date_format(js.updated_at,'%d-%m-%Y %H:%i:%s')as updated_at FROM tb_t_job_status js JOIN tb_m_jobcard jc  on js.batch_no  =  jc.batch_no  where js.status_code <> '$status_code' and date(js.updated_at) < DATE_SUB( '$date',INTERVAL 10 DAY) ORDER BY updated_at ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 
}
