<?php 
   Class QrModel extends CI_Model {
	
      private $_tblName = "url_master";
      Public function __construct() { 
         parent::__construct(); 
      } 

      public function insert($data) { 
         if ($this->db->insert("url_master", $data)) { 
            return true; 
         } 
      }

      public function insertUrCallLog($data){
         if ($this->db->insert("url_visit_log", $data)) { 
            return true; 
         } 

      }

      public function updateUrlCallCount($id =0 ,$surl = '', $data = array()) {
            $this->db->set($data); 
            $this->db->where("id", $id);
            $this->db->where("surl", $surl);  
            $this->db->update($this->_tblName, $data); 
      }

      public function updateQrFormDetails($userName =0 ,$uniquCode = '', $data = array()) {
            
            $this->db->set($data); 
            $this->db->where("qrUserName", $userName);
            $this->db->where("unique_code", $uniquCode); 
            //$this->db->where("qrProfilePhotoUrl", $imagePath); 
            //$this->db->where("status_", $status); // 0 - Disabed ,1 -Active, 2- Submited
            $this->db->update("qr_m", $data); 
      }

   } 
?>