<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Prod_data_sheet.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Prod_data_sheet = new Prod_data_sheet($db);

// query products
$stmt = $Prod_data_sheet->read();
$stmt1 = $Prod_data_sheet->read1();
$num = $stmt->rowCount();
$num1 = $stmt1->rowCount();

 
// check if more than 0 record found
if($num>0){
 
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

        if($DEPT_CODE=='103021'){
            $Packed_doz = round(($OK_QTY/12),0);
        }else{
            $Packed_doz = 0;
        }
 
        $Prod_data_sheet_item[]=array(
            "Department" => $DEPT,
            "Department_code" => $DEPT_CODE,
            "Date"=> $DATEE,
            "team_lead"=> $team_lead,
            "Operator"=> $OPERATOR,
            "team_lead_id"=> $team_lead_id,
            "OPERATOR_id"=> $OPERATOR_id,
            "OK_QTY"=> $OK_QTY,
            "REJ_QTY"=> $REJ_QTY,
            "Machine_name"=> $MACHINE_NAME,
            "Time_from"=> $TIME_FROM,
            "Time_to"=> $TIME_TO,
            "Duration"=> $duration,
            "Packed_doz"=> $Packed_doz,
        );
 
        //array_push($Prod_data_sheet_arr, $Prod_data_sheet_item);
    }
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Prod_data_sheet_item1[]=array(
            "Batch_no" => $batch_no,
            "Size"=> $fg_code,
            "Qty"=> $ord_qty,
            "Customer"=> $cust_name,
            "Required_date"=> $req_date,
            "Plan"=> $plan,
            "Status"=> $state,
        );
 
        //array_push($Prod_data_sheet_arr, $Prod_data_sheet_item1);
    }
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    $status['data'] =$Prod_data_sheet_item;
    $status['details'] =$Prod_data_sheet_item1;
    echo json_encode($status);
}else{
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Prod_data_sheet_item1[]=array(
            "Batch_no" => $batch_no,
            "Size"=> $fg_code,
            "Qty"=> $ord_qty,
            "Customer"=> $cust_name,
            "Required_date"=> $req_date,
            "Plan"=> $plan,
            "Status"=> $state,
        );
 
        //array_push($Prod_data_sheet_arr, $Prod_data_sheet_item1);
    }
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    $status['data'] =[];
    $status['details'] =$Prod_data_sheet_item1;
    echo json_encode($status );
}

