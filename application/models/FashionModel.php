<?php 
   Class FashionModel extends CI_Model {
	
      private $_tblName = "fashion_m";
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

    public function fetch_fashion($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->_tblName);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_fashion() {
        $query = $this->db->get($this->_tblName);
        return $query->result_array();
    }

    /**@author - Nagesh H
     * @param1 = type Id
     * result = fashion list by typeId
     */
    public function getFashionByTypeId($id = 0 ) { //17 Feb 2024
        
        //$where_condition = array("type_id"=>$id);
        
        //$this->db->select('*'); // Select all columns, you can replace '*' with specific column names
        //$this->db->from($this->_tblName); // Replace 'table_name' with the name of your table
        //$this->db->where($where_condition); // Add WHERE clause

        $sql = "SELECT f.f_id as fid,f.f_name as f_name,(SELECT GROUP_CONCAT(sub_fashion) FROM `sub_f_m` WHERE f_id = f.f_id) as subfashions,
        (SELECT GROUP_CONCAT(sub_f_id) FROM `sub_f_m` WHERE f_id = f.f_id) as subfashionsid
         FROM `fashion_m` f WHERE f.type_id = ".$id." and f.visible =1";
        // Execute the query and get the result
        
        $query = $this->db->query($sql);
    
        
        return $query->result_array();
        //$query = $this->db->get();

        //if ($query->num_rows() > 0) {
        //    return $query->result_array();
        //}
        //return false;
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


   } 
?>