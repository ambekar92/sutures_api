<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Addemployee.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Addemployee = new Addemployee($db);

// query products
$stmt = $Addemployee->read();



// check if more than 0 record found
if($stmt == 1){
    $status['status'] = 1;
    $status['message'] ='Employee data updated successfully';
    echo json_encode($status);
}else{
    $status['status'] = 0;
    $status['message'] = $stmt;
    echo json_encode($status);
}

