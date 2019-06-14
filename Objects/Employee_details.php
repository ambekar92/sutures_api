
<?php

class Employee_details{
 
    

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        
    // select all query
 $query = "SELECT id,emp_id,frst_name,tb_m_role_status.role_desc,designation,ifnull(email,'-') as email,if(emp_cont_no = 0 , '-',emp_cont_no) as contact_no  FROM `tb_m_employee`
 join tb_m_role_status on tb_m_employee.role_code = tb_m_role_status.role_code ORDER BY id DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    

    return $stmt;
        }
 

}
