<?php 
   class Worker extends CI_Controller {  

      function __construct() {
         parent::__construct();
         $this->load->library('session');
         $this->load->model('WorkerModel');
         $this->load->library('pagination');
         $this->load->library('form_validation'); // Load Form Validation Library
         $tz = 'Asia/Kolkata';   
   			date_default_timezone_set($tz);
         load_site_language();
         
     }
	
     public function index(){
        
        //$this->load->database();
        //$query = $this->db->get_where("qr_m",array("unique_code"=>$urlCode)); 
        //$this->load->view('Login'); 
        
     }
     
     public function create(){

        if(!$this->session->has_userdata('username')){
           redirect('login');
        } 
        //echo $this->session->userdata('username'); die;
        //echo "welcome To Dashboard";
        header("Access-Control-Allow-Origin: *");

        $config = array();
        $config["base_url"] = base_url() . "Worker/create";
        $config["total_rows"] = $this->WorkerModel->record_count();
        $config["per_page"] = 50;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["workerData"] = $this->WorkerModel->fetch_cust($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        //$data = array();
        //$data['logData'] = array();
        $this->template->set('title', 'New Worker');
        $this->template->load('default_layout', 'contents' , 'worker', $data);
     }

     public function createDb(){

      $this->load->helper('url');
         //$formPost = $this->input->post();

         $visible = !is_null($this->input->post('visible')) ? 1 : 0;
         $customerData = array(
         "name"=>$this->input->post('name'),
         "dob"=>$this->input->post('dob'), 
         "doj"=>$this->input->post('doj'), 
         "mobile1"=>$this->input->post('mobile1'), 
         "mobile2"=>$this->input->post('mobile2'), 
         "w_type_id"=>$this->input->post('w_type_id'),
         "visible"=>$visible, 
         );
         //"w_type_id"=>$this->input->post('o_bal'),
         if($this->WorkerModel->insert($customerData)) {
            echo "Worker Added Successfully";
         } else {
            echo "Error In Worker Saving";
         }
     }

       public function edit($id){

      if(!$this->session->has_userdata('username')){
         redirect('login');
      } 
      //echo $this->session->userdata('username'); die;
      //echo "welcome To Dashboard";
      header("Access-Control-Allow-Origin: *");

      $data['worker'] = $this->WorkerModel->get_worker_by_id($id);
      $data['cid'] = $id;
      //print_r($data['worker'] ); die;

       $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[3]');
       //$this->form_validation->set_rules('dob', 'Date of Birth', 'required|callback_validate_date');
       $this->form_validation->set_rules('mobile1', 'Primary Mobile', 'required|regex_match[/^[0-9]{10}$/]');
       $this->form_validation->set_rules('mobile2', 'Secondary Mobile', 'required|regex_match[/^[0-9]{10}$/]');
       $this->form_validation->set_rules('w_type_id', 'Worker Type', 'required');
      if ($this->input->post()) {

         if ($this->form_validation->run() == FALSE) {
            // Load form with errors
            $this->template->load('default_layout', 'contents' , 'workerForm', $data);
        } else {

         $workerData = array(
            "name"=>$this->input->post('name'),
            "dob"=>$this->input->post('dob'), 
            "doj"=>$this->input->post('doj'), 
            "mobile1"=>$this->input->post('mobile1'), 
            "mobile2"=>$this->input->post('mobile2'), 
            "w_type_id"=>$this->input->post('w_type_id'),
            //"obal"=>$this->input->post('obal'),
            "visible"=>!is_null($this->input->post('visible')) ? 1 : 0, 
         );
            if($this->WorkerModel->update_worker($id, $workerData)) {
               $this->session->set_flashdata('success', 'Worker updated Successfully!');
            } else {
               $this->session->set_flashdata('success', 'Worker Updated Successfully!');
            }
          redirect(base_url('Worker/create'));
         }     
      }
       //$this->load->view('customerForm', $data);
         $this->template->set('title', 'Worker Update');
         $this->template->load('default_layout', 'contents' , 'workerForm', $data);
   }
   
      
   } 
?>