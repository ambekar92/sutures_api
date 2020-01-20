<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Batch_status_update.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Batch_status_update = new Batch_status_update($db);

// query products
$stmt = $Batch_status_update->read();



// check if more than 0 record found
if($stmt != 0){
    // $alert_msg = $Batch_status_update->msg_alrt();
    $status['status'] = 1;
    $status['message'] ='data updated successfully';
    // $status['txt_msg_status'] = $alert_msg;
    echo json_encode($status);
}else{
    $status['status'] = 0;
    $status['message'] ='data not updated successfully';
    echo json_encode($status);
}

