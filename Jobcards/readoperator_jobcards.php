<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Operator_jobcards.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Operator_jobcards = new Operator_jobcards($db);

// query products
$stmt = $Operator_jobcards->read();
$num = $stmt->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // $data = json_decode(file_get_contents('php://input'), true);
    //     $emp_name = $data['emp_name'];
    // products array
    $Operator_jobcards_arr=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $efficiency = ((((($ok_qty + $rej_qty)*($target_duration_1 / 2100))*60)/($duration_1))*100);
 
        $Operator_jobcards_item=array(
            "emp_name" =>$frst_name,
            "batch_no" =>$batch_no,
            "fg_code" =>$fg_code,
            "wrk_ctr_desc" =>$wrk_ctr_desc,
            "wrk_ctr_code" =>$present_dept,
            "ok_qty" =>$ok_qty,
            "rej_qty" =>$rej_qty,
            "cons_qty" =>$cons_qty,
            "machine_desc" =>$mach_desc,
            "time_from" =>$start_time,
            "time_to" =>$end_time,
            "duration" =>$duration ,
            "target_duration" =>$target_duration ,
            "efficiency" =>round($efficiency,2)
        );
 
        array_push($Operator_jobcards_arr, $Operator_jobcards_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($Operator_jobcards_arr);

}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

