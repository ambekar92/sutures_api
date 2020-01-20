
<?php

class Batch_stop_status{
 
    // database connection and table name
    private $conn;
    

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        
    // select all query
    $query = "SELECT jc.batch_no,jc.fg_code,jc.plan,jc.cust_name,jc.ord_qty,ifnull(wc.wrk_ctr_desc,'Not Started Yet')wrk_ctr_desc,ifnull(jt.updated_at,'Not Started Yet')updated_at,ifnull(jc.batch_status,0)batch_status,ifnull(batch_reason,0)batch_reason,ifnull(batch_remarks,'-')batch_remarks,
    ifnull(pr.prod_reas_descp,'-')prod_reas_descp,ifnull(jc.batch_status,'Running')batch_status_r FROM `tb_m_jobcard` jc 
        left join(select batch_no,max(present_dept)present_dept,max(updated_at)updated_at from tb_t_job_card_trans GROUP BY batch_no)  jt on jt.batch_no = jc.batch_no
        join tb_t_job_status js on jc.batch_no = js.batch_no 
        left join tb_o_workcenter wc on jt.present_dept = wc.wrk_ctr_code
        left join tb_m_prod_reason pr on pr.prod_reas_code = jc.batch_reason
        where js.status_code != 804  
        ORDER BY jt.updated_at DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
