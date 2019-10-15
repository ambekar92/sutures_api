
<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Consumables_dept.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$Consumables_dept = new Consumables_dept($db);

// query products
$stmt = $Consumables_dept->read();
$stmt1 = $Consumables_dept->read1();
$num = $stmt->rowCount();
// $num1 = $stmt1->rowCount();


$columns = array();

$str = null;

while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {

    extract($row);

    $headers = array(
        "wrk_ctr_name" => $wrk_ctr_desc,
        "wrk_ctr_code" => $wrk_ctr_code,
    );

    array_push($columns, $headers);
}

// check if more than 0 record found
if ($num > 0) {

    // products array
    $Consumables_dept_arr = array();
    $Consumables_dept_arr1 = array();


    // $Jobcard_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // extract($row);

        $data = (array_values($row));
        
        array_push($Consumables_dept_arr, $data);
    }

    // set response code - 200 OK
    http_response_code(200);
    $status['data'] = $Consumables_dept_arr;
    $status['columns'] = $columns;
    echo json_encode($status);
} else {

    // set response code - 404 Not found
    // http_response_code(404);

    // tell the user no products found

    $status['data'] = [];
    $status['columns']  = $columns;
    $status['message'] = "No products found.";
    echo json_encode($status);
}
