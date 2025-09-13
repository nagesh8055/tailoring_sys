<?php 
   Class BillDetailModel extends CI_Model {
	
      private $_tblName = "bill_dtl";
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

    public function fetch_billDetail($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->_tblName);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_billDetail() {
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
	   public function getBillDetailByBillNoBkp($where = array()){
        $this->db->select('*');
        $this->db->from($this->_tblName);
        $this->db->join('type_m', 'type_m.type_id = bill_dtl.type_id');
        
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($orWhere)){
            $this->db->or_where($orWhere);
        }

        $query = $this->db->get();
        $result = $query->result();

        return $query->result_array();
    }
	   public function getBillDetailByBillNo($where = array()){
        $this->db->select('*,bill_dtl.rate as bill_rate');//25 Mar 2024
        $this->db->from($this->_tblName);
        $this->db->join('type_m AS type', 'type.type_id = bill_dtl.type_id');//25 Mar 2024
        
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($orWhere)){
            $this->db->or_where($orWhere);
        }

        $query = $this->db->get();
        $result = $query->result();

        return $query->result_array();
    }


   } 
?>