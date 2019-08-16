<?php

class Prod_dash_filedata {
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
    $data = json_decode(file_get_contents('php://input'), true);
     $date = $data['date'];

   $query = "SELECT IFNULL(date_,0) as date_,
   IFNULL(work_ctr_code,0)as work_ctr_code ,
   IFNULL(process,0)as process,
   IFNULL(daily_target,0) as daily_target,
   IFNULL(man_power,0)as man_power,
   IFNULL(machine,0)as machine,
   IFNULL(material,0)as material,
   IFNULL(today_plan,0)as today_plan,
   IFNULL(planed_man_power,0)as planed_man_power,
   IFNULL(actual_card_urgent_rb,0)as actual_card_urgent_rb,
   IFNULL(actual_card_urgent_ct,0)as actual_card_urgent_ct,
   IFNULL(actual_card_regular_rb,0)as actual_card_regular_rb,
   IFNULL(actual_card_regular_ct,0)as actual_card_regular_ct,
   IFNULL(card_stock_urgent_rb,0)as card_stock_urgent_rb,
   IFNULL(card_stock_urgent_ct,0)as card_stock_urgent_ct,
   IFNULL(card_stock_regular_rb,0)as card_stock_regular_rb,
   IFNULL(card_stock_regular_ct,0)as card_stock_regular_ct,
   (IFNULL(actual_card_urgent_rb,0)+IFNULL(actual_card_urgent_ct,0)+IFNULL(actual_card_regular_rb,0)+IFNULL(actual_card_regular_ct,0)+IFNULL(card_stock_urgent_rb,0)+IFNULL(card_stock_urgent_ct,0)+IFNULL(card_stock_regular_rb,0)+IFNULL(card_stock_regular_ct,0))as monthly_total_cards,
   (IFNULL(daily_target,0) * (select COUNT(*)from  tb_t_prod_dash_i where status = 'Working'))as planned_cards,
   ((IFNULL(daily_target,0) * (select COUNT(*)from  tb_t_prod_dash_i where status = 'Working'))- (IFNULL(actual_card_urgent_rb,0)+IFNULL(actual_card_urgent_ct,0)+IFNULL(actual_card_regular_rb,0)+IFNULL(actual_card_regular_ct,0))) as backlogs,
   ((IFNULL(actual_card_urgent_rb,0)+IFNULL(actual_card_urgent_ct,0)+IFNULL(actual_card_regular_rb,0)+IFNULL(actual_card_regular_ct,0)+IFNULL(card_stock_urgent_rb,0)+IFNULL(card_stock_urgent_ct,0)+IFNULL(card_stock_regular_rb,0)+IFNULL(card_stock_regular_ct,0)) / ((select COUNT(*)from  tb_t_prod_dash_i where status = 'Working')) )as avg_cards,
   IFNULL(remarks,0) as remarks ,IFNULL(reasons,0) as reasons 
   FROM `tb_t_prod_dash_h` where date_ = '$date ' ";

    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    
    // execute query
    $stmt->execute();
    return $stmt;
   
}
 
        function read1(){
            $data = json_decode(file_get_contents('php://input'), true);
            $date = $data['date'];


         $query1 = "SELECT IFNULL(date_,0)as date_ ,IFNULL(status,0)as status,IFNULL(last_month_man_hours,0)as last_month_man_hours,IFNULL(last_month_absenttism,0)as last_month_absenttism,IFNULL(last_month_ot,0)as last_month_ot,IFNULL(monthly_man_hours,0)as monthly_man_hours,IFNULL(monthly_absenttism,0)as monthly_absenttism,IFNULL(monthly_ot,0)as monthly_ot,IFNULL(last_month_production,0)as last_month_production,IFNULL(last_month_productivity,0)as last_month_productivity,IFNULL(last_month_yield,0)as last_month_yield,IFNULL(monthly_production,0)as monthly_production,IFNULL(monthly_productivity,0)as monthly_productivity,IFNULL(monthly_yield,0)as monthly_yield FROM `tb_t_prod_dash_i` where date_ = '$date'";
    
        // prepare query statement
        $stmt1 = $this->conn->prepare($query1);
        
        // execute query
      
        $stmt1->execute();
        

        return $stmt1;
            }
     
	 
	 
		function read2(){
			$data = json_decode(file_get_contents('php://input'), true);
			$date = $data['date'];


			$query2 = "SELECT prod_reas_code, prod_reas_descp from tb_m_prod_reason";

			// prepare query statement
			$stmt2 = $this->conn->prepare($query2);

			// execute query

			$stmt2->execute();


			return $stmt2;
        }
        

        function read3(){
			// $data = json_decode(file_get_contents('php://input'), true);
			// $date = $data['date'];


			$query3 = "SELECT MAx(date_) as date_ FROM `tb_t_prod_dash_i` where date_ < (select max(date_) from tb_t_prod_dash_i where status = 'Holiday') and status = 'Working'";

			// prepare query statement
			$stmt3 = $this->conn->prepare($query3);

			// execute query

			$stmt3->execute();


			return $stmt3;
		}

}
