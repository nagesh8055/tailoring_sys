<?php 
   Class TransactionModel extends CI_Model {
	
      private $_tblName = "transaction_m";
      Public function __construct() { 
         parent::__construct(); 
         $this->load->model('YearMasterModel');
         $this->load->model('UtiModel');
		  $this->load->model('osStatusModel');
         $this->load->model('AccountStatusModel');

         
      } 

      public function insert($data) { 
         if ($this->db->insert($this->_tblName, $data)) { 
            return $this->db->insert_id();
            //return true; 
         } 
      }

      public function record_count() {
        return $this->db->count_all($this->_tblName);
    }

    public function fetch_transaction($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->_tblName);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_transaction() {
        $query = $this->db->get($this->_tblName);
        return $query->result_array();
    }
    
    public function get_fashion_by_id($id) {
        $query = $this->db->get_where($this->_tblName, array('id' => $id));
        return $query->row_array();
    }

    // Update operation
    public function update_fashion($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->_tblName, $data);
        return $this->db->affected_rows();
    }

     // Delete operation
     public function delete_fashion($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->_tblName);
        return $this->db->affected_rows();
    }

    //call pro_transaction(now(),1,1,1,1,1,'','shree',@p_yearid,@p_tranid,@p_dtotamt,@p_ctotamt)
    
    //in p_date datetime,in p_daid int unsigned,in p_caid int unsigned,in p_drefid int unsigned,in p_crefid int unsigned,in p_amt decimal(10,2),in p_disc text,in p_userid varchar(12),out p_yearid int,out p_tranid int,out p_dtotamt decimal(10,2),out p_ctotamt decimal(10,2)
    public function call_transaction_procedure($date , $daid, $caid , $drefid, $crefid, $p_amt , $p_disc, $userid  ) {
        // Load database library if not already loaded
        //$this->db->trans_begin();
        $this->load->database();
        //$this->db->trans_off();
        //$this->db->query("SET AUTOCOMMIT=0");
        //$conn->trans_begin();
        // Define output parameter

        
        $this->db->query('SET @yearid = 0');
        $this->db->query('SET @tranid = 0');
        $this->db->query('SET @dtotamt = 0');
        $this->db->query('SET @ctotamt = 0');

        
        // Call the stored procedure with input and output parameters
        $this->db->mysqli_multi_query('call pro_transaction(?,?,?,?,?,?,?,?,@yearid, @tranid,@dtotamt,@ctotamt)',array($date , $daid, $caid , $drefid, $crefid, $p_amt , $p_disc, $userid));
        
        //$conn->trans_commit();
        //$this->db->trans_complete();
        // Retrieve output parameters

        // Check if transaction was successful
        if ($this->db->trans_status() === FALSE) {
            //$this->db->trans_rollback(); 
            echo "Transaction Failure";
        } else {
            //return $query->row_array();
            //$this->db->trans_commit();
            echo "Transaction Success";
        }
        
        
    }

	   public function createTransaction($date , $daid, $caid , $drefid, $crefid, $amt , $descr, $userid  ) {

        //account_status_m
        //uti_m
        //transaction_m
        //account_type
        //acc_cata_m
        //os_status_m
        
        $tranid = $this->UtiModel->getTransactionId();
        $this->UtiModel->updateTranId($tranid+1);
        
        $yearId = $this->YearMasterModel->getYearId($date);
        $transactionData = array(
            "tranid"=>$tranid,
            "yearid"=>$yearId,
            "date"=>$date, 
            "daid"=>$daid,
            "caid"=>$caid,
            "drefid"=>$drefid,
            "crefid"=>$crefid,
            "amt"=> $amt, 
            "descr"=>$descr,
            "userid"=>$userid);
        
        $transactionId = 0 ;    
        if ($this->db->insert($this->_tblName, $transactionData)) { 
            $transactionId =  $tranid;

         } else {
            return 0;
         }
         
         $o_bal = 0;
         $c_bal = 0 ;
         
        
         //if($daid == 1 ) { // Customer Account - if daid then debit-> add ammount , cid  then credit -> minus amount
        
        if($drefid != 0 && $crefid == 0 ) { // Debit transaction
            $osDetails = $this->osStatusModel->get_osStatus_by_id($drefid , $daid);
            if(!empty($osDetails)) {
                $o_bal = $osDetails['oamt'];
                $c_bal = $osDetails['camt'];

                $c_bal = $c_bal + $amt ;
                $this->osStatusModel->update_osStatus($drefid,$daid,array("camt"=>$c_bal));
            } else {
                $c_bal = $c_bal + $amt ;
                $os_data = array("id"=>$drefid,"aid"=>$daid,"yearid"=>$yearId,"oamt"=>0,"camt"=>$c_bal);
                $this->osStatusModel->insert($os_data);
            }

         }
         //if($caid == 1 ) { // Customer Account - if daid then debit-> add ammount , cid  then credit -> minus amount
        if($drefid == 0 && $crefid != 0 ) {
            $osDetails = $this->osStatusModel->get_osStatus_by_id($crefid, $caid  );
            if(!empty($osDetails)) {
                $o_bal = $osDetails['oamt'];
                $c_bal = $osDetails['camt'];

                if($c_bal < 0 ) {
                    $c_bal = $c_bal + $amt ;
                } else {
                    $c_bal = $c_bal - $amt ;
                }
                
                $this->osStatusModel->update_osStatus($crefid,$caid,array("camt"=>$c_bal));
            } else {
                
                $c_bal = $c_bal - $amt ;
                $os_data = array("id"=>$crefid,"aid"=>$caid,"yearid"=>$yearId,"oamt"=>$c_bal,"camt"=>$c_bal);
                $this->osStatusModel->insert($os_data);
            }
         }
         return $transactionId;
    }
    public function createTransactionBKP17032024($date , $daid, $caid , $drefid, $crefid, $amt , $descr, $userid  ) {

        //account_status_m
        //uti_m
        //transaction_m
        //account_type
        //acc_cata_m
        //os_status_m
        
        $tranid = $this->UtiModel->getTransactionId();
        $this->UtiModel->updateTranId($tranid+1);
        
        $yearId = $this->YearMasterModel->getYearId($date);
        $transactionData = array(
            "tranid"=>$tranid,
            "yearid"=>$yearId,
            "date"=>$date, 
            "daid"=>$daid,
            "caid"=>$caid,
            "drefid"=>$drefid,
            "crefid"=>$crefid,
            "amt"=> $amt, 
            "descr"=>$descr,
            "userid"=>$userid);
		
        

        if ($this->db->insert($this->_tblName, $transactionData)) { 
            return $tranid;
         } else {
            return 0;
         }   
    }

    public function updateTransaction($tranId = 0 , $yearId = 0 , $data = array()) {
        $this->db->where('tranid',$tranId);
        $this->db->where('yearid',$yearId);
        $this->db->update($this->_tblName, $data);
        return $this->db->affected_rows();

    }


   } 
?>