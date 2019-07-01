<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Multi_selection.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Multi_selection = new Multi_selection($db);

// query products
$stmt = $Multi_selection->read();
$num = $stmt->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // products array
    $Multi_selection_arr=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Multi_selection_item=array(
            "Batch_no" => $batch_no,
            "Size"=> $fg_code,
            "type"=> $type,
            "Customer"=> $cust_name,
            "Plan"=> $plan,
            "plan_desc"=> $plan_desc,
            "Current_dept"=> $to_dept_desc,
            "ack_status"=> $ack_status,
            "Team_lead"=> $team_lead,
            "Team_lead_id"=> $team_lead_id,
            "Operator"=> $operator,
            "Operator_id"=> $operator_id,
            "Updated_at"=> $updated_at,
        
        );
 
        array_push($Multi_selection_arr, $Multi_selection_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($Multi_selection_arr);
}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

