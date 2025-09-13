<?php 
   Class JobTrackingModel extends CI_Model {
	
      private $_tblName = "job_tracking";
      Public function __construct() { 
         parent::__construct(); 
      } 

      public function insert($data) { 
         if ($this->db->insert($this->_tblName, $data)) { 
            return true; 
         } 
      }

      public function get_jobTracking($where = array(),$orWhere = array()) {
        

        $this->db->select('*,cust_m.name as custname,type_m.*');
        $this->db->from($this->_tblName);
        $this->db->join('type_m', 'job_tracking.type_id = type_m.type_id');
        $this->db->join('bill_m', 'job_tracking.bill_no = bill_m.billno');
        $this->db->join('cust_m', 'bill_m.cid = cust_m.cid');
       // $this->db->join('storage_m', 'storage_m.id = job_tracking.storageid');
        
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($orWhere)){
            foreach($orWhere as $row) {
                $this->db->or_where($row);
            }
            
        }
        

        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        $result = $query->result();
       return $query->result_array();
    }

      public function record_count() {
        return $this->db->count_all($this->_tblName);
    }

    public function fetch_jobTracking($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->_tblName);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_worker($where = array()) {
        if(!empty($where)){
            $query = $this->db->get_where($this->_tblName, $where);
            return $query->result_array();
        } else { //17 mar
            //$this->db->get($this->_tblName);
            /*$this->db->select('*');
            $this->db->from($this->_tblName);
            $this->db->join('os_status_m', 'os_status_m.id = worker_m.w_id');
            $this->db->where(array("os_status_m.aid"=>7));
            $query=$this->db->get();
            return $query->result_array();
            */
            $sql = "SELECT * FROM worker_m w LEFT JOIN os_status_m s on w.w_id = s.id and s.aid = 7";
        $query = $this->db->query($sql);

        $result = $query->result_array();
        return $result;
        }
    }

    public function getAssignQty($jobId = 0,$typeId =0 ,$jobType = 0 ) {  //$jobType = 0 -Cutter, 1 - Steacher
        $sql = "SELECT sum(ass_qty) as ass_qty FROM job_tracking WHERE job_id = ".$jobId." and type_id = ".$typeId." and job_type = ".$jobType;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        //echo $sql;
        //echo '\n'.$result[0]['ass_qty']; die;
        if(!empty($result[0]['ass_qty'])) {
            return $result[0]['ass_qty'];
        } else {
            return 0;
        }
    }

    public function get_job_tracking_by_id($id) {
        $query = $this->db->get_where($this->_tblName, array('id' => $id));
        return $query->row_array();
    }

    // Update operation
    public function update_jobTracking($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->_tblName, $data);
        return $this->db->affected_rows();
    }

     // Delete operation
     public function delete_jobTracking($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->_tblName);
        return $this->db->affected_rows();
    }


   } 
?>