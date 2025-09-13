<?php 
   Class TypeModel extends CI_Model {
	
      private $_tblName = "type_m";
      Public function __construct() { 
         parent::__construct(); 
      } 

      public function insert($data) { 
         if ($this->db->insert($this->_tblName, $data)) { 
            return true; 
         } 
      }

      public function record_count() {
        return $this->db->count_all($this->_tblName);
    }

    public function fetch_cust($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->_tblName);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_type() {
        $query = $this->db->get($this->_tblName);
        return $query->result_array();
    }

    public function get_type_by_id($id) {
        $query = $this->db->get_where($this->_tblName, array('type_id' => $id));
        return $query->row_array();
    }

    // Update operation
    public function update_type($id, $data) {
        $this->db->where('type_id', $id);
        $this->db->update($this->_tblName, $data);
        return $this->db->affected_rows();
    }

     // Delete operation
     public function delete_cust($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->_tblName);
        return $this->db->affected_rows();
    }


   } 
?>