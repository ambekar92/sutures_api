
<?php

class ageing_ovrv{
 
    // database connection and table name
    private $conn;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
       
        $date = $_GET['date'];
    
    // select all query
    $query = "SELECT jc.plan,
    'Plan-1' as plan1,
    'Plan-2' as plan2,
    'Plan-3' as plan3,
    '300' as plan1c,
    '301' as plan2c,
    '302' as plan3c,
    IFNULL(COUNT(CASE WHEN tb_m_plan_type.plan_desc = 'Plan-1' and jc.urgent = 1 THEN js.batch_no END), 0)as plan1_U,
    IFNULL(COUNT(CASE WHEN tb_m_plan_type.plan_desc = 'Plan-1' and jc.urgent = 0 THEN js.batch_no END), 0)as plan1_R,
    IFNULL(COUNT(CASE WHEN tb_m_plan_type.plan_desc = 'Plan-2' and jc.urgent = 1 THEN js.batch_no END), 0)as plan2_U,
    IFNULL(COUNT(CASE WHEN tb_m_plan_type.plan_desc = 'Plan-2' and jc.urgent = 0 THEN js.batch_no END), 0)as plan2_R,
    IFNULL(COUNT(CASE WHEN tb_m_plan_type.plan_desc = 'Plan-3' and jc.urgent = 1 THEN js.batch_no END), 0)as plan3_U,
    IFNULL(COUNT(CASE WHEN tb_m_plan_type.plan_desc = 'Plan-3' and jc.urgent = 0 THEN js.batch_no END), 0)as plan3_R 
    FROM tb_t_job_status js 
        JOIN tb_m_jobcard jc  on js.batch_no  =  jc.batch_no
       JOIN tb_m_plan_type on jc.plan_code = tb_m_plan_type.plan_code
       where js.status_code <> '804' and date(js.updated_at) < DATE_SUB( '$date',INTERVAL 03 DAY) GROUP BY jc.plan ORDER BY tb_m_plan_type.plan_desc ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 
}
