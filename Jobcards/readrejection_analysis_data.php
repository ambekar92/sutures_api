<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Rejection_analysis_data.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Rejection_analysis_data = new Rejection_analysis_data($db);

// query products
$stmt = $Rejection_analysis_data->read();
// $stmt1 = $Rejection_analysis_data->read1();
$num = $stmt->rowCount();
// $num1 = $stmt1->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // products array
    $Rejection_analysis_data_arr=array();
    $Rejection_analysis_data_arr1=array();
    $Rejection_analysis_data_item1=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        // this will make $row['name'] to
        // just $name only
         
       extract($row);

        // $Rejection_analysis_data_item=array(
        //     "date" =>$datee,
        //     "batch_no" =>$batch_no,
        //     "fg_code" =>$fg_code,
        //     "type" =>$type,
        //     "st_qty" =>$st_qty,
        //     "apprvd_qty" =>$apprvd_qty,
        //     "tot_rej" =>$tot_rej,
        //     "final_insp_rej" =>$final_insp_rej,
        //     "yield" =>$yield,
        //     "STRAIGHT_CUT_Bend" =>$STRAIGHT_CUT_Bend,
        //     "STRAIGHT_CUT_Length_Short" =>$STRAIGHT_CUT_Length_Short,
        //     "ROUGH_POINTING_Bend" =>$ROUGH_POINTING_Bend,
        //     "ROUGH_POINTING_Tip_sharp" =>$ROUGH_POINTING_Tip_sharp,
        //     "ENDCUT_cross_cut" =>$ENDCUT_cross_cut ,
        //     "ENDCUT_Length_short" =>$ENDCUT_Length_short ,
        //     "CENTERING_Eccentricity" =>$CENTERING_Eccentricity,
        //     "CENTERING_Pad_Mark" =>$CENTERING_Pad_Mark,
        //     "CENTERING_Bend" =>$CENTERING_Bend,
        //     "CENTERING_Depth" =>$CENTERING_Depth,
        //     "CENTER_CHECK_Eccentricity" =>$CENTER_CHECK_Eccentricity,
        //     "CENTER_CHECK_Pad_Mark" =>$CENTER_CHECK_Pad_Mark,
        //     "CENTER_CHECK_Bend" =>$CENTER_CHECK_Bend,
        //     "CENTER_CHECK_Depth" =>$CENTER_CHECK_Depth,
        //     "MICRO_CENTERING_Eccentricity" =>$MICRO_CENTERING_Eccentricity ,
        //     "MICRO_CENTERING_Pad_Mark" =>$MICRO_CENTERING_Pad_Mark ,
        //     "MICRO_CENTERING_Bend" =>$MICRO_CENTERING_Bend,
        //     "MICRO_CENTERING_Depth" =>$MICRO_CENTERING_Depth,
        //     "MICRO_CENTRE_CHECK_Eccentricity" =>$MICRO_CENTRE_CHECK_Eccentricity,
        //     "MICRO_CENTRE_CHECK_Pad_Mark" =>$MICRO_CENTRE_CHECK_Pad_Mark,
        //     "MICRO_CENTRE_CHECK_Bend" =>$MICRO_CENTRE_CHECK_Bend,
        //     "MICRO_CENTRE_CHECK_Depth" =>$MICRO_CENTRE_CHECK_Depth,
        //     "MICRO_DRILLING_Eccentricity" =>$MICRO_DRILLING_Eccentricity,
        //     "MICRO_DRILLING_Side_Drill" =>$MICRO_DRILLING_Side_Drill,
        //     "MICRO_DRILLING_Bend" =>$MICRO_DRILLING_Bend,
        //     "MICRO_DRILLING_Depth" =>$MICRO_DRILLING_Depth,
        //     "MICRO_DRILLING_GONOGO" =>$MICRO_DRILLING_GONOGO,
        //     "MICRO_GAUGE_CHECK_Eccentricity" =>$MICRO_GAUGE_CHECK_Eccentricity,
        //     "MICRO_GAUGE_CHECK_Side_Drill" =>$MICRO_GAUGE_CHECK_Side_Drill,
        //     "MICRO_GAUGE_CHECK_Bend" =>$MICRO_GAUGE_CHECK_Bend,
        //     "MICRO_GAUGE_CHECK_Depth" =>$MICRO_GAUGE_CHECK_Depth,
        //     "MICRO_GAUGE_CHECK_GONOGO" =>$MICRO_GAUGE_CHECK_GONOGO,
        //     "DRILLING_Eccentricity" =>$DRILLING_Eccentricity,
        //     "DRILLING_Side_Drill" =>$DRILLING_Side_Drill,
        //     "DRILLING_Bend" =>$DRILLING_Bend,
        //     "DRILLING_Depth" =>$DRILLING_Depth,
        //     "DRILLING_GONOGO" =>$DRILLING_GONOGO,
        //     "GAUGE_CHECK_Eccentricity" =>$GAUGE_CHECK_Eccentricity,
        //     "GAUGE_CHECK_Side_Drill" =>$GAUGE_CHECK_Side_Drill,
        //     "GAUGE_CHECK_Bend" =>$GAUGE_CHECK_Bend,
        //     "GAUGE_CHECK_Depth" =>$GAUGE_CHECK_Depth,
        //     "GAUGE_CHECK_GONOGO" =>$GAUGE_CHECK_GONOGO,
        //     "PRESS_Die_Mark" =>$PRESS_Die_Mark,
        //     "PRESS_Dia" =>$PRESS_Dia,
        //     "PRESS_Cross" =>$PRESS_Cross,
        //     "PRESS_Angle" =>$PRESS_Angle,
        //     "PRESS_Tip_Bend" =>$PRESS_Tip_Bend,
        //     "MANUAL_GRINDING_Length_Short" =>$MANUAL_GRINDING_Length_Short,
        //     "MANUAL_GRINDING_Thick" =>$MANUAL_GRINDING_Thick,
        //     "MANUAL_GRINDING_Thin" =>$MANUAL_GRINDING_Thin,
        //     "MANUAL_GRINDING_Not_Close" =>$MANUAL_GRINDING_Not_Close,
        //     "MANUAL_GRINDING_Line_Cross" =>$MANUAL_GRINDING_Line_Cross,
        //     "AUTO_GRINDING_Length_Short" =>$AUTO_GRINDING_Length_Short,
        //     "AUTO_GRINDING_Thick" =>$AUTO_GRINDING_Thick,
        //     "AUTO_GRINDING_Thin" =>$AUTO_GRINDING_Thin,
        //     "AUTO_GRINDING_Not_Close" =>$AUTO_GRINDING_Not_Close,
        //     "AUTO_GRINDING_Line_Cross" =>$AUTO_GRINDING_Line_Cross,
        //     "AUTO_GRINDING_INSPECTION_Length_Short" =>$AUTO_GRINDING_INSPECTION_Length_Short,
        //     "AUTO_GRINDING_INSPECTION_Thick" =>$AUTO_GRINDING_INSPECTION_Thick,
        //     "AUTO_GRINDING_INSPECTION_Thin" =>$AUTO_GRINDING_INSPECTION_Thin,
        //     "AUTO_GRINDING_INSPECTION_Not_Close" =>$AUTO_GRINDING_INSPECTION_Not_Close,
        //     "AUTO_GRINDING_INSPECTION_Line_Cross" =>$AUTO_GRINDING_INSPECTION_Line_Cross,
        //     "BENDING_Twist" =>$BENDING_Twist,
        //     "BENDING_Profile" =>$BENDING_Profile,
        //     "BENDING_Tip_Bend" =>$BENDING_Tip_Bend,
        //     "BENDING_Bore_Buldge" =>$BENDING_Bore_Buldge,
        //     "BENDING_Line_Cross" =>$BENDING_Line_Cross,
        //     "BENDING_INSPECTION_Twist" =>$BENDING_INSPECTION_Twist,
        //     "BENDING_INSPECTION_Round_Bend" =>$BENDING_INSPECTION_Round_Bend,
        //     "BENDING_INSPECTION_Open" =>$BENDING_INSPECTION_Open,
        //     "BENDING_INSPECTION_Close" =>$BENDING_INSPECTION_Close,
        //     "BENDING_INSPECTION_Profile" =>$BENDING_INSPECTION_Profile,
        //     "BENDING_INSPECTION_Tip_Bend" =>$BENDING_INSPECTION_Tip_Bend,
        //     "HARDENING__TEMPERING_Turns_to_Cut" =>$HARDENING__TEMPERING_Turns_to_Cut,
        //     "HARDENING__TEMPERING_Turns_to_Cut" =>$HARDENING__TEMPERING_Turns_to_Cut,
        //     "MICRO_Finish" =>$MICRO_Finish,
        //     "MICRO_pit_mark" =>$MICRO_pit_mark,
        //     "MICRO_Dia" =>$MICRO_Dia,
        //     "MICRO_Flash" =>$MICRO_Flash, 
        //     "MICRO_Point_Bend" =>$MICRO_Point_Bend,
        //     "INSPECTION_Twist" =>$INSPECTION_Twist,
        //     "INSPECTION_Pit_mark" =>$INSPECTION_Pit_mark,
        //     "INSPECTION_Bore_buldge" =>$INSPECTION_Bore_buldge,
        //     "INSPECTION_Dia" =>$INSPECTION_Dia,
        //     "INSPECTION_Eccentric" =>$INSPECTION_Eccentric,
        //     "INSPECTION_Faulty_Finish" =>$INSPECTION_Faulty_Finish,
        //     "INSPECTION_GO__NO_GO" =>$INSPECTION_GO__NO_GO,
        //     "INSPECTION_Depth" =>$INSPECTION_Depth,
        //     "INSPECTION_Point" =>$INSPECTION_Point,
        //     "PACKING_LABELLING" =>$PACKING_LABELLING,
        //     "EDM" =>$EDM,
        // );

        $Rejection_analysis_data_item=array(
            $datee,
            $batch_no,
            $fg_code,
            $type,
            $st_qty,
            $apprvd_qty,
            $tot_rej = ($st_qty - $apprvd_qty) ,
            $final_insp_rej,
            $inprocess_rej = (((int)$st_qty - (int)$apprvd_qty)-((int)$final_insp_rej)),
            $yield,
            $STRAIGHT_CUT_Bend,
            $STRAIGHT_CUT_Length_Short,
            $ROUGH_POINTING_Bend,
            $ROUGH_POINTING_Tip_sharp,
            $ENDCUT_cross_cut ,
            $ENDCUT_Length_short ,
            $CENTERING_Eccentricity,
            $CENTERING_Pad_Mark,
            $CENTERING_Bend,
            $CENTERING_Depth,
            $CENTER_CHECK_Eccentricity,
            $CENTER_CHECK_Pad_Mark,
            $CENTER_CHECK_Bend,
            $CENTER_CHECK_Depth,
            $MICRO_CENTERING_Eccentricity ,
            $MICRO_CENTERING_Pad_Mark ,
            $MICRO_CENTERING_Bend,
            $MICRO_CENTERING_Depth,
            $MICRO_CENTRE_CHECK_Eccentricity,
            $MICRO_CENTRE_CHECK_Pad_Mark,
            $MICRO_CENTRE_CHECK_Bend,
            $MICRO_CENTRE_CHECK_Depth,
            $MICRO_DRILLING_Eccentricity,
            $MICRO_DRILLING_Side_Drill,
            $MICRO_DRILLING_Bend,
            $MICRO_DRILLING_Depth,
            $MICRO_DRILLING_GONOGO,
            $MICRO_GAUGE_CHECK_Eccentricity,
            $MICRO_GAUGE_CHECK_Side_Drill,
            $MICRO_GAUGE_CHECK_Bend,
            $MICRO_GAUGE_CHECK_Depth,
            $MICRO_GAUGE_CHECK_GONOGO,
            $DRILLING_Eccentricity,
            $DRILLING_Side_Drill,
            $DRILLING_Bend,
            $DRILLING_Depth,
            $DRILLING_GONOGO,
            $GAUGE_CHECK_Eccentricity,
            $GAUGE_CHECK_Side_Drill,
            $GAUGE_CHECK_Bend,
            $GAUGE_CHECK_Depth,
            $GAUGE_CHECK_GONOGO,
            $PRESS_Die_Mark,
            $PRESS_Dia,
            $PRESS_Cross,
            $PRESS_Angle,
            $PRESS_Tip_Bend,
            $MANUAL_GRINDING_Length_Short,
            $MANUAL_GRINDING_Thick,
            $MANUAL_GRINDING_Thin,
            $MANUAL_GRINDING_Not_Close,
            $MANUAL_GRINDING_Line_Cross,
            $AUTO_GRINDING_Length_Short,
            $AUTO_GRINDING_Thick,
            $AUTO_GRINDING_Thin,
            $AUTO_GRINDING_Not_Close,
            $AUTO_GRINDING_Line_Cross,
            $AUTO_GRINDING_INSPECTION_Length_Short,
            $AUTO_GRINDING_INSPECTION_Thick,
            $AUTO_GRINDING_INSPECTION_Thin,
            $AUTO_GRINDING_INSPECTION_Not_Close,
            $AUTO_GRINDING_INSPECTION_Line_Cross,
            $BENDING_Twist,
            $BENDING_Profile,
            $BENDING_Tip_Bend,
            $BENDING_Bore_Buldge,
            $BENDING_Line_Cross,
            $BENDING_INSPECTION_Twist,
            $BENDING_INSPECTION_Round_Bend,
            $BENDING_INSPECTION_Open,
            $BENDING_INSPECTION_Close,
            $BENDING_INSPECTION_Profile,
            $BENDING_INSPECTION_Tip_Bend,
            $HARDENING__TEMPERING_Turns_to_Cut,
            $HARDENING__TEMPERING_Turns_to_Cut,
            $MICRO_Finish,
            $MICRO_pit_mark,
            $MICRO_Dia,
            $MICRO_Flash, 
            $MICRO_Point_Bend,
            $INSPECTION_Twist,
            $INSPECTION_Pit_mark,
            $INSPECTION_Bore_buldge,
            $INSPECTION_Dia,
            $INSPECTION_Eccentric,
            $INSPECTION_Faulty_Finish,
            $INSPECTION_GO__NO_GO,
            $INSPECTION_Depth,
            $INSPECTION_Point,
            $PACKING_LABELLING,
            $EDM,
        );
 
        array_push($Rejection_analysis_data_arr, $Rejection_analysis_data_item);
    }

    // while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
    //     // extract row
    //     // this will make $row['name'] to
    //     // just $name only
    //     extract($row);
 
    //     $batch=explode("_",$batch_no);
    //    //print_r($batch);
    //     $batch_number=$batch[0];

    //     $Production_status_item1=array(
    //         "Q_fg_code" =>$fg_code,
    //         "Q_ord_qty" =>$ord_qty,
    //         "Q_cust_name" =>$cust_name,
    //         "Q_req_date" =>$req_date,
    //         "Q_plan" =>$plan,
    //         "Q_plan_type" =>$plan_desc,
    //         "Q_type" =>$type,
    //         "Q_batch_no" =>$batch_no,
    //         "Q_batch" =>$batch_number,
    //         "Q_op_qty" =>$op_qty,
    //         "Q_STRAIGHT_CUT" =>$STRAIGHT_CUT,
    //         "Q_ROUGH_POINTING" =>$ROUGH_POINTING,
    //         "Q_ENDCUT" =>$ENDCUT,
    //         "Q_CENTERING" =>$CENTERING ,
    //         "Q_CENTER_CHECK" =>$CENTER_CHECK ,
    //         "Q_MICRO_CENTERING" =>$MICRO_CENTERING,
    //         "Q_MICRO_CENTRE_CHECK" =>$MICRO_CENTRE_CHECK,
    //         "Q_MICRO_DRILLING" =>$MICRO_DRILLING,
    //         "Q_MICRO_GAUGE_CHECK" =>$MICRO_GAUGE_CHECK,
    //         "Q_DRILLING" =>$DRILLING,
    //         "Q_GAUGE_CHECK" =>$GAUGE_CHECK,
    //         "Q_PRESS" =>$PRESS,
    //         "Q_MANUAL_GRINDING" =>$MANUAL_GRINDING,
    //         "Q_AUTO_GRINDING" =>$AUTO_GRINDING ,
    //         "Q_AUTO_GRINDING_INSPECTION" =>$AUTO_GRINDING_INSPECTION ,
    //         "Q_BENDING" =>$BENDING,
    //         "Q_BENDING_INSPECTION" =>$BENDING_INSPECTION,
    //         "Q_HARDENING_TEMPERING" =>$HARDENING_TEMPERING,
    //         "Q_MICRO" =>$MICRO,
    //         "Q_INSPECTION" =>$INSPECTION,
    //         "Q_PACKING_LABELLING" =>$PACKING_LABELLING,
    //         "Q_EDM" =>$EDM
    //     );

    // //    print_r($Production_status_item1); 
    //  array_push($Production_status_arr1, $Production_status_item1);

    // }

    // for ($i = 0; $i < count($Production_status_arr); $i++) {

    // $result[] = (array_merge_recursive($Production_status_arr[$i],$Production_status_arr1[$i]));   
 
    // }

   // print_r(array_merge_recursive($Production_status_arr,$Production_status_arr1));
    // set response code - 200 OK
    http_response_code(200);
    $status['data'] =$Rejection_analysis_data_arr;
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

