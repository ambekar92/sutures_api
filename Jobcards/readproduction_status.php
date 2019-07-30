<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Production_status.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Production_status = new Production_status($db);

// query products
$stmt = $Production_status->read();
$stmt1 = $Production_status->read1();
$num = $stmt->rowCount();
$num1 = $stmt1->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // products array
    $Production_status_arr=array();
    $Production_status_arr1=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

       $batch=explode("_",$batch_no);
       //print_r($batch);
       $batch_number=$batch[0];
 
        $Production_status_item=array(
            "fg_code" =>$fg_code,
            "ord_qty" =>$ord_qty,
            "cust_name" =>$cust_name,
            "req_date" =>$req_date,
            "plan" =>$plan,
            "plan_type" =>$plan_desc,
            "type" =>$type,
            "batch_no" =>$batch_no,
            "batch" =>$batch_number,
            "op_qty" =>$op_qty,
            "STRAIGHT_CUT" =>$STRAIGHT_CUT,
            "ROUGH_POINTING" =>$ROUGH_POINTING,
            "ENDCUT" =>$ENDCUT,
            "CENTERING" =>$CENTERING ,
            "CENTER_CHECK" =>$CENTER_CHECK ,
            "MICRO_CENTERING" =>$MICRO_CENTERING,
            "MICRO_CENTRE_CHECK" =>$MICRO_CENTRE_CHECK,
            "MICRO_DRILLING" =>$MICRO_DRILLING,
            "MICRO_GAUGE_CHECK" =>$MICRO_GAUGE_CHECK,
            "DRILLING" =>$DRILLING,
            "GAUGE_CHECK" =>$GAUGE_CHECK,
            "PRESS" =>$PRESS,
            "MANUAL_GRINDING" =>$MANUAL_GRINDING,
            "AUTO_GRINDING" =>$AUTO_GRINDING ,
            "AUTO_GRINDING_INSPECTION" =>$AUTO_GRINDING_INSPECTION ,
            "BENDING" =>$BENDING,
            "BENDING_INSPECTION" =>$BENDING_INSPECTION,
            "HARDENING_TEMPERING" =>$HARDENING_TEMPERING,
            "MICRO" =>$MICRO,
            "INSPECTION" =>$INSPECTION,
            "PACKING_LABELLING" =>$PACKING_LABELLING,
            "EDM" =>$EDM,
            "color" =>$color,
            "completed" =>$completed,
        );
 
        array_push($Production_status_arr, $Production_status_item);
    }

    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $batch=explode("_",$batch_no);
       //print_r($batch);
        $batch_number=$batch[0];

        $Production_status_item1=array(
            "fg_code" =>$fg_code,
            "ord_qty" =>$ord_qty,
            "cust_name" =>$cust_name,
            "req_date" =>$req_date,
            "plan" =>$plan,
            "plan_type" =>$plan_desc,
            "type" =>$type,
            "batch_no" =>$batch_no,
            "batch" =>$batch_number,
            "op_qty" =>$op_qty,
            "STRAIGHT_CUT" =>$STRAIGHT_CUT,
            "ROUGH_POINTING" =>$ROUGH_POINTING,
            "ENDCUT" =>$ENDCUT,
            "CENTERING" =>$CENTERING ,
            "CENTER_CHECK" =>$CENTER_CHECK ,
            "MICRO_CENTERING" =>$MICRO_CENTERING,
            "MICRO_CENTRE_CHECK" =>$MICRO_CENTRE_CHECK,
            "MICRO_DRILLING" =>$MICRO_DRILLING,
            "MICRO_GAUGE_CHECK" =>$MICRO_GAUGE_CHECK,
            "DRILLING" =>$DRILLING,
            "GAUGE_CHECK" =>$GAUGE_CHECK,
            "PRESS" =>$PRESS,
            "MANUAL_GRINDING" =>$MANUAL_GRINDING,
            "AUTO_GRINDING" =>$AUTO_GRINDING ,
            "AUTO_GRINDING_INSPECTION" =>$AUTO_GRINDING_INSPECTION ,
            "BENDING" =>$BENDING,
            "BENDING_INSPECTION" =>$BENDING_INSPECTION,
            "HARDENING_TEMPERING" =>$HARDENING_TEMPERING,
            "MICRO" =>$MICRO,
            "INSPECTION" =>$INSPECTION,
            "PACKING_LABELLING" =>$PACKING_LABELLING,
            "EDM" =>$EDM,
        );

      //  print_r($Production_status_item1);
 
        array_push($Production_status_arr1, $Production_status_item1);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    $status['date'] =$Production_status_arr;
    $status['qty'] =$Production_status_arr1;
    echo json_encode($status);
}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found

    $status['date'] =[];
    $status['qty'] =[];
    $status['message'] ="No products found.";
    echo json_encode($status);
    
}

