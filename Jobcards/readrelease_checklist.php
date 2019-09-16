<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Release_checklist.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Release_checklist = new Release_checklist($db);

// query products
$stmt = $Release_checklist->read();

// check if more than 0 record found
if($stmt != 0){
    // $alert_msg = $Release_checklist->msg_alrt();
    $status['status'] = 1;
    $status['message'] ='data updated successfully';
    // $status['txt_msg_status'] = $alert_msg;
    echo json_encode($status);
}else{
    $status['status'] = 0;
    $status['message'] ='data not updated successfully';
    echo json_encode($status);
}

