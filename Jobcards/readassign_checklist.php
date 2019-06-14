<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Assign_checklist.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Assign_checklist = new Assign_checklist($db);

// query products
$stmt = $Assign_checklist->read();
$stmt1 = $Assign_checklist->read1();
$stmt2 = $Assign_checklist->read2();
$num = $stmt->rowCount();
$num1 = $stmt1->rowCount();
$num2 = $stmt2->rowCount();

 
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
            "Ticket" => $ticket,
            "Machine_check_h_code"=> $machine_check_h_code,
            "Checklist_desc"=> $checklist_desc,
            "Assigned_by"=> $assigned_by,
            "Assigned_me"=> $assigned_me,
            "Assigned_remarks"=> $assigned_remarks,
            "released_remarks" =>$released_remarks,
            "machine_code" =>$machine_code,
         );
        //array_push($Prod_data_sheet_arr, $Prod_data_sheet_item);
    }
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Assign_checklist_item1[]=$breakdown_desc;
 
        //array_push($Prod_data_sheet_arr, $Prod_data_sheet_item1);
    }

    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $Assign_checklist_item2[]= array(
            "Emp_id" => $emp_id,
            "Role_code" => $role_code,
            "Name"=> $frst_name,
         );
 
        //array_push($Prod_data_sheet_arr, $Prod_data_sheet_item1);
    }

    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    $status['header'] =$Assign_checklist_item;
    $status['details'] =$Assign_checklist_item1;
    $status['assigned_to'] =$Assign_checklist_item2;
    echo json_encode($status);
}else{
 
    $status['header'] =[];
    $status['details'] =[];
    $status['assigned_to'] =[];
    echo json_encode($status);
}

