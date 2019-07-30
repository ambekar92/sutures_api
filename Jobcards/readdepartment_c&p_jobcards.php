<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Department_c&p_jobcards.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Department_cp_jobcards = new Department_cp_jobcards($db);

// query products
$stmt = $Department_cp_jobcards->read();
$num = $stmt->rowCount();

$stmt1 = $Department_cp_jobcards->read1();
 
if($stmt1 != 1){
// check if more than 0 record found
 if($num>0){
 
    // products array
    $Department_cp_jobcards=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Department_cp_jobcards_item=array(
            "Batch_no" => $batch_no,
            "Size"=> $fg_code,
            "Customer"=> $cust_name,
            "Plan"=> $plan,
            "Plan_type"=> $plan_desc,
            "req_date"=> $req_date,
            "req_type"=> $type,
            "updated_at"=> $updated_at,
        );
 
        array_push($Department_cp_jobcards, $Department_cp_jobcards_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($Department_cp_jobcards);
   }else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
   }
}else{
    if($num>0){
 
        // products array
        $Department_cp_jobcards=array();
       // $Jobcard_arr=array();
     
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Department_cp_jobcards_item=array(
                "wrk_ctr_code" => $wrk_ctr_code,
                "Batch_no" => $batch_no,
                "Size"=> $fg_code,
                "Customer"=> $cust_name,
                "Plan"=> $plan,
                "Plan_type"=> $plan_desc,
                "ok_qty"=> $ok_qty,
                "reject_qty"=> $reject_qty,
                "req_date"=> $req_date,
                "req_type"=> $type,
                "updated_at"=> $updated_at,
            );
            array_push($Department_cp_jobcards, $Department_cp_jobcards_item);
        }
     
        // set response code - 200 OK
        http_response_code(200);
     
        // show products data in json format
        echo json_encode($Department_cp_jobcards);
    }else{
     
        // set response code - 404 Not found
       // http_response_code(404);
     
        // tell the user no products found
        echo json_encode(
            array("message" => "No products found.")
        );
    }
}



