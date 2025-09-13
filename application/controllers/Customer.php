<?php 
   class Customer extends CI_Controller {  

      function __construct() {
         parent::__construct();
         $this->load->library('session');
         $this->load->model('CustomerModel');
         $this->load->library('pagination');
         $this->load->library('form_validation'); // Load Form Validation Library
         load_site_language();

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
        header("Access-Control-Allow-Origin: *");
        $config = array();
        $config["base_url"] = base_url() . "Customer/create";
        $config["total_rows"] = $this->CustomerModel->record_count();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data = array();
        
        $data["custData"] = $this->CustomerModel->fetch_cust($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        
        $this->template->set('title', 'Dashboard');
        $this->template->load('default_layout', 'contents' , 'customer', $data);
     }

     public function edit($id){

      if(!$this->session->has_userdata('username')){
         redirect('login');
      } 
      //echo $this->session->userdata('username'); die;
      //echo "welcome To Dashboard";
      header("Access-Control-Allow-Origin: *");

      $data['customer'] = $this->CustomerModel->get_cust_by_id($id);
      $data['cid'] = $id;

       // Set validation rules
       $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[3]');
       $this->form_validation->set_rules('marathi', 'Marathi Name', 'required|trim');
      //  $this->form_validation->set_rules('dob', 'Date of Birth', 'required|callback_validate_date');
       $this->form_validation->set_rules('mobile1', 'Primary Mobile', 'required|regex_match[/^[0-9]{10}$/]');
      //  $this->form_validation->set_rules('mobile2', 'Secondary Mobile', 'regex_match[/^[0-9]{10}$/]');
      //  $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      //  $this->form_validation->set_rules('address', 'Address', 'required');
       //$this->form_validation->set_rules('weight', 'Weight', 'required');
       //$this->form_validation->set_rules('height', 'Height', 'required');


      if ($this->input->post()) {


         if ($this->form_validation->run() == FALSE) {
            // Load form with errors
            $this->template->load('default_layout', 'contents' , 'customerForm', $data);
        } else {

         $customerData = array(
            "name"=>$this->input->post('name'),
            "marathi"=>$this->input->post('marathi'),
            "dob"=>$this->input->post('dob'), 
            "mobile1"=>$this->input->post('mobile1'), 
            "mobile2"=>$this->input->post('mobile2'), 
            "email"=>$this->input->post('email'),
            "address"=>$this->input->post('address'), 
            "weight"=>$this->input->post('weight'), 
            "height"=>$this->input->post('height'), 
            "photo"=>null );
          if($this->CustomerModel->update_cust($id, $customerData)) {
            $this->session->set_flashdata('success', 'Customer updated Successfully!');
          } else {
            $this->session->set_flashdata('success', 'Customer Updated Successfully!');
          }
          redirect(base_url('Customer/create'));
         }     
      }
      //$this->load->view('customerForm', $data);
      $this->template->set('title', 'Customer Update');
      $this->template->load('default_layout', 'contents' , 'customerForm', $data);
   }

   public function validate_date($date) {
      // if (!DateTime::createFromFormat('Y-m-d', $date)) {
      //     $this->form_validation->set_message('validate_date', 'The {field} field must be in YYYY-MM-DD format.');
      //     return FALSE;
      // }
      return TRUE;
  }

     public function createDb(){

       if(!$this->session->has_userdata('username')){
         redirect('login');
      }
      $this->load->helper('url');
         //$formPost = $this->input->post();

      $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[3]');
      $this->form_validation->set_rules('marathi', 'Marathi Name', 'required|trim');
      // $this->form_validation->set_rules('dob', 'Date of Birth', 'required|callback_validate_date');
      $this->form_validation->set_rules('mobile1', 'Primary Mobile', 'required|regex_match[/^[0-9]{10}$/]');
      // $this->form_validation->set_rules('mobile2', 'Secondary Mobile', 'regex_match[/^[0-9]{10}$/]');
      // $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      // $this->form_validation->set_rules('address', 'Address', 'required');

      if ($this->form_validation->run() == true) {
      $customerData = array(
         "name"=>$this->input->post('name'),
         "marathi"=>$this->input->post('marathi'),
         "dob"=>$this->input->post('dob'), 
         "mobile1"=>$this->input->post('mobile1'), 
         "mobile2"=>$this->input->post('mobile2'), 
         "email"=>$this->input->post('email'),
         "address"=>$this->input->post('address'), 
         "weight"=>$this->input->post('weight'), 
         "height"=>$this->input->post('height'), 
         "photo"=>null );
         if($this->CustomerModel->insert($customerData)) {
            echo "Customer Added Successfully";
         } else {
            echo "Error In Customer Saving";
         }
      } else {
        echo validation_errors();
      }
     }
      
   } 
?>