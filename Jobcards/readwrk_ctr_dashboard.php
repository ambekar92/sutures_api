<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Wrk_ctr_dashboard.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Wrk_ctr_dashboard = new Wrk_ctr_dashboard($db);

// query products
$stmt = $Wrk_ctr_dashboard->read();
$num = $stmt->rowCount();

$stmt1 = $Wrk_ctr_dashboard->read1();
$stmt2 = $Wrk_ctr_dashboard->read2();

 
if($stmt1 != 1){
// check if more than 0 record found
 if($num>0){
 
    // products array
    $Wrk_ctr_dashboard=array();
    $Wrk_ctr_dashboard1=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Wrk_ctr_dashboard_item=array(
            "wrk_ctr_code" => $wrk_ctr_code,
            "wrk_ctr_desc"=> $wrk_ctr_desc,
            "machine"=> $machine,
            "U_pending_cards"=> $U_pending_cards,
            "R_pending_cards"=> $R_pending_cards,
            "U_completed_cards"=> $U_completed_cards,
            "R_completed_cards"=> $R_completed_cards,
            "ok_qty"=> $ok_qty,
            "rej_qty"=> $rej_qty,
        );
 
        array_push($Wrk_ctr_dashboard, $Wrk_ctr_dashboard_item);
    }

    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Wrk_ctr_dashboard_item1=array(
            "wrk_ctr_code"=> $wrk_ctr_code,
            "daily_target"=> $daily_target,
            "completed_cards"=> $completed_cards,
        
        );
 
        array_push($Wrk_ctr_dashboard1, $Wrk_ctr_dashboard_item1);
    }
 

    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    $status['header'] =$Wrk_ctr_dashboard1;
    $status['details'] =$Wrk_ctr_dashboard;
    echo json_encode($status);
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
        $Wrk_ctr_dashboard=array();
       // $Jobcard_arr=array();
     
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Wrk_ctr_dashboard_item=array(
                "mach_code" => $mach_code,
                "wrk_ctr_code"=> $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "mach_desc"=> $mach_desc,
                "batch_no"=> $batch_no,
                "fg_code"=> $fg_code,
                "operator"=> $operator,
                "on_off"=> $on_off,
                "ok_qty"=> $ok_qty,
                "rej_qty"=> $rej_qty,
            );
     
            array_push($Wrk_ctr_dashboard, $Wrk_ctr_dashboard_item);
        }
     
        // set response code - 200 OK
        http_response_code(200);
     
        // show products data in json format
        echo json_encode($Wrk_ctr_dashboard);
    }else{
     
        // set response code - 404 Not found
       // http_response_code(404);
     
        // tell the user no products found
        echo json_encode(
            array("message" => "No products found.")
        );
    }
}



