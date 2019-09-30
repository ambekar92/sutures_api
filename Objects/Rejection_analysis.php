
<?php

class Rejection_analysis{
 
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
        function read(){

        $columns = array();
        $reasons = array();

        $sql='SELECT wrk_ctr_code,wrk_ctr_desc FROM `tb_o_workcenter`';
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                
            extract($row);
           
            $sql1="SELECT qlty_code,qlty_code_desc FROM `tb_m_qlty_code` where wrk_ctr_code = '$wrk_ctr_code' and qlty_type_code = 502";
        
            $stmt1 = $this->conn->prepare($sql1);
            
            $stmt1->execute();

            $num = $stmt1->rowCount();
     
             $headers = array(
            "wrk_ctr_name" => $wrk_ctr_desc,
            "col_span" => $num,
             );

             array_push($columns, $headers);
            }

            $sql2="SELECT qlty_code,qlty_code_desc FROM `tb_m_qlty_code` where  qlty_type_code = 502";
            $stmt2 = $this->conn->prepare($sql2);
        
            $stmt2->execute();
        
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                    
                extract($row2);
                $reaon = array(
                    "reason" => $qlty_code_desc,
                    "reason_code" => $qlty_code,
                     );

            array_push($reasons, $reaon);

            }
             
            $status['header'] = $columns;
            $status['reasons'] = $reasons;

             return $status;
    }

       
    
}

    

