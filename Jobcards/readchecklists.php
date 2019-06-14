<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Checklists.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Check_list = new Check_list($db);

// query products
$stmt = $Check_list->read();
$num = $stmt->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // products array
    $Check_list_arr=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Check_list_item=array(
            "Ticket" =>$ticket,
            "Machine_check_h_code" =>$machine_check_h_code,
            "Reported_date" =>$reported_date,
            "Department" =>$wrk_ctr_desc,
            "Machine" =>$machine_desc,
            "Machine_on_off_status" =>$on_off_status,
            "Checklist_desc" =>$checklist_desc,
            "Operator" =>$name,
            "Status" =>$state,
            "Closed_status" =>$c_state,
        );

        array_push($Check_list_arr, $Check_list_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($Check_list_arr);
}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

