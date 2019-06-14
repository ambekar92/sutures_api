<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Machine_repo.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Machine_repo = new Machine_repo($db);

// query products
$stmt = $Machine_repo->read();
$num = $stmt->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // products array
    $Machine_repo_arr=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Machine_repo_item=array(
            "Machine" => $mach_desc,
            "Department"=> $wrk_ctr_desc,
            "Department_code"=> $wrk_ctr_code,
            "Jobcard"=> $batch_no,
            "Size"=> $fg_code,
            "ok_qty"=> $OK_QTY,
            "rej_qty"=> $REJ_QTY,
            "time_from"=> $time_from,
            "time_To"=> $time_To,
            "duration"=> $duration,
        
        );
 
        array_push($Machine_repo_arr, $Machine_repo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($Machine_repo_arr);
}else{
 
    // set response code - 404 Not found
    //http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

