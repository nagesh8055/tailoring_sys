<?php 
   Class UtiModel extends CI_Model {
	
      private $_tblName = "uti_m";
      Public function __construct() { 
         parent::__construct(); 
      } 

      public function getTransactionId(){
        $tranId = 0;
        $sql = "SELECT uti_int FROM `uti_m` where uti like 'tranid'";
        $query = $this->db->query($sql); 
        $row = $query->row_array();
        $tranId = $row['uti_int'];

        //$newTranId = $tranId+1;
        //$sql = "UPDATE uti_m SET uti_int = $newTranId WHERE uti = 'tranid'";
        //$this->db->query($sql);

        //$this->db->where('uti', 'tranid');
        //$this->db->update('uti_m', array("uti_int"=>$newTranId));

        //$this->updateTranId($tranId+1);

        return $tranId;

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

    public function fetch_yearMaster($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->_tblName);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    
    // Update operation
    public function updateTranId($tranId = 0) {
        $this->db->where('id',3);
        $this->db->update($this->_tblName, array("uti_int"=>$tranId));
        return $this->db->affected_rows();
    }

     // Delete operation
     public function delete_fashion($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->_tblName);
        return $this->db->affected_rows();
    }


   } 
?>