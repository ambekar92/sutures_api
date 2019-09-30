<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Rejection_analysis.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Rejection_analysis = new Rejection_analysis($db);

// query products
$stmt1 = $Rejection_analysis->read();
$num1 = count($stmt1);

// check if more than 0 record found
if($num1>0){
 
    echo json_encode($stmt1);

}else{
 
    $status['header'] =[];
    $status['reasons'] =[];
    $status['message'] ="No products found.";
    echo json_encode($status);
    
}

