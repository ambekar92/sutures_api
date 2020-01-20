<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Batch_stop_status_reasons.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Batch_stop_status_reasons = new Batch_stop_status_reasons($db);

// query products
$stmt = $Batch_stop_status_reasons->read();
$num = $stmt->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // products array
    $Batch_stop_status_reasons_arr=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
     
        extract($row);

        $Batch_stop_status_reasons_item=array(
            "prod_reas_code" =>$prod_reas_code,
            "prod_reas_descp" =>$prod_reas_descp,
        );
 
        array_push($Batch_stop_status_reasons_arr, $Batch_stop_status_reasons_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // print_r($Batch_stop_status_reasons_arr);
    // show products data in json format
    echo json_encode( $Batch_stop_status_reasons_arr );
}else{
 
    // set response code - 404 Not found
    //http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

