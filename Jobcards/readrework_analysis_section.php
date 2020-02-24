<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Rework_analysis_section.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Rework_analysis_section = new Rework_analysis_section($db);

// query products
$stmt = $Rework_analysis_section->read();
$stmt1 = $Rework_analysis_section->read1();
$num = $stmt->rowCount();
$num1 = $stmt1->rowCount();


// check if more than 0 record found
if($num>0){
 
    // products array
    $Rework_analysis_section_arr=array();
    $Rework_analysis_section_arr1=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        // this will make $row['name'] to
        // just $name only
         
       extract($row);

        $Rework_analysis_section_arr_item=array(
            "wrk_ctr_code" =>$wrk_ctr_code,
            "wrk_ctr_desc" =>$wrk_ctr_desc,
            "qlty_code" =>$qlty_code,
            "qlty_code_desc" =>$qlty_code_desc,
            "qty_in_numz" =>$qty_in_numz,
            "qty_in_doz" =>$qty_in_doz,
            "per" => $per,
        );
 
        // $Rework_analysis_section_arr_item=array(
        //         $wrk_ctr_code,
        //         $wrk_ctr_desc,
        //         $qlty_code,
        //         $qlty_code_desc,
        //         $qty_in_numz,
        //         $qty_in_doz,
        //         $per,  
        //     );

        array_push($Rework_analysis_section_arr, $Rework_analysis_section_arr_item);
    }

    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        // this will make $row['name'] to
        // just $name only
         
       extract($row);

        $Rework_analysis_section_arr_item1=array(
            "wrk_ctr_code" =>$wrk_ctr_code,
            "wrk_ctr_desc" =>$wrk_ctr_desc,
            "qty_in_numz" =>$qty_in_numz,
            "qty_in_doz" =>$qty_in_doz,
            "per" => $per,
        );
 
        // $Rework_analysis_section_arr_item1=array(
        //         $wrk_ctr_code,
        //         $wrk_ctr_desc,
        //         $qty_in_numz,
        //         $qty_in_doz,
        //         $per,
        //     );

        array_push($Rework_analysis_section_arr1, $Rework_analysis_section_arr_item1);
    }


    // set response code - 200 OK
    http_response_code(200);

    $status['data'] =$Rework_analysis_section_arr;
    $status['section'] =$Rework_analysis_section_arr1;
    echo json_encode($status);

}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found

    $status['data'] =[];
    $status['section']=[];
    $status['message'] ="No products found.";
    echo json_encode($status);
    
}

