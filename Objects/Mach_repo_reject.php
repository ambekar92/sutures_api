
<?php

class Machine_repo{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_t_prod_i";
 
    // object properties
    public $Machine;        
	public $Department; 
    public $Jobcard;
    public $Size;      
	public $Quality_type;        
    public $Quantity;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){

        $data = json_decode(file_get_contents('php://input'), true);

        $wrk_ctr_code = $data['wrk_ctr_code'];
        $batch_no = $data['batch_no'];
      
        
    // select all query
 $query = "SELECT qc.qlty_code_desc,ifnull(pi.qty,0)as qty FROM tb_m_qlty_code qc
 left join ( SELECT * FROM tb_t_prod_i WHERE batch_no = '$batch_no') pi on pi.wrk_ctr_code=qc.wrk_ctr_code and pi.qlty_code=qc.qlty_code
 where qc.qlty_type_code = 502 and qc.wrk_ctr_code = '$wrk_ctr_code'";
 
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
