<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Dept_mn_c&p_jobcards.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Dept_mn_cp_jobcards = new Dept_mn_cp_jobcards($db);

// query products
$stmt = $Dept_mn_cp_jobcards->read();
$stmt1 = $Dept_mn_cp_jobcards->read1();
$num = $stmt1->rowCount();
 

// check if more than 0 record found
 if($num>0 ){
 
    // products array
    $Dept_mn_cp_jobcardsp=array();
   // $Jobcard_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only

    
        extract($row);
 
        $Dept_mn_cp_jobcardsp_item=array(
            "wrk_ctr_code" => $wrk_ctr_code,
            "Batch_no" => $batch_no,
            "Size"=> $fg_code,
            "Customer"=> $cust_name,
            "Plan"=> $plan,
            "Plan_type"=> $plan_desc,
            "ok_qty"=> $ok_qty,
            "reject_qty"=> $reject_qty,
            "req_date"=> $req_date,
            "req_type"=> $type,
            "updated_at"=> $updated_at,
        );
 
        array_push($Dept_mn_cp_jobcardsp, $Dept_mn_cp_jobcardsp_item);
    }
 
   
        // products array
        $Dept_mn_cp_jobcards=array();
       // $Jobcard_arr=array();
     
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only

            $ok_qty = 'Pending';
            $reject_qty = 'Pending';


            extract($row);

            $Dept_mn_cp_jobcards_item=array(
                "wrk_ctr_code" => $wrk_ctr_code,
                "Batch_no" => $batch_no,
                "Size"=> $fg_code,
                "Customer"=> $cust_name,
                "Plan"=> $plan,
                "Plan_type"=> $plan_desc,
                "ok_qty"=> $ok_qty,
                "reject_qty"=> $reject_qty,
                "req_date"=> $req_date,
                "req_type"=> $type,
                "updated_at"=> $updated_at,
            );
            array_push($Dept_mn_cp_jobcards, $Dept_mn_cp_jobcards_item);
        }
     
        $result = array_merge($Dept_mn_cp_jobcardsp,$Dept_mn_cp_jobcards);


        // set response code - 200 OK
        http_response_code(200);
    //  echo count($result);
        // show products data in json format
        echo json_encode($result);
    }else{
     
        // set response code - 404 Not found
       // http_response_code(404);
         $status['data'] = [];
        // tell the user no products found
        $status['message'] ="No products found.";
        echo json_encode($status);
        
    }




