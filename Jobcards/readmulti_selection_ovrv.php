<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Multi_selection_ovrv.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$multi_selection_ovrv = new multi_selection_ovrv($db);

// query products
$stmt = $multi_selection_ovrv->read();
$num = $stmt->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // products array
    $multi_selection_ovrv_arr=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $multi_selection_ovrv_item=array(
            "wrk_ctr_code" => $wrk_ctr_code,
            "wrk_ctr_desc" => $wrk_ctr_desc,
            "Ack_not_started"    => $Ack_not_started,
            "Completed_not_ack"=> $Completed_not_ack,
            "currently_running"=> $currently_running,
            "paused"=> $paused,
        );
 
        array_push($multi_selection_ovrv_arr, $multi_selection_ovrv_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($multi_selection_ovrv_arr);
}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

