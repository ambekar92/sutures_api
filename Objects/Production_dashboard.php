<?php

class Production_dashboard {
 
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

     $ticket = $data['ticket'];
     $machine_check_h_code = $data['machine_check_h_code'];

   $query = "SELECT W.wrk_ctr_desc, C.regular_RB,D.regular_CT,A.urgent_RB,B.urgent_CT FROM tb_o_workcenter  W
   LEFT OUTER JOIN(select count(jct.batch_no) as urgent_RB,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 1
   join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' WHERE (date(jct.updated_at) between  DATE_FORMAT('2019-03-31' ,'%Y-%m-01') AND '2019-03-31' )
   group by jct.present_dept) A on A.present_dept = W.wrk_ctr_code 
   LEFT OUTER JOIN(select count(jct.batch_no) as urgent_CT,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 1
   join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' WHERE (date(jct.updated_at) between  DATE_FORMAT('2019-03-31' ,'%Y-%m-01') AND '2019-03-31' )
   group by jct.present_dept) B on B.present_dept = W.wrk_ctr_code and  B.present_dept = W.wrk_ctr_code
   LEFT OUTER JOIN(select count(jct.batch_no) as regular_RB,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 0
   join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' WHERE (date(jct.updated_at) between  DATE_FORMAT('2019-03-31' ,'%Y-%m-01') AND '2019-03-31' )
   group by jct.present_dept) C on C.present_dept = W.wrk_ctr_code 
   LEFT OUTER JOIN(select count(jct.batch_no) as regular_CT,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 0
   join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' WHERE (date(jct.updated_at) between  DATE_FORMAT('2019-03-31' ,'%Y-%m-01') AND '2019-03-31' )
   group by jct.present_dept) D on D.present_dept = W.wrk_ctr_code 
   group by W.wrk_ctr_code 
   ";

    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    
    // execute query
    $stmt->execute();
    return $stmt;
   
}
 
        function read1(){
            $data = json_decode(file_get_contents('php://input'), true);
            $machine_check_h_code = $data['machine_check_h_code'];

         $query1 = "SELECT W.wrk_ctr_desc, C.regular_RB,D.regular_CT,A.urgent_RB,B.urgent_CT FROM tb_o_workcenter  W
          LEFT OUTER JOIN(select count(jct.batch_no) as urgent_RB,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status != '807' and jct.status_code = '802' and tb_m_jobcard.urgent = 1
          join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' WHERE (date(jct.updated_at) between  DATE_FORMAT('2019-03-31' ,'%Y-%m-01') AND '2019-03-31' )
          group by jct.present_dept) A on A.present_dept = W.wrk_ctr_code 
          LEFT OUTER JOIN(select count(jct.batch_no) as urgent_CT,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status != '807' and jct.status_code = '802' and tb_m_jobcard.urgent = 1
          join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' WHERE (date(jct.updated_at) between  DATE_FORMAT('2019-03-31' ,'%Y-%m-01') AND '2019-03-31' ) 
          group by jct.present_dept) B on B.present_dept = W.wrk_ctr_code and  B.present_dept = W.wrk_ctr_code
          LEFT OUTER JOIN(select count(jct.batch_no) as regular_RB,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status != '807' and jct.status_code = '802' and tb_m_jobcard.urgent = 0
          join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' WHERE (date(jct.updated_at) between  DATE_FORMAT('2019-03-31' ,'%Y-%m-01') AND '2019-03-31' )
          group by jct.present_dept) C on C.present_dept = W.wrk_ctr_code 
          LEFT OUTER JOIN(select count(jct.batch_no) as regular_CT,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status != '807' and jct.status_code = '802' and tb_m_jobcard.urgent = 0
          join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' WHERE (date(jct.updated_at) between  DATE_FORMAT('2019-03-31' ,'%Y-%m-01') AND '2019-03-31' )
          group by jct.present_dept) D on D.present_dept = W.wrk_ctr_code 
          group by W.wrk_ctr_code";
    
        // prepare query statement
        $stmt1 = $this->conn->prepare($query1);
        
        // execute query
      
        $stmt1->execute();
        

        return $stmt1;
            }
     

}
