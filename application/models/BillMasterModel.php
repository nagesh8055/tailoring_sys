<?php 
   Class BillMasterModel extends CI_Model {
	
      private $_tblName = "bill_m";
      Public function __construct() { 
         parent::__construct(); 
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

    public function fetch_billMaster($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->_tblName);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_billMaster() {
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
	
	//27 Feb 2024
    public function getBillMaster($limit, $start, $fdate = '' , $edate = '', $custId = ''){
            $this->db->limit($limit, $start);
            $this->db->select('*');
            $this->db->from($this->_tblName);
            $this->db->join('cust_m', 'cust_m.cid = bill_m.cid');
            
            if(!empty($fdate) && !empty($edate)){
                //$this->db->where($where);
                $this->db->where('bill_date >=', $fdate);
                $this->db->where('bill_date <=', $edate);
            }
		if(!empty($custId)){
                $this->db->where('bill_m.cid', $custId);
            }
            if(!empty($orWhere)){
                $this->db->or_where($orWhere);
            }

            $query = $this->db->get();
            $result = $query->result();

        return $query->result_array();
    }   
	   
	   public function getBillMasterByBillNo($where = array()){
        $this->db->select('*');
        $this->db->from($this->_tblName);
        $this->db->join('cust_m', 'cust_m.cid = bill_m.cid');
        
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($orWhere)){
            $this->db->or_where($orWhere);
        }

        $query = $this->db->get();
        //$result = $query->result();

        return $query->row_array();
    }


   } 
?>