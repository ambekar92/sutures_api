<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Employee_dur.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$employee_dur = new employee_dur($db);

// query products
$stmt = $employee_dur->read();
$num = $stmt->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // products array
    $employee_dur_arr=array();
   
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $employee_dur_item=array(
            "Employee" => $name,
            "Employee_dept" => $empname,
            "Department" =>$wrk_ctr_desc,
            "Ok_Qnty" => $qty,
            "duration" => $diff,
        );
 
        array_push($employee_dur_arr, $employee_dur_item);
    }
 
    // set response code - 200 OK
    //http_response_code(200);
 
    // show products data in json format
    echo json_encode($employee_dur_arr);
}else{
 
    // set response code - 404 Not found
    //http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Details found.")
    );
}

