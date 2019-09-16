
<?php

class Release_checklist {
 
    // database connection and table name
    private $conn;
    ///private $table_name = "tb_t_prod_i";


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
     $data = json_decode(file_get_contents('php://input'), true);

     $ticket = $data['ticket'];
     $machine_check_h_code = $data['machine_check_h_code'];
     $released_date = $data['released_date'];
     $released_remarks = $data['released_remarks'];
     $released_by = $data['released_by'];
     $release_for_production = $data['release_for_production'];
     $assigned_status = $data['assigned_status'];
     $machine_code = $data['mach_code'];
 
    
    $query = "update `tb_t_mach_check_h` set released_date = '$released_date',released_remarks = '$released_remarks',released_by = '$released_by',release_for_production ='$release_for_production',assigned_status = '$assigned_status' where ticket = '$ticket' and machine_check_h_code = '$machine_check_h_code'";

    
    $query1 = "UPDATE tb_t_mach_status_event SET  on_off_status = IF((SELECT COUNT(*)as cnt FROM `tb_t_mach_check_h` where machine_code ='$machine_code' and release_for_production = 'NO') > 0 , 0, 1) 
    WHERE mach_code = '$machine_code'";
     


    // prepare query statement
    $stmt = $this->conn->prepare($query);
    $stmt1 = $this->conn->prepare($query1);
  
    
    // execute query
    if ($stmt->execute() && $stmt1->execute() ) { 
        return $stmt = 1;
     } else {
        return $stmt = 0;
     }
    
   
}

public function msg_alrt(){
  
    $data = json_decode(file_get_contents('php://input'), true);
 
    $ticket = $data['ticket'];
    $machine_check_h_code = $data['machine_check_h_code'];
    

 
   $querych = "SELECT wc.wrk_ctr_desc dept,machine_desc mach,checklist_desc issue,op.frst_name raised_by,si.frst_name shift_inch,si.mobile   shift_inch_mob,me.frst_name mnt_eng FROM `tb_t_mach_check_h` ch
   join tb_m_employee op on op.emp_id = ch.reported_by 
   join tb_m_employee si on si.emp_id = ch.assigned_by
   join tb_m_employee me on me.emp_id = ch.assigned_me
   join tb_m_machine mc on mc.mach_code = ch.machine_code
   join tb_o_workcenter wc on wc.wrk_ctr_code = mc.wrk_ctr_code
   WHERE ch.ticket = '$ticket' and ch.machine_check_h_code = '$machine_check_h_code'";
 
    $querydf = "SELECT mobile from tb_m_employee 
    join tb_m_role_status on tb_m_role_status.role_code = tb_m_employee.role_code
    where tb_m_role_status.sms_to_sent = 1";
 
 
 $stmtch = $this->conn->prepare($querych);
 $stmtdf = $this->conn->prepare($querydf);
 
 $stmtch->execute();
 $stmtdf->execute();
 
 while ($row = $stmtch->fetch(PDO::FETCH_ASSOC)){
             
         extract($row);
         
             $dept=$dept;
             $mach=$mach;
             $issue=$issue; 
             $raised_by=$raised_by;
             $shift_inch=$shift_inch; 
             $shift_inch_mob=$shift_inch_mob; 
             $mnt_eng=$mnt_eng;
          
 }
 
 while ($row = $stmtdf->fetch(PDO::FETCH_ASSOC)){
             
    extract($row);
    
       //  $mobile=$mobile;
 
        $numbers[] = $mobile;
    
 }
 
 
 array_push($numbers, $shift_inch_mob);
 
 $numbers = implode(',', $numbers);
 
 $message = rawurlencode("Checklist Closed: Machine is Active,
                          Dept - ".$dept.",
                          Machine - ".$mach.",
                          Raised by - ".$raised_by.",
                          Closed by - ".$mnt_eng."");



                          
$apiKey = urlencode('y4l4dYnvGVg-67LoH1o3ohcj3MQEeyCEzvSXF45V85');
//	// Message details
$numbers = $numbers;
$sender = urlencode('TXTLCL');

//	$numbers = implode(',', $numbers);

// Prepare data for POST request
$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

// Send the POST request with cURL
$ch = curl_init('https://api.textlocal.in/send/');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
   
curl_close($ch);

// Process your response here
return $response;

}
 
 

}
