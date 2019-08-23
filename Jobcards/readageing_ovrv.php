<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Ageing_ovrv.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$ageing_ovrv = new ageing_ovrv($db);

// query products
$stmt = $ageing_ovrv->read();
$num = $stmt->rowCount();

 
// check if more than 0 record found
if($num>0){
 
    // products array
    $ageing_arr=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $ageing_item=array(
            "month"    => $plan,
            "plan1"    => $plan1,
            "plan2"    => $plan2,
            "plan3"    => $plan3,
            "plan1c"   => $plan1c,
            "plan2c"   => $plan2c,
            "plan3c"   => $plan3c,
            "plan1_U"  => $plan1_U,
            "plan1_R"  => $plan1_R,
            "plan2_U"  => $plan2_U,
            "plan2_R"  =>$plan2_R,
            "plan3_U"  => $plan3_U,
            "plan3_R"  =>$plan3_R,
        );
 
        array_push($ageing_arr, $ageing_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($ageing_arr);
}else{
 
    // set response code - 404 Not found
   // http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

