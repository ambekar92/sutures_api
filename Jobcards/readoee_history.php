<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
// database connection will be here
// include database and object files
include_once '../Config/database.php';
include_once '../Objects/Oee_history.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$Oee_history = new Oee_history($db);

// query products
$stmt = $Oee_history->read();
$stmt1 = $Oee_history->read1();
$num = $stmt->rowCount();




// check if more than 0 record found
 if($num>0){
    // products array

    $Oee_history=array();

   
     if($stmt1 == 'ALL_DAILY' ){


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_history_item=array(
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "date_"=> $date_,
                "availability_perc"=>round($availability_perc,2),
                "performance_perc"=> round($performance_perc,2),
                "quality_perc"=> round($quality_perc,2),
                "oee_perc"=> round($oee_perc,2),
            );
    
            array_push($Oee_history, $Oee_history_item);
        }

     }else if( $stmt1 == 'ALL_WEEKLY' ){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_history_item=array(
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "weekly"=> $weekly,
                "availability_perc"=>round($availability_perc,2),
                "performance_perc"=> round($performance_perc,2),
                "quality_perc"=> round($quality_perc,2),
                "oee_perc"=> round($oee_perc,2),
            );
    

            array_push($Oee_history, $Oee_history_item);
        }

     }else if(  $stmt1 == 'ALL_MONTHLY' ){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_history_item=array(
                "_month"=> $_month,
                "month_desc"=> $month_desc,
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "availability_perc"=>round($availability_perc,2),
                "performance_perc"=> round($performance_perc,2),
                "quality_perc"=> round($quality_perc,2),
                "oee_perc"=> round($oee_perc,2),
            );
    

            array_push($Oee_history, $Oee_history_item);
        }
     }else if($stmt1 == 'W_DAILY'){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_history_item=array(
                "date_"=> $date_,
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "mach_code"=> $mach_code,
                "mach_desc"=> $mach_desc,
                "availability_perc"=>round( $availability_perc,2),
                "performance_perc"=> round($performance_perc,2),
                "quality_perc"=> round($quality_perc,2),
                "oee_perc"=> round($oee_perc,2),
            );
    

            array_push($Oee_history, $Oee_history_item);
        }
    }else if( $stmt1 == 'W_WEEKLY' ){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_history_item=array(
                "weekly"=> $weekly,
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "mach_code"=> $mach_code,
                "mach_desc"=> $mach_desc,
                "availability_perc"=>round( $availability_perc,2),
                "performance_perc"=> round($performance_perc,2),
                "quality_perc"=> round($quality_perc,2),
                "oee_perc"=> round($oee_perc,2),
            );
    
            array_push($Oee_history, $Oee_history_item);
        }
         
    }else if($stmt1 == 'W_MONTHLY'  ){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_history_item=array(
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "mach_code"=> $mach_code,
                "mach_desc"=> $mach_desc,
                "_month"=> $_month,
                "month_desc"=> $month_desc,
                "availability_perc"=>round( $availability_perc,2),
                "performance_perc"=> round($performance_perc,2),
                "quality_perc"=> round($quality_perc,2),
                "oee_perc"=> round($oee_perc,2),
            );
    
            array_push($Oee_history, $Oee_history_item);
        }
         
    }else if( $stmt1 == 'M_DAILY'){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_history_item=array(
                "date"=>$date_,
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "mach_code"=> $mach_code,
                "mach_desc"=> $mach_desc,
                "plnd_prod_time"=> $plnd_prod_time,
                "run_time"=> $run_time,
                "idle_time"=> $idle_time,
                "target_prod"=> "-",
                "actual_prod"=> "-",
                "total_count"=> $total_count,
                "ok_qty"=> $ok_qty,
                "rej_qty"=> $rej_qty,
                "availability_perc"=>round( $availability_perc,2),
                "performance_perc"=> round($performance_perc,2),
                "quality_perc"=> round($quality_perc,2),
                "oee_perc"=> round($oee_perc,2),
            );
    

            array_push($Oee_history, $Oee_history_item);
        }
         
    }else if( $stmt1 == 'M_WEEKLY' ){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_history_item=array(
                "weekly"=> $weekly,
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "mach_code"=> $mach_code,
                "mach_desc"=> $mach_desc,
                "plnd_prod_time"=> $plnd_prod_time,
                "run_time"=> $run_time,
                "idle_time"=> $idle_time,
                "target_prod"=> "-",
                "actual_prod"=> "-",
                "total_count"=> $total_count,
                "ok_qty"=> $ok_qty,
                "rej_qty"=> $rej_qty,
                "availability_perc"=>round( $availability_perc,2),
                "performance_perc"=> round($performance_perc,2),
                "quality_perc"=> round($quality_perc,2),
                "oee_perc"=> round($oee_perc,2),
            );
    

            array_push($Oee_history, $Oee_history_item);
        }
         
    }else if( $stmt1 == 'M_MONTHLY' ){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $Oee_history_item=array(
                "_month"=> $_month,
                "month_desc"=> $month_desc,
                "wrk_ctr_code" => $wrk_ctr_code,
                "wrk_ctr_desc"=> $wrk_ctr_desc,
                "mach_code"=> $mach_code,
                "mach_desc"=> $mach_desc,
                "plnd_prod_time"=> $plnd_prod_time,
                "run_time"=> $run_time,
                "idle_time"=> $idle_time,
                "target_prod"=> "-",
                "actual_prod"=> "-",
                "total_count"=> $total_count,
                "ok_qty"=> $ok_qty,
                "rej_qty"=> $rej_qty,
                "availability_perc"=>round( $availability_perc,2),
                "performance_perc"=> round($performance_perc,2),
                "quality_perc"=> round($quality_perc,2),
                "oee_perc"=> round($oee_perc,2),
            );
    

            array_push($Oee_history, $Oee_history_item);
        }
         
    }
   
    http_response_code(200);
    // show products data in json format
    $status['details'] =$Oee_history;
    echo json_encode($status);
}else{
 

    // set response code - 404 Not found
   // http_response_code(404);
  // tell the user no products found

    $status['details'] =[];
    $status['message'] ="No products found.";

    echo json_encode($status);
}



