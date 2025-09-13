<?php 
   Class WorkerCommisionModel extends CI_Model {
	
      private $_tblName = "worker_comm_dtl";
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
	   public function get_commissionDetails($where = array(),$orWhere = array()) {
        if(!empty($where)){

            $this->db->select('*');
            $this->db->from($this->_tblName);
            $this->db->join('job_tracking', 'job_tracking.id = worker_comm_dtl.job_tracking_id');
            $this->db->join('job_m', 'job_m.jobid = worker_comm_dtl.jobid');
            $this->db->join('type_m', 'type_m.type_id = job_m.typeid');
            $this->db->where($where);

            if(!empty($orWhere)){
                $this->db->or_where($orWhere);
            }


            $query = $this->db->get();

            $result = $query->result();

            //$sql = "SELECT j.*,t.type_name FROM `job_m` j INNER JOIN type_m t on j.typeid = t.type_id";
            //$query = $this->db->get_where($sql, $where);
        } else {
            $query = $this->db->get($this->_tblName);
        }
        
        return $query->result_array();
    }

    public function get_jobMaster($where = array(),$orWhere = array()) {
        if(!empty($where)){

            $this->db->select('*');
            $this->db->from($this->_tblName);
            $this->db->join('type_m', 'job_m.typeid = type_m.type_id');
            $this->db->where($where);

            if(!empty($orWhere)){
                $this->db->or_where($orWhere);
            }


            $query = $this->db->get();

            $result = $query->result();

            //$sql = "SELECT j.*,t.type_name FROM `job_m` j INNER JOIN type_m t on j.typeid = t.type_id";
            //$query = $this->db->get_where($sql, $where);
        } else {
            $query = $this->db->get($this->_tblName);
        }
        
        return $query->result_array();
    }
    
    public function get_job_by_id($id) {
        $query = $this->db->get_where($this->_tblName, array('id' => $id));
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


   } 
?>