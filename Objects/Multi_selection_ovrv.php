
<?php

class multi_selection_ovrv{
 
    // database connection and table name
    private $conn;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
       
        // $date = $_GET['date'];
    
    // select all query
    $query = "SELECT w.wrk_ctr_code,w.wrk_ctr_desc, 
    IFNULL(COUNT(CASE WHEN jt.status_code = 802 and jt.oper_status is null and js.to_dept = jt.present_dept   THEN js.batch_no END), 0)as Ack_not_started,
    IFNULL(COUNT(DISTINCT(CASE WHEN jt.status_code = 803 and jt.oper_status = 807 and  js.oper_code = jt.oper_code and js.status_code !=804  THEN js.batch_no END)), 0)as Completed_not_ack,
    IFNULL(COUNT(DISTINCT(CASE WHEN js.status_code = 802 and js.oper_status = 806  and js.to_dept = jt.present_dept THEN js.batch_no END)), 0)as currently_running,
    IFNULL(COUNT(DISTINCT(CASE WHEN js.status_code = 802 and js.oper_status = 807   and js.to_dept = jt.present_dept   THEN js.batch_no END)), 0)as paused 
    FROM tb_o_workcenter w
    join tb_t_job_card_trans jt on jt.present_dept = w.wrk_ctr_code
    LEFT OUTER join tb_t_job_status js on js.batch_no = jt.batch_no   
    GROUP BY w.wrk_ctr_code";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 
}
