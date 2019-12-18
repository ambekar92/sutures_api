<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Operator_efficiency.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Operator_efficiency = new Operator_efficiency($db);

// query products
$stmt = $Operator_efficiency->read();
$stmt1 = $Operator_efficiency->read1();
$num = $stmt->rowCount();

 
// check if more than 0 record found
if($num>0){
    
    // products array
    $Operator_efficiency_arr=array();
    $Operator_efficiency_arr1=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
       if($target_dur1 == 0 && $acu_dur1 == 0){
        $w_eff = 0;
        $t_eff = 0;
       }else{
        $w_eff = (($target_dur1 / $acu_dur1)*100);
        $t_eff = (($acu_dur1 / 28800)*100);
       }
       
        $target_duration = '08:00:00';

        $Operator_efficiency_item=array(
            "date" => $datee,
            "date_c" => $date_c,
            "emp_id"=> $emp_id,
            "name"=> $frst_name,
            "no_of_cards"=> $no_of_cards,
            "mach"=> $no_of_mach,
            "actual_duration_m"=> $acu_dur,
            "target_duration"=> $target_duration,
            "time_efficiency_m"=> round($t_eff,2),
            "work_efficiency"=> round($w_eff,2)
        );
 
        array_push($Operator_efficiency_arr, $Operator_efficiency_item);
    }
 
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

    
        $t_eff = (($tim_sec / 28800)*100);
    
       
        $target_duration = '08:00:00';

        $Operator_efficiency_item1=array(
            "date_t" => $day,
            "emp_id_t"=> $emp_id,
            "actual_duration"=> $tim,
            "time_efficiency"=> round($t_eff,2),
        );
 
        array_push($Operator_efficiency_arr1, $Operator_efficiency_item1);
    }
 

    for ($i = 0; $i < count($Operator_efficiency_arr); $i++) {

        $result[] = (array_merge_recursive($Operator_efficiency_arr[$i],$Operator_efficiency_arr1[$i]));   
     
        }

    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($result);
}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

