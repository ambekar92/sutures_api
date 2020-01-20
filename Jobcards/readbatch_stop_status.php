<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Batch_stop_status.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Batch_stop_status = new Batch_stop_status($db);

// query products
$stmt = $Batch_stop_status->read();
$num = $stmt->rowCount();

 

if($num>0){
 
    // products array
    $Batch_stop_status_arr=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $Batch_stop_status_item=array(
            "batch_no" =>$batch_no,
            "fg_code" =>$fg_code,
            "plan" =>$plan,
            "cust_name" =>$cust_name,
            "ord_qty" =>$ord_qty,
            "wrk_ctr_desc" =>$wrk_ctr_desc,
            "updated_at" =>$updated_at,
            "batch_status" =>$batch_status,
            "batch_reason" =>$batch_reason,
            "batch_remarks" =>$batch_remarks,
            "prod_reas_descp" =>$prod_reas_descp,
            "batch_status_r" =>$batch_status_r,
            
        );
 
        array_push($Batch_stop_status_arr, $Batch_stop_status_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    $status['details'] =$Batch_stop_status_arr;
    echo json_encode($status);
}else{
 
    // set response code - 404 Not found
    //http_response_code(404);
 
    // tell the user no products found
    $status['details'] =[];
    $status['message'] ="No products found.";

    echo json_encode($status);
}

