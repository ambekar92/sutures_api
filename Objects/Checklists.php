
<?php

class Check_list{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // object properties
    public $Ticket;        
	public $Machine_check_h_code; 
    public $Reported_date;
    public $Department; 
    public $Machine;      
	public $Checklist_desc;        
    public $Operator;
    Public $Status;

    
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        //$mach_code = $_GET['mach_code'];
        
    // select all query
    $query = "SELECT ticket,machine_check_h_code,date_format(reported_date,'%d-%m-%Y')as reported_date,tb_o_workcenter.wrk_ctr_desc,machine_desc,checklist_desc,users.name,if(assigned_by is null,0,1) as state,assigned_status as c_state,released_remarks, tb_t_mach_status_event.on_off_status FROM `tb_t_mach_check_h` 
    join tb_m_machine on tb_m_machine.mach_code = tb_t_mach_check_h.machine_code 
    join tb_o_workcenter on tb_o_workcenter.wrk_ctr_code = tb_m_machine.wrk_ctr_code
    join users on tb_t_mach_check_h.reported_by = users.emp_id
    join tb_t_mach_status_event on tb_t_mach_status_event.mach_code = tb_t_mach_check_h.machine_code";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
