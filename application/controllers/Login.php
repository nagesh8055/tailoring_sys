<?php 
   class Login extends CI_Controller {  

      function __construct() {
         parent::__construct();
         $this->load->library('session');
         load_site_language();
     }
	
     public function index(){
        
        //$this->load->database();
        //$query = $this->db->get_where("qr_m",array("unique_code"=>$urlCode)); 
        $this->load->view('Login'); 
        
     }

     
     
     public function authenticate(){
        $this->load->helper('url');
        $formPost = $this->input->post();

        $userName = $this->input->post('email');
        $password = $this->input->post('password');
        //echo "In QR Login";
        $this->load->database();
        $query = $this->db->get_where("security",array("uname"=>$userName,"pass"=>$password)); 
        //$result = $query->result();
        //print_r($data['records']);
       // echo $query; die;
       
        if($query->num_rows() > 0 ){
           foreach($query->result() as $row) {
              //print_r($row);
              if($row->lock1 == 0 ) {
                 
                 $array = array('username'  => $userName,
                 'email'     => 'johndoe@some-site.com',
                 'logged_in' => TRUE);
                 $this->session->set_userdata($array);
                 
                 redirect(base_url().'dashboard');
              } else {
                 redirect(base_url().'login');
              }
           }
        } else {
           redirect(base_url().'login');
        }
     }
     
     public function dashBoard(){

        if(!$this->session->has_userdata('username')){
           redirect('login');
        } 
        //echo $this->session->userdata('username'); die;
        //echo "welcome To Dashboard";
        header("Access-Control-Allow-Origin: *");
		 $sql = "SELECT name,day(dob) as day,mobile1 FROM `cust_m` WHERE month(dob) = MONTH(NOW()) and day(dob) > day(now())";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        //$sql = "SELECT count(surl) as totalUrls,sum(visits) as totalVisits FROM url_master where userName like '".$this->session->userdata('username')."'";
        //$query = $this->db->query($sql);
        $data = array();
        $data['counts'] = 0;//$query->result_array();
		 $data['birthdays'] = $result;

        $this->template->set('title', 'Dashboard');
        $this->template->load('default_layout', 'contents' , 'dashboard-stat', $data);
     }

     public function logout(){
        
        //$this->load->database();
        //$query = $this->db->get_where("qr_m",array("unique_code"=>$urlCode)); 
        redirect(base_url().'login');
        
     }
      
   } 
?>