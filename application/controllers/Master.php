<?php 
   class Master extends CI_Controller {  

      function __construct() {
         parent::__construct();
         $this->load->library('session');
         $this->load->model('TypeModel');
         $this->load->model('MeasurementModel');
         $this->load->model('FashionModel');
         $this->load->model('SubFashionModel');
    $this->load->library('form_validation'); // Load Form Validation Library
         $this->load->library('pagination');
         load_site_language();
     }
	
     public function index(){
        
        //$this->load->database();
        //$query = $this->db->get_where("qr_m",array("unique_code"=>$urlCode)); 
        //$this->load->view('Login'); 
        
     }
     
     public function typeCreate(){

        if(!$this->session->has_userdata('username')){
           redirect('login');
        } 
        header("Access-Control-Allow-Origin: *");

        $config = array();
        $config["base_url"] = base_url() . "Master/typeCreate";
        $config["total_rows"] = $this->TypeModel->record_count();
        $config["per_page"] = 50;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["typeData"] = $this->TypeModel->fetch_cust($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        $this->template->set('title', 'Type Master');
        $this->template->load('default_layout', 'contents' , 'addType', $data);
     }

     public function typeCreateDb(){

      $this->load->helper('url');
         //$formPost = $this->input->post();

         $visible = !is_null($this->input->post('visible')) ? 1 : 0;
         $typeData = array(
         //"type_id"=>$this->input->post('hidden_type_id'),
         "type_name"=>$this->input->post('type_name'),
         "type_name_marathi"=>$this->input->post('type_name_marathi'),
         "cutter_comm"=>$this->input->post('cutter_comm'), 
         "surgeon_comm"=>$this->input->post('surgeon_comm'), 
         "rate"=>$this->input->post('rate'), 
         "visible"=>$visible, 
         );

         $validationErrors = array();
         $this->form_validation->set_rules('type_name', 'type_name', 'required|trim|min_length[3]');
         $this->form_validation->set_rules('type_name_marathi', 'type_name_marathi', 'required|trim|min_length[3]');
         $this->form_validation->set_rules('cutter_comm', 'cutter_comm', 'required|trim|numeric');
         $this->form_validation->set_rules('surgeon_comm', 'surgeon_comm', 'required|trim|numeric');
         $this->form_validation->set_rules('rate', 'rate', 'required|trim|numeric');
         $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
         // Run validation
         $this->form_validation->set_message('required', 'The %s field is required.');
     
         if ($this->form_validation->run() == FALSE) {
            $validationErrors = form_validation_errors();
            echo json_encode(array('status' => 'error', 'message' => $validationErrors));
            return;
         }

         if($this->input->post('hidden_type_id') != 0) { //hidden_type_id = 0 Insert and non zero means update
            if($this->TypeModel->update_type($this->input->post('hidden_type_id'), $typeData)) {
               echo "Type Updated Successfully";
            } else {
               echo "Error In Type Update";
            }
            return;
         }
         //"w_type_id"=>$this->input->post('o_bal'),
         if($this->TypeModel->insert($typeData)) {
            echo "Type Added Successfully";
         } else {
            echo "Error In Type Saving";
         }
     }

      public function measurementCreate(){

         if(!$this->session->has_userdata('username')){
            redirect('login');
         } 
         //echo $this->session->userdata('username'); die;
         //echo "welcome To Dashboard";
         header("Access-Control-Allow-Origin: *");

         $config = array();
        $config["base_url"] = base_url() . "Master/measurementCreate";
        $config["total_rows"] = $this->MeasurementModel->record_count();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["mData"] = $this->MeasurementModel->fetch_measurement($config["per_page"], $page);
        $data["typeData"] = $this->TypeModel->get_type();
        $data["links"] = $this->pagination->create_links();
        $data["logData"] = array();
         
         $this->template->set('title', 'Measurement Master');
         $this->template->load('default_layout', 'contents' , 'measurementMaster', $data);
      }
      public function measurementCreateDb_bkp(){

         $this->load->helper('url');
            //$formPost = $this->input->post();
   
            $visible = !is_null($this->input->post('visible')) ? 1 : 0;
            $mData = array(
            "type_id"=>$this->input->post('type_id'),
            "m_name"=>$this->input->post('m_name'), 
            "visible"=>$visible, 
            );
            //"w_type_id"=>$this->input->post('o_bal'),
            if($this->MeasurementModel->insert($mData)) {
               echo "Measurement Added Successfully";
            } else {
               echo "Error In Measurement Saving";
            }
      }
	   public function measurementCreateDb(){

         $this->load->helper('url');
            //$formPost = $this->input->post();
            $m_id = $this->input->post('m_id');
            $visible = !is_null($this->input->post('visible')) ? 1 : 0;
            $is_custom = !is_null($this->input->post('custom_input')) ? 1 : 0;
            $mData = array(
            "type_id"=>$this->input->post('type_id'),
            "m_name"=>$this->input->post('m_name'), 
            "visible"=>$visible, 
            "is_custom" =>$is_custom
            );
            //"w_type_id"=>$this->input->post('o_bal'),
            if($m_id == 0) { //m_id = 0 Insert and non zero means update
               if($this->MeasurementModel->insert($mData)) {
                  echo "Measurement Added Successfully";
               } else {
                  echo "Error In Measurement Saving";
               }
            } else {
               if($this->MeasurementModel->update_measurement($m_id,$mData)) {
                  echo "Measurement Updated Successfully";
               } else {
                  echo "Error In Measurement Updated";
               }
               
            }
            
      }

      
        public function fashionCreate(){

         if(!$this->session->has_userdata('username')){
            redirect('login');
         } 
         header("Access-Control-Allow-Origin: *");

         $config = array();
         $config["base_url"] = base_url() . "Master/fashionCreate";
         $config["total_rows"] = $this->FashionModel->record_count();
         $config["per_page"] = 20;
         $config["uri_segment"] = 3;
 
         $this->pagination->initialize($config);
         $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
         $fashionData = $this->FashionModel->fetch_fashion($config["per_page"], $page);
         $data["fData"] = !empty($fashionData) ? $fashionData : array();
         $data["typeData"] = $this->TypeModel->get_type();
         $data["links"] = $this->pagination->create_links();
         
         $this->template->set('title', 'Fashion Master');
         $this->template->load('default_layout', 'contents' , 'fashionMaster', $data);
      }

      public function fashionCreateDb(){

         $this->load->helper('url');
            //$formPost = $this->input->post();
   
            $visible = !is_null($this->input->post('visible')) ? 1 : 0;
            $fData = array(
            "type_id"=>$this->input->post('type_id'),
            "f_name"=>$this->input->post('f_name'), 
            "visible"=>$visible, 
            );
            //"w_type_id"=>$this->input->post('o_bal'),
            if($fashion_id = $this->FashionModel->insert($fData)) {
               
               $subFashionArray = $this->input->post('fdtl');
               $subFashionChk = $this->input->post('fdtlchk');

               foreach($subFashionArray as $row) {
                  $sfData = array(
                     "f_id"=>$fashion_id,
                     "sub_fashion"=>$row
                  );
                  $this->SubFashionModel->insert($sfData);
               }

               echo "Fashion Added Successfully";
            } else {
               echo "Error In Fashion Saving";
            }
      }

      
   } 
?>
