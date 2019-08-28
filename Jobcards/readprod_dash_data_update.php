<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Prod_dash_data_update.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Prod_dash_data_update = new Prod_dash_data_update($db);

// query products
$stmt = $Prod_dash_data_update->read();

// check if more than 0 record found
if($stmt == 0){
    $status['status'] = 0;
    $status['message'] ='There is No Data for Selected Date And Data Not Updated Successfully ';
    echo json_encode($status);
}elseif($stmt == 1){
    $status['status'] = 1;
    $status['message'] ='There is No Data for Selected Date And Data Updated Successfully ';
    echo json_encode($status);
}else{
    $status['status'] = 2;
    $status['message'] ='There is Data for Selected Date';
    echo json_encode($status);
}

