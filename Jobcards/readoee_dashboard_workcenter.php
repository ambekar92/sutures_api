<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Oee_dashboard_wokcenter.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Oee_dashboard_workcenter = new Oee_dashboard_workcenter($db);

// query products
$stmt = $Oee_dashboard_workcenter->read();
$stmt1 = $Oee_dashboard_workcenter->read1();
$num = $stmt->rowCount();




// check if more than 0 record found
 if($num>0){
    // products array
    $Oee_dashboard=array();
    $Oee_dashboard1=array();
   
   
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_dashboard_item=array(
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "mach_code"=> $mach_code,
                "availability_perc"=> $availability_perc,
                "performance_perc"=> $performance_perc,
                "quality_perc"=> $quality_perc,
                "oee_perc "=> $oee_perc,
            );
    

            array_push($Oee_dashboard, $Oee_dashboard_item);
        }

        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_dashboard_item=array(
                "availability_perc"=> $availability_perc,
                "performance_perc"=> $performance_perc,
                "quality_perc"=> $quality_perc,
                "oee_perc "=> $oee_perc,
            );
    

            array_push($Oee_dashboard1, $Oee_dashboard_item);
        }

    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    $status['machine'] =$Oee_dashboard;
    $status['work_center'] =$Oee_dashboard1;
    echo json_encode($status);
}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );


}



