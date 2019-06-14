<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Jobcard_reject.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$jobcard_rejec = new jobcard_rejec($db);

// query products
$stmt = $jobcard_rejec->read();
$num = $stmt->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // products array
    $jobcard_rejec_arr=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $jobcard_rejec_item=array(
            "Jobcard" => $batch_no,
            "Size" => $fg_code,
            "Department_code"=> $wrk_ctr_code,
            "Department"=> $wrk_ctr_desc,
            "Operator"=> $name,
            "Ok_Qnty"=> $OK_Qnty,
            "Reject_Qnty"=> $Reject_Qnty,
            "Rework_Qnty"=> $Rework_Qnty,
        );
 
        array_push($jobcard_rejec_arr, $jobcard_rejec_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($jobcard_rejec_arr);
}else{
 
    // set response code - 404 Not found
    //http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

