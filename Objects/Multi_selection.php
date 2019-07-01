
<?php

class Multi_selection{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // object properties
    public $Batch_no;        
    public $Size; 
    public $Customer;      
    public $Current_dept;
    public $Team_lead;        
    public $Operator;
    public $Updated_at;
    

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
      $cust_name = $_GET['cust_name'];
      $size = $_GET['size'];
      $batch_no = $_GET['batch_no'];
      $plan_code = $_GET['plan_code'];


      // print_r($cust_name != 0 && $batch_no != 0 && $size == 0 )."\n\n";
      // select all query
   if ($cust_name != 'NULL' AND $size != 'NULL' AND $batch_no != 'NULL' AND $plan_code != 'NULL'  ) {
      $condition = " WHERE tb_m_jobcard.fg_code  = '$size' and A.batch_no = '$batch_no' and tb_m_jobcard.cust_name = '$cust_name' and tb_m_jobcard.plan_code = '$plan_code'";
   }elseif ( $cust_name != 'NULL'  AND $size != 'NULL' AND  $plan_code != 'NULL' AND $batch_no == 'NULL' ) {
        $condition = "WHERE tb_m_jobcard.fg_code  = '$size' and tb_m_jobcard.cust_name = '$cust_name' and tb_m_jobcard.plan_code = '$plan_code'";
   }elseif ($cust_name != 'NULL' AND $batch_no != 'NULL' AND $plan_code != 'NULL' AND $size == 'NULL' ) {
        $condition = "WHERE A.batch_no = '$batch_no' and tb_m_jobcard.cust_name = '$cust_name' and tb_m_jobcard.plan_code = '$plan_code'";
   }elseif ($batch_no != 'NULL' AND $size != 'NULL' AND $plan_code != 'NULL' AND $cust_name == 'NULL' ) {
        $condition = "WHERE tb_m_jobcard.fg_code  = '$size' and A.batch_no = '$batch_no' and tb_m_jobcard.plan_code = '$plan_code' ";
   }elseif ($batch_no != 'NULL' AND $size != 'NULL' AND $cust_name != 'NULL' AND $plan_code == 'NULL' ) {
          $condition = "WHERE tb_m_jobcard.fg_code  = '$size' and A.batch_no = '$batch_no' and tb_m_jobcard.cust_name = '$cust_name' ";
   }elseif ($batch_no != 'NULL' AND $size == 'NULL' AND $cust_name == 'NULL' AND $plan_code == 'NULL'  ) {
        $condition = "WHERE A.batch_no = '$batch_no'  ";
        $batch = 1;
   }elseif ($batch_no == 'NULL' AND $size != 'NULL' AND $cust_name == 'NULL' AND $plan_code == 'NULL'  ) {
        $condition = "WHERE tb_m_jobcard.fg_code  = '$size'";
   }elseif ($batch_no == 'NULL' AND $size == 'NULL' AND $cust_name != 'NULL' AND $plan_code == 'NULL'  ) {
        $condition = "WHERE tb_m_jobcard.cust_name = '$cust_name' ";
   }elseif ($batch_no == 'NULL' AND $size == 'NULL' AND $cust_name == 'NULL' AND $plan_code != 'NULL'  ) {
       $condition = "WHERE tb_m_jobcard.plan_code = '$plan_code'";
   }elseif ($batch_no == 'NULL' AND $size == 'NULL' AND $cust_name != 'NULL' AND $plan_code != 'NULL'  ) {
        $condition = "WHERE tb_m_jobcard.plan_code = '$plan_code' and tb_m_jobcard.cust_name = '$cust_name'";
   }elseif ($batch_no != 'NULL' AND $size != 'NULL' AND $cust_name == 'NULL' AND $plan_code == 'NULL'  ) {
        $condition = "WHERE A.batch_no = '$batch_no' and tb_m_jobcard.fg_code  = '$size'";
   }elseif ($batch_no != 'NULL' AND $size == 'NULL' AND $cust_name != 'NULL' AND $plan_code == 'NULL'  ) {
        $condition = "WHERE A.batch_no = '$batch_no' and tb_m_jobcard.cust_name = '$cust_name' ";
   }elseif ($batch_no == 'NULL' AND $size != 'NULL' AND $cust_name == 'NULL' AND $plan_code != 'NULL'  ) {
        $condition = "WHERE tb_m_jobcard.fg_code  = '$size' and tb_m_jobcard.plan_code = '$plan_code'";
   }elseif ($batch_no == 'NULL' AND $size != 'NULL' AND $cust_name != 'NULL' AND $plan_code == 'NULL'  ) {
     $condition = "WHERE tb_m_jobcard.fg_code  = '$size' and tb_m_jobcard.cust_name = '$cust_name'";
   }elseif($batch_no == 'NULL' AND $size == 'NULL' AND $cust_name == 'NULL' AND $plan_code == 'NULL' ){
      $condition = "NO_VALUE" ;
   }
        
if ($condition != "NO_VALUE" AND $batch = 1 ){
     $query = "SELECT tb_t_job_status.batch_no,tb_m_jobcard.fg_code,if(tb_m_jobcard.urgent = 1,'URGENT','REGULAR') as type,tb_m_jobcard.cust_name,tb_m_jobcard.plan,tb_m_plan_type.plan_desc,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(tb_t_job_status.to_dept_desc,'PACKING AND LABELLING'),IFNULL(tb_t_job_status.from_dept_desc,'STRAIGHT CUT'))as to_dept_desc,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U1.name,'NOT ASSIGNED'),'COMPLETED') as operator,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U1.emp_id,'NOT ASSIGNED'),'COMPLETED') as operator_id,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U2.name,'NOT ASSIGNED'),'COMPLETED')as team_lead,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U2.emp_id,'NOT ASSIGNED'),'COMPLETED')as team_lead_id,if(tb_t_job_status.to_dept = A.present_dept,'-','NOT ACK')as ack_status,date_format(tb_t_job_status.updated_at,'%d-%m-%Y %H:%i:%s') as updated_at from tb_t_job_status 
     JOIN tb_m_jobcard on tb_t_job_status.batch_no = tb_m_jobcard.batch_no 
     JOIN tb_m_plan_type on tb_m_plan_type.plan_code = tb_m_jobcard.plan_code 
     left OUTER join(select * from tb_t_job_card_trans where status_code = 802 and oper_status is null) A on A.batch_no = tb_t_job_status.batch_no and ((tb_t_job_status.to_dept = A.present_dept)or (tb_t_job_status.from_dept = A.present_dept))
     left OUTER join(select * from tb_t_job_card_trans where (status_code = 803 and oper_status = 807) or (status_code = 802 and oper_status = 806) ) B on B.batch_no = tb_t_job_status.batch_no and ((tb_t_job_status.to_dept = B.present_dept) or (tb_t_job_status.from_dept = B.present_dept) )
     LEFT JOIN users U1 on B.emp_id = U1.emp_id 
     LEFT JOIN users U2 on A.emp_id = U2.emp_id  
     " .$condition."  and tb_t_job_status.status_code != '804'
     GROUP BY tb_t_job_status.batch_no
     order by tb_t_job_status.updated_at desc";
}elseif( $condition != "NO_VALUE"){
     $query = "SELECT tb_t_job_status.batch_no,tb_m_jobcard.fg_code,if(tb_m_jobcard.urgent = 1,'URGENT','REGULAR') as type,tb_m_jobcard.cust_name,tb_m_jobcard.plan,tb_m_plan_type.plan_desc,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(tb_t_job_status.to_dept_desc,'PACKING AND LABELLING'),IFNULL(tb_t_job_status.from_dept_desc,'STRAIGHT CUT'))as to_dept_desc,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U1.name,'NOT ASSIGNED'),'COMPLETED') as operator,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U1.emp_id,'NOT ASSIGNED'),'COMPLETED') as operator_id,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U2.name,'NOT ASSIGNED'),'COMPLETED')as team_lead,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U2.emp_id,'NOT ASSIGNED'),'COMPLETED')as team_lead_id,if(tb_t_job_status.to_dept = A.present_dept,'-','NOT ACK')as ack_status,date_format(tb_t_job_status.updated_at,'%d-%m-%Y %H:%i:%s') as updated_at from tb_t_job_status  
JOIN tb_m_jobcard on tb_t_job_status.batch_no = tb_m_jobcard.batch_no 
JOIN tb_m_plan_type on tb_m_plan_type.plan_code = tb_m_jobcard.plan_code 
left OUTER join(select * from tb_t_job_card_trans where status_code = 802 and oper_status is null) A on A.batch_no = tb_t_job_status.batch_no and (tb_t_job_status.to_dept = A.present_dept)
left OUTER join(select * from tb_t_job_card_trans where (status_code = 803 and oper_status = 807) or (status_code = 802 and oper_status = 806) ) B on B.batch_no = tb_t_job_status.batch_no and tb_t_job_status.to_dept = B.present_dept 
LEFT JOIN users U1 on B.emp_id = U1.emp_id 
LEFT JOIN users U2 on A.emp_id = U2.emp_id  
" .$condition."  and tb_t_job_status.status_code != '804'
GROUP BY tb_t_job_status.batch_no
order by tb_t_job_status.updated_at desc";
}else{
$query = "SELECT tb_t_job_status.batch_no,tb_m_jobcard.fg_code,if(tb_m_jobcard.urgent = 1,'URGENT','REGULAR') as type,tb_m_jobcard.cust_name,tb_m_jobcard.plan,tb_m_plan_type.plan_desc,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(tb_t_job_status.to_dept_desc,'PACKING AND LABELLING'),IFNULL(tb_t_job_status.from_dept_desc,'STRAIGHT CUT'))as to_dept_desc,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U1.name,'NOT ASSIGNED'),'COMPLETED') as operator,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U1.emp_id,'NOT ASSIGNED'),'COMPLETED') as operator_id,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U2.name,'NOT ASSIGNED'),'COMPLETED')as team_lead,if(tb_t_job_status.to_dept = A.present_dept,IFNULL(U2.emp_id,'NOT ASSIGNED'),'COMPLETED')as team_lead_id,if(tb_t_job_status.to_dept = A.present_dept,'-','NOT ACK')as ack_status,date_format(tb_t_job_status.updated_at,'%d-%m-%Y %H:%i:%s') as updated_at from tb_t_job_status 
JOIN tb_m_jobcard on tb_t_job_status.batch_no = tb_m_jobcard.batch_no 
JOIN tb_m_plan_type on tb_m_plan_type.plan_code = tb_m_jobcard.plan_code 
left OUTER join(select * from tb_t_job_card_trans where status_code = 802 and oper_status is null) A on A.batch_no = tb_t_job_status.batch_no and (tb_t_job_status.to_dept = A.present_dept)
left OUTER join(select * from tb_t_job_card_trans where (status_code = 803 and oper_status = 807) or (status_code = 802 and oper_status = 806) ) B on B.batch_no = tb_t_job_status.batch_no and tb_t_job_status.to_dept = B.present_dept 
LEFT JOIN users U1 on B.emp_id = U1.emp_id 
LEFT JOIN users U2 on A.emp_id = U2.emp_id
WHERE tb_t_job_status.status_code != '804'
GROUP BY tb_t_job_status.batch_no
order by tb_t_job_status.updated_at desc";
} 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
