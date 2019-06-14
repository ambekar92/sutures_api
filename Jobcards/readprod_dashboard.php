<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Production_dashboard.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Production_dashboard = new Production_dashboard($db);

// query products
$stmt = $Production_dashboard->read();
$stmt1 = $Production_dashboard->read1();
$num = $stmt->rowCount();
$num1 = $stmt1->rowCount();

 
// check if more than 0 record found
if($num>0 && $num1>0 ){
    // products array
   // $Prod_data_sheet_arr=array();
    //$Prod_data_sheet_arr1=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Assign_checklist_item[]=array(
            "urgent_rb"=> $urgent_RB,
            "urgent_ct"=> $urgent_CT,
            "regular_rb"=> $regular_RB,
            "regular_ct"=> $regular_CT,
         );
        //array_push($Prod_data_sheet_arr, $Prod_data_sheet_item);
    }
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Assign_checklist_item1[]=array(
            "urgent_rb"=> $urgent_RB,
            "urgent_ct"=> $urgent_CT,
            "regular_rb"=> $regular_RB,
            "regular_ct"=> $regular_CT,
         );
 
        //array_push($Prod_data_sheet_arr, $Prod_data_sheet_item1);
    }

    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    $status['completed'] =$Assign_checklist_item;
    $status['pending'] =$Assign_checklist_item1;
    echo json_encode($status);
}else{
    $status['completed'] =[];
    $status['pending'] =[];
    echo json_encode($status);
}

