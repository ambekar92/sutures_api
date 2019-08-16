<?php

error_reporting(1);

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Prod_dash_filedata.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Prod_dash_filedata = new Prod_dash_filedata($db);

// query products
$stmt = $Prod_dash_filedata->read();
$stmt1 = $Prod_dash_filedata->read1();
$getReason = $Prod_dash_filedata->read2();
$W_status = $Prod_dash_filedata->read3();
$num = $stmt->rowCount();
$num1 = $stmt1->rowCount();
$getReasonCount = $getReason->rowCount();

 
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
 
        $Prod_dash_filedata_item[]=array(
            "date"=> $date_,
            "work_ctr_code"=> $work_ctr_code,
            "process"=> $process,
            "daily_target"=> $daily_target,
            "man_power"=> $man_power,
            "machine"=> $machine,
            "material"=> $material,
            "today_plan"=> $today_plan,
            "planed_man_power"=> $planed_man_power,
            "actual_card_urgent_rb"=> $actual_card_urgent_rb,
            "actual_card_urgent_ct"=> $actual_card_urgent_ct,
            "actual_card_regular_rb"=> $actual_card_regular_rb,
            "actual_card_regular_ct"=> $actual_card_regular_ct,
            "card_stock_urgent_rb"=> $card_stock_urgent_rb,
            "card_stock_urgent_ct"=> $card_stock_urgent_ct,
            "card_stock_regular_rb"=> $card_stock_regular_rb,
            "card_stock_regular_ct"=> $card_stock_regular_ct,
            "monthly_total_cards"=> $monthly_total_cards,
            "planned_cards"=> $planned_cards,
            "backlogs"=> $backlogs,
            "avg_cards"=> round($avg_cards,2),
            "remarks"=> $remarks,
			"reasons"=> $reasons,
         );
        //array_push($Prod_data_sheet_arr, $Prod_data_sheet_item);
    }
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Prod_dash_filedata_item1=array(
            "date"=> $date_,
            "status"=> $status,
            "last_month_man_hours"=> $last_month_man_hours,
            "last_month_absenttism"=> $last_month_absenttism,
            "last_month_ot"=> $last_month_ot,
            "monthly_man_hours"=> $monthly_man_hours,
            "monthly_absenttism"=> $monthly_absenttism,
            "monthly_ot"=> $monthly_ot,
            "last_month_production"=> $last_month_production,
            "last_month_productivity"=> $last_month_productivity,
            "last_month_yield"=> $last_month_yield,
            "monthly_production"=> $monthly_production,
            "monthly_productivity"=> $monthly_productivity,
            "monthly_yield"=> $monthly_yield,
         );
 
        //array_push($Prod_data_sheet_arr, $Prod_data_sheet_item1);
    }
	
	while ($row = $getReason->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $getReasonList[]=array(
            "prod_reas_code"=> $prod_reas_code,
            "prod_reas_descp"=> $prod_reas_descp
         );
    }

    while ($row = $W_status->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $W_status1[]=array(
            "date"=> $date_,
            
         );
    }
    // set response code - 200 OK
    http_response_code(200);



    // show products data in json format
    $response['header'] =$Prod_dash_filedata_item1;
    $response['body'] =$Prod_dash_filedata_item;
    $response['reasons'] =$getReasonList;
    $response['date'] =$W_status1;
    echo json_encode($response);
}else{
    $response['header'] =[];
    $response['body'] =[];
	$response['reasons'] =[];
    echo json_encode($response);
}

