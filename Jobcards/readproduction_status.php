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
    $Production_status_item1=array();
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
            "completed" =>$completed
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
            "Q_fg_code" =>$fg_code,
            "Q_ord_qty" =>$ord_qty,
            "Q_cust_name" =>$cust_name,
            "Q_req_date" =>$req_date,
            "Q_plan" =>$plan,
            "Q_plan_type" =>$plan_desc,
            "Q_type" =>$type,
            "Q_batch_no" =>$batch_no,
            "Q_batch" =>$batch_number,
            "Q_op_qty" =>$op_qty,
            "Q_STRAIGHT_CUT" =>$STRAIGHT_CUT,
            "Q_ROUGH_POINTING" =>$ROUGH_POINTING,
            "Q_ENDCUT" =>$ENDCUT,
            "Q_CENTERING" =>$CENTERING ,
            "Q_CENTER_CHECK" =>$CENTER_CHECK ,
            "Q_MICRO_CENTERING" =>$MICRO_CENTERING,
            "Q_MICRO_CENTRE_CHECK" =>$MICRO_CENTRE_CHECK,
            "Q_MICRO_DRILLING" =>$MICRO_DRILLING,
            "Q_MICRO_GAUGE_CHECK" =>$MICRO_GAUGE_CHECK,
            "Q_DRILLING" =>$DRILLING,
            "Q_GAUGE_CHECK" =>$GAUGE_CHECK,
            "Q_PRESS" =>$PRESS,
            "Q_MANUAL_GRINDING" =>$MANUAL_GRINDING,
            "Q_AUTO_GRINDING" =>$AUTO_GRINDING ,
            "Q_AUTO_GRINDING_INSPECTION" =>$AUTO_GRINDING_INSPECTION ,
            "Q_BENDING" =>$BENDING,
            "Q_BENDING_INSPECTION" =>$BENDING_INSPECTION,
            "Q_HARDENING_TEMPERING" =>$HARDENING_TEMPERING,
            "Q_MICRO" =>$MICRO,
            "Q_INSPECTION" =>$INSPECTION,
            "Q_PACKING_LABELLING" =>$PACKING_LABELLING,
            "Q_EDM" =>$EDM
        );

    //    print_r($Production_status_item1); 
     array_push($Production_status_arr1, $Production_status_item1);

    }

    for ($i = 0; $i < count($Production_status_arr); $i++) {

    $result[] = (array_merge_recursive($Production_status_arr[$i],$Production_status_arr1[$i]));   
 
    }

   // print_r(array_merge_recursive($Production_status_arr,$Production_status_arr1));
    // set response code - 200 OK
    http_response_code(200);
    // $status['count_date'] = count($Production_status_arr);
    // $status['count_qty'] =  count($Production_status_arr1);
    $status['data'] =$result;
    echo json_encode($status);
}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found

    $status['data'] =[];
    // $status['qty'] =[];
    $status['message'] ="No products found.";
    echo json_encode($status);
    
}

