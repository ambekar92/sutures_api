<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Oee_dashboard_mach.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Oee_dashboard_mach = new Oee_dashboard_mach($db);

// query products
$stmt = $Oee_dashboard_mach->read();
$num = $stmt->rowCount();

// check if more than 0 record found
 if($num>0){
    // products array
    $Oee_dashboard=array();
   
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_dashboard_item=array(
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "mach_code"=> $mach_code,
                "mach_desc"=> $mach_desc,
                "batch_no"=> $batch_no,
                "fg_code"=> $fg_code,
                "operator"=> $operator,
                "operator_id"=> $operator_id,
                "plnd_prod_time"=> $plnd_prod_time,
                "run_time"=> $run_time,
                "idle_time"=> $idle_time,
                "target_prod"=> $target_prod,
                "actual_prod"=> $actual_prod,
                "total_count"=> $total_count,
                "ok_qty"=> $ok_qty,
                "rej_qty"=> $rej_qty,
                "availability_perc"=> $availability_perc,
                "performance_perc"=> $performance_perc,
                "quality_perc"=> $quality_perc,
                "oee_perc "=> $oee_perc,

            );
    
    
     
            array_push($Oee_dashboard, $Oee_dashboard_item);
        }
    

    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    $status[] =$Oee_dashboard;
    echo json_encode($status);
}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );


}



