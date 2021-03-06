<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Rework_analysis_dept.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Rework_analysis_dept = new Rework_analysis_dept($db);

// query products
$stmt = $Rework_analysis_dept->read();
$stmt1 = $Rework_analysis_dept->read1();
$num = $stmt->rowCount();
// $num1 = $stmt1->rowCount();


// check if more than 0 record found
if($num>0){
 
    // products array
    $Rework_analysis_dept_arr=array();
    $Rework_analysis_dept_arr1=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        // this will make $row['name'] to
        // just $name only
         
       extract($row);

        // $Rework_analysis_dept_arr_item=array(
        //     "date" =>$datee,
        //     "batch_no" =>$batch_no,
        //     "fg_code" =>$fg_code,
        //     "type" =>$type,
        //     "st_qty" =>$st_qty,
        //     "apprvd_qty" =>$apprvd_qty,
        //     "tot_rew" => ($st_qty - $apprvd_qty) ,
        //     "inprocess_rew" =>(($st_qty - $apprvd_qty)-($final_insp_rew)),
        //     "final_insp_rew" =>$final_insp_rew,
        //     "yield" =>$yield,

        //     "STRAIGHT_CUT" =>$STRAIGHT_CUT,
        //     "ROUGH_POINTING" =>$ROUGH_POINTING,
        //     "ENDCUT" =>$ENDCUT,
        //     "CENTERING" =>$CENTERING ,
        //     "CENTER_CHECK" =>$CENTER_CHECK ,
        //     "MICRO_CENTERING" =>$MICRO_CENTERING,
        //     "MICRO_CENTRE_CHECK" =>$MICRO_CENTRE_CHECK,
        //     "MICRO_DRILLING" =>$MICRO_DRILLING,
        //     "MICRO_GAUGE_CHECK" =>$MICRO_GAUGE_CHECK,
        //     "DRILLING" =>$DRILLING,
        //     "GAUGE_CHECK" =>$GAUGE_CHECK,
        //     "PRESS" =>$PRESS,
        //     "MANUAL_GRINDING" =>$MANUAL_GRINDING,
        //     "AUTO_GRINDING" =>$AUTO_GRINDING ,
        //     "AUTO_GRINDING_INSPECTION" =>$AUTO_GRINDING_INSPECTION ,
        //     "BENDING" =>$BENDING,
        //     "BENDING_INSPECTION" =>$BENDING_INSPECTION,
        //     "HARDENING_TEMPERING" =>$HARDENING_TEMPERING,
        //     "MICRO" =>$MICRO,
        //     "INSPECTION" =>$INSPECTION,
        //     "PACKING_LABELLING" =>$PACKING_LABELLING,
        //     "EDM" =>$EDM,
        // );
 
        $Rework_analysis_dept_arr_item=array(
                $datee,
                $batch_no,
                $fg_code,
                $type,
                $st_qty,
                $apprvd_qty,
                $tot_rew,
                $final_insp_rew,
                $inprocess_rew = (((int)$tot_rew -(int)$final_insp_rew)),
                $yield,
    
                $STRAIGHT_CUT,
                $ROUGH_POINTING,
                $ENDCUT,
                $CENTERING ,
                $CENTER_CHECK ,
                $MICRO_CENTERING,
                $MICRO_CENTRE_CHECK,
                $MICRO_DRILLING,
                $MICRO_GAUGE_CHECK,
                $DRILLING,
                $GAUGE_CHECK,
                $PRESS,
                $MANUAL_GRINDING,
                $AUTO_GRINDING ,
                $AUTO_GRINDING_INSPECTION ,
                $BENDING,
                $BENDING_INSPECTION,
                $HARDENING_TEMPERING,
                $MICRO,
                $INSPECTION,
                $PACKING_LABELLING,
                $EDM,
            );

        array_push($Rework_analysis_dept_arr, $Rework_analysis_dept_arr_item);
    }

    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        // this will make $row['name'] to
        // just $name only
         
       extract($row);

        // $Rework_analysis_dept_arr_item=array(
        //     "date" =>$datee,
        //     "batch_no" =>$batch_no,
        //     "fg_code" =>$fg_code,
        //     "type" =>$type,
        //     "st_qty" =>$st_qty,
        //     "apprvd_qty" =>$apprvd_qty,
        //     "tot_rew" => ($st_qty - $apprvd_qty) ,
        //     "inprocess_rew" =>(($st_qty - $apprvd_qty)-($final_insp_rew)),
        //     "final_insp_rew" =>$final_insp_rew,
        //     "yield" =>$yield,

        //     "STRAIGHT_CUT" =>$STRAIGHT_CUT,
        //     "ROUGH_POINTING" =>$ROUGH_POINTING,
        //     "ENDCUT" =>$ENDCUT,
        //     "CENTERING" =>$CENTERING ,
        //     "CENTER_CHECK" =>$CENTER_CHECK ,
        //     "MICRO_CENTERING" =>$MICRO_CENTERING,
        //     "MICRO_CENTRE_CHECK" =>$MICRO_CENTRE_CHECK,
        //     "MICRO_DRILLING" =>$MICRO_DRILLING,
        //     "MICRO_GAUGE_CHECK" =>$MICRO_GAUGE_CHECK,
        //     "DRILLING" =>$DRILLING,
        //     "GAUGE_CHECK" =>$GAUGE_CHECK,
        //     "PRESS" =>$PRESS,
        //     "MANUAL_GRINDING" =>$MANUAL_GRINDING,
        //     "AUTO_GRINDING" =>$AUTO_GRINDING ,
        //     "AUTO_GRINDING_INSPECTION" =>$AUTO_GRINDING_INSPECTION ,
        //     "BENDING" =>$BENDING,
        //     "BENDING_INSPECTION" =>$BENDING_INSPECTION,
        //     "HARDENING_TEMPERING" =>$HARDENING_TEMPERING,
        //     "MICRO" =>$MICRO,
        //     "INSPECTION" =>$INSPECTION,
        //     "PACKING_LABELLING" =>$PACKING_LABELLING,
        //     "EDM" =>$EDM,
        // );
 
        $Rework_analysis_dept_arr_item1=array(
                $datee,
                $batch_no,
                $fg_code,
                $type,
                $st_qty,
                $apprvd_qty,
                $tot_rew,
                $final_insp_rew,
                $inprocess_rew = (((int)$tot_rew -(int)$final_insp_rew)),
                $yield,
    
                $STRAIGHT_CUT,
                $ROUGH_POINTING,
                $ENDCUT,
                $CENTERING ,
                $CENTER_CHECK ,
                $MICRO_CENTERING,
                $MICRO_CENTRE_CHECK,
                $MICRO_DRILLING,
                $MICRO_GAUGE_CHECK,
                $DRILLING,
                $GAUGE_CHECK,
                $PRESS,
                $MANUAL_GRINDING,
                $AUTO_GRINDING ,
                $AUTO_GRINDING_INSPECTION ,
                $BENDING,
                $BENDING_INSPECTION,
                $HARDENING_TEMPERING,
                $MICRO,
                $INSPECTION,
                $PACKING_LABELLING,
                $EDM,
            );

        array_push($Rework_analysis_dept_arr1, $Rework_analysis_dept_arr_item1);
    }

    $result = array_merge($Rework_analysis_dept_arr1,$Rework_analysis_dept_arr);

    // set response code - 200 OK
    http_response_code(200);

    $status['data'] =$result;
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

