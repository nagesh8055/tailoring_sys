<?php 
   Class JobMasterModel extends CI_Model {
	
      private $_tblName = "job_m";
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

    public function fetch_jobMaster($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->_tblName);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
	   public function get_jobMaster($where = array(),$orWhere = array(),$limit = 0, $start = 0) {
        

            //$this->db->select('*');
		   $this->db->select('*,cust_m.name as custname');
            $this->db->from($this->_tblName);
            $this->db->join('type_m', 'job_m.typeid = type_m.type_id');
            $this->db->join('bill_m', 'job_m.billno = bill_m.billno');
            $this->db->join('cust_m', 'bill_m.cid = cust_m.cid');
            $this->db->join('storage_m', 'storage_m.id = job_m.storageid');
            $this->db->order_by('job_m.billno', 'DESC');
            if($limit > 0 && $start >= 0) {
                $this->db->limit($limit, $start);
            } else if($limit > 0 && $start < 0) {
                $this->db->limit($limit);
            } 
            if(!empty($where)){
                $this->db->where($where);
            }
            
            if($limit > 0 && $start >= 0) {
                $this->db->limit($limit, $start);
            } else if($limit > 0 && $start < 0) {
                $this->db->limit($limit);
            } 

            if(!empty($orWhere)){
                $this->db->or_where($orWhere);
            }


            $query = $this->db->get();

            $result = $query->result();

            //$sql = "SELECT j.*,t.type_name FROM `job_m` j INNER JOIN type_m t on j.typeid = t.type_id";
            //$query = $this->db->get_where($sql, $where);
           
        return $query->result_array();
    }

    public function get_jobMasterBKP($where = array(),$orWhere = array()) {
        

            $this->db->select('*');
            $this->db->from($this->_tblName);
            $this->db->join('type_m', 'job_m.typeid = type_m.type_id');
            if(!empty($where)){
                $this->db->where($where);
            }
            if(!empty($orWhere)){
                $this->db->or_where($orWhere);
            }


            $query = $this->db->get();

            $result = $query->result();

            //$sql = "SELECT j.*,t.type_name FROM `job_m` j INNER JOIN type_m t on j.typeid = t.type_id";
            //$query = $this->db->get_where($sql, $where);
         
        
        return $query->result_array();
    }
    
    public function get_job_by_id($id) {
        $query = $this->db->get_where($this->_tblName, array('jobid' => $id));
        return $query->row_array();
    }

    // Update operation
    public function update_job($id, $data) {
        $this->db->where('jobid', $id);
        $this->db->update($this->_tblName, $data);
        return $this->db->affected_rows();
    }

     // Delete operation
     public function delete_job($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->_tblName);
        return $this->db->affected_rows();
    }
	 
	//22 April 2024
    public function getMeasurementByCustId($custId,$typeId) {
        $measurement = '';
        $query = $this->db->query("SELECT job_details FROM job_m where cust_id = ".$custId." and typeid =".$typeId." ORDER by jobid DESC 
        limit 1");
        if ($query->num_rows() > 0) {
            $row = $query->row(); // Get the single row
            // Access row data using object properties or array keys
            $measurement = $row->job_details;
        }

        return $measurement;
    }   

    public function getCustomerMeasurements($custId) {
        $measurement = '';
        $query = $this->db->query("SELECT DISTINCT(j.typeid),t.type_name,j.job_details FROM job_m j inner join type_m t on t.type_id = j.typeid where j.cust_id = ".$custId." ORDER by j.jobid DESC 
        ");
        return $query->result_array();
    }


   } 
?>