<?php 
   Class CustomerModel extends CI_Model {
	
      private $_tblName = "cust_m";
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

    public function get_cust() {
        //$query = $this->db->get($this->_tblName);
        //return $query->result_array();
		$sql = "SELECT * FROM cust_m c LEFT JOIN os_status_m s on c.cid = s.id and s.aid = 1";
        $query = $this->db->query($sql);

        $result = $query->result_array();
        return $result;
    }

    public function get_cust_by_id($id) {
        $query = $this->db->get_where($this->_tblName, array('cid' => $id));
        return $query->row_array();
    }

    public function getCustomerIdByMobileNo($mobile = "") {
        //$query = $this->db->get($this->_tblName);
        //return $query->result_array();
		$sql = "select cid FROM cust_m where mobile1  = '".$mobile."' or mobile2 ='".$mobile."' limit 1";
        $query = $this->db->query($sql);
        //echo $sql; die;
        $result = $query->row()->cid ? $query->row()->cid: 0;
        return $result;
    }

    // Update operation
    public function update_cust($id, $data) {
        $this->db->where('cid', $id);
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