<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Rejection_analysis_ovr.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Rejection_analysis_ovr = new Rejection_analysis_ovr($db);

// query products
$stmt = $Rejection_analysis_ovr->read();
// $stmt1 = $Rejection_analysis_data->read1();
$num = $stmt->rowCount();
// $num1 = $stmt1->rowCount();


// check if more than 0 record found
if($num>0){
 
    // products array
    $Rejection_analysis_ovr_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        // this will make $row['name'] to
        // just $name only
         
       extract($row);

        $Rejection_analysis_ovr_arr_item=array(
            "tot_batch_qty" =>$tot_batch_qty,
            "tot_batch_qty_doz" =>$tot_batch_qty_doz,
            "tot_apprvd_qty" =>$tot_apprvd_qty,
            "tot_apprvd_qty_doz" =>$tot_apprvd_qty_doz,
            "tot_apprvd_qty_per" =>$tot_apprvd_qty_per,
            "tot_rej" =>$tot_rej,
            "tot_rej_doz" =>$tot_rej_doz,
            "tot_rej_per" =>$tot_rej_per,
            "tot_batch_crd_issued" =>$tot_batch_crd_issued,
            "avg_yield" =>$avg_yield,
        );
 
        array_push($Rejection_analysis_ovr_arr, $Rejection_analysis_ovr_arr_item);
    }
    // set response code - 200 OK
    http_response_code(200);
    $status['data'] =$Rejection_analysis_ovr_arr;
    echo json_encode($status);
}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found

    $status['data'] =[];
    // $status['qty'] =[];
    $status['message'] ="No products found.";
    echo json_encode($status);
    
}

