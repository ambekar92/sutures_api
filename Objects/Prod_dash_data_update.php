
<?php

class Prod_dash_data_update {
 
    // database connection and table name
    private $conn;
    ///private $table_name = "tb_t_prod_i";


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
     $data = json_decode(file_get_contents('php://input'), true);

     $date = $data['date'];
    
        $query = "select * from tb_t_prod_dash_h where date_ = '$date'";
    
        $query1 = "select * from tb_t_prod_dash_i where date_ = '$date'";
  

    // prepare query statement
    $stmt = $this->conn->prepare($query);
    $stmt1 = $this->conn->prepare($query1);
  
    $stmt->execute();
    $stmt1->execute();

    $num = $stmt->rowCount();
    $num1 = $stmt1->rowCount();

    // execute query
   
 if ( $num == 0 || $num1 == 0 ) { 
        
        $query2 = "INSERT INTO tb_t_prod_dash_h (date_,work_ctr_code,process,daily_target,man_power,today_plan,planed_man_power) select '$date' as date_,work_ctr_code,process,daily_target,man_power,today_plan,planed_man_power from tb_t_prod_dash_h where date_ = (SELECT max(date_) FROM `tb_t_prod_dash_h`)ON DUPLICATE KEY UPDATE process = VALUES(process),daily_target = VALUES(daily_target),man_power = VALUES(man_power),today_plan = VALUES(today_plan),planed_man_power = VALUES(planed_man_power)";
    
        $query3 = "INSERT INTO tb_t_prod_dash_i (date_,status,last_month_man_hours,last_month_absenttism,last_month_ot,monthly_man_hours,monthly_absenttism,monthly_ot) select '$date' as date_,status,last_month_man_hours,last_month_absenttism,last_month_ot,monthly_man_hours,monthly_absenttism,monthly_ot from tb_t_prod_dash_i where date_ = (SELECT max(date_) FROM `tb_t_prod_dash_i` where status = 'Working') ON DUPLICATE KEY UPDATE status = VALUES(status),last_month_man_hours = VALUES(last_month_man_hours),last_month_absenttism = VALUES(last_month_absenttism),last_month_ot = VALUES(last_month_ot),monthly_man_hours = VALUES(monthly_man_hours),monthly_absenttism = VALUES(monthly_absenttism),monthly_ot = VALUES(monthly_ot)";

    // prepare query statement                                                          
    $stmt2 = $this->conn->prepare($query2);
    $stmt3 = $this->conn->prepare($query3);
  
    if ( $stmt2->execute() && $stmt3->execute()) {
        return $stmtr = 1;
     }else{
        return $stmtr = 0;
     }
    
   
  }else{
    return $stmtr = 2;
  }
 
}

}