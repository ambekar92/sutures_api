<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Assign_update.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Assign_update = new Assign_update($db);

// query products
$stmt = $Assign_update->read();



// check if more than 0 record found
if($stmt != 0){
    // $alert_msg = $Assign_update->msg_alrt();
    $status['status'] = 1;
    $status['message'] ='data updated successfully';
    // $status['txt_msg_status'] = $alert_msg;
    echo json_encode($status);
}else{
    $status['status'] = 0;
    $status['message'] ='data not updated successfully';
    echo json_encode($status);
}

