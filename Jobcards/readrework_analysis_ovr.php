<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Rework_analysis_ovr.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Rework_analysis_ovr = new Rework_analysis_ovr($db);

// query products
$stmt = $Rework_analysis_ovr->read();
$stmt1 = $Rework_analysis_ovr->read1();
$num = $stmt->rowCount();
// $num1 = $stmt1->rowCount();



// check if more than 0 record found
if($num>0){

    if ($stmt1 == 1){

         // products array
    $Rework_analysis_ovr_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        // this will make $row['name'] to
        // just $name only
         
       extract($row);

        $Rework_analysis_ovr_arr_item=array(
            "tot_batch_qty" =>$tot_batch_qty,
            "tot_batch_qty_doz" =>round($tot_batch_qty/12,2),
            "tot_apprvd_qty" =>$tot_apprvd_qty,
            "tot_apprvd_qty_doz" =>round($tot_apprvd_qty/12,2),
            "tot_apprvd_qty_per" =>round(($tot_apprvd_qty/$tot_batch_qty)*100,2),
            "tot_rew" =>$tot_rew,
            "tot_rew_doz" =>round($tot_rew/12,2),
            "tot_rew_per" =>round(($tot_rew/$tot_batch_qty)*100,2),

            "RB_tot_batch_qty" =>$RB_tot_batch_qty,
            "RB_tot_batch_qty_doz" =>round($RB_tot_batch_qty/12,2),
            "RB_tot_apprvd_qty" =>$RB_tot_apprvd_qty,
            "RB_tot_apprvd_qty_doz" =>round($RB_tot_apprvd_qty/12,2),
            "RB_tot_apprvd_qty_per" =>round(($RB_tot_apprvd_qty/$RB_tot_batch_qty)*100,2),
            "RB_tot_rew" =>$RB_tot_rew,
            "RB_tot_rew_doz" =>round($RB_tot_rew/12,2),
            "RB_tot_rew_per" =>round(($RB_tot_rew/$RB_tot_batch_qty)*100,2),

            "CT_tot_batch_qty" =>$CT_tot_batch_qty,
            "CT_tot_batch_qty_doz" =>round($CT_tot_batch_qty/12,2),
            "CT_tot_apprvd_qty" =>$CT_tot_apprvd_qty,
            "CT_tot_apprvd_qty_doz" =>round($CT_tot_apprvd_qty/12,2),
            "CT_tot_apprvd_qty_per" =>round(($CT_tot_apprvd_qty/$CT_tot_batch_qty)*100,2),
            "CT_tot_rew" =>$CT_tot_rew,
            "CT_tot_rew_doz" =>round($CT_tot_rew/12,2),
            "CT_tot_rew_per" =>round(($CT_tot_rew/$CT_tot_batch_qty)*100,2),

            "tot_batch_crd_issued" =>$tot_batch_crd_issued,
            "avg_yield" =>round($avg_yield,2),
        );
 
        array_push($Rework_analysis_ovr_arr, $Rework_analysis_ovr_arr_item);
    }

    }else{
    // products array
    $Rework_analysis_ovr_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        // this will make $row['name'] to
        // just $name only
         
       extract($row);

        $Rework_analysis_ovr_arr_item=array(
            "tot_batch_qty" =>$tot_batch_qty,
            "tot_batch_qty_doz" =>round($tot_batch_qty_doz,2),
            "tot_apprvd_qty" =>$tot_apprvd_qty,
            "tot_apprvd_qty_doz" =>round($tot_apprvd_qty_doz,2),
            "tot_apprvd_qty_per" =>round($tot_apprvd_qty_per,2),
            "tot_rew" =>$tot_rew,
            "tot_rew_doz" =>round($tot_rew_doz,2),
            "tot_rew_per" =>round($tot_rew_per,2),
            "tot_batch_crd_issued" =>$tot_batch_crd_issued,
            "avg_yield" =>round($avg_yield,2),
        );
 
        array_push($Rework_analysis_ovr_arr, $Rework_analysis_ovr_arr_item);
    }
}

    // set response code - 200 OK
    http_response_code(200);
    $status['data'] =$Rework_analysis_ovr_arr;
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

