<?php 
   class QR extends CI_Controller {  

      function __construct() {
         parent::__construct();
         $this->load->library('session');
     }
	
      
      public function index() { 
         //echo "This is default function."; 
         $this->load->view('Test'); 
      } 
      public function dashBoard(){

         if(!$this->session->has_userdata('username')){
            redirect('qr');
         } 
         //echo $this->session->userdata('username'); die;
         //echo "welcome To Dashboard";
         header("Access-Control-Allow-Origin: *");

         $sql = "SELECT count(surl) as totalUrls,sum(visits) as totalVisits FROM url_master where userName like '".$this->session->userdata('username')."'";
         $query = $this->db->query($sql);
         $data = array();
         $data['counts'] = $query->result_array();

         $this->template->set('title', 'Dashboard');
         $this->template->load('default_layout', 'contents' , 'dashboard-stat', $data);
      }

      public function createUrl(){

         if(!$this->session->has_userdata('username')){
            redirect('qr');
         } 
         //echo $this->session->userdata('username'); die;
         //echo "welcome To Dashboard";
         header("Access-Control-Allow-Origin: *");
         $data = array();
         $this->template->set('title', 'Dashboard');
         $this->template->load('default_layout', 'contents' , 'createUrl', $data);
      }

      public function shortUrlList(){

         if(!$this->session->has_userdata('username')){
            redirect('qr');
         } 
         //echo $this->session->userdata('username'); die;
         //echo "welcome To Dashboard";
         header("Access-Control-Allow-Origin: *");
         $this->load->database();
         $query = $this->db->get_where("url_master",array("userName"=>$this->session->userdata('username')));
         $data = array();
         $data['urlList'] = $query->result_array();
         
         $this->template->set('title', 'Short Url List');
         $this->template->load('default_layout', 'contents' , 'shortUrlList', $data);
      }

      public function logReport(){

         if(!$this->session->has_userdata('username')){
            redirect('qr');
         } 
         //echo $this->session->userdata('username'); die;
         //echo "welcome To Dashboard";
         header("Access-Control-Allow-Origin: *");
         $this->load->database();
         $query = $this->db->get_where("url_visit_log",array("userName"=>$this->session->userdata('username')));
         $data = array();
         $data['logData'] = $query->result_array();
         //print_r($query->result_array()); die;
         
         $this->template->set('title', 'Short Url List');
         $this->template->load('default_layout', 'contents' , 'logReport', $data);
      }
      
      public function qrEngineLogin(){
         $segs = $this->uri->segment_array();
         $urlCode = $segs[3];

         $this->load->database();
         $query = $this->db->get_where("qr_m",array("unique_code"=>$urlCode)); 
        
         if($query->num_rows() > 0 ){
            foreach($query->result_array() as $row) {
               
               //$row['status_'] = 2;
               if($row['status_'] == 1 ) {
                  //Display Login Form
                  $data['urlData'] = array("uniqueCode"=>$urlCode);
                  $this->load->view('QrDetailLogin',$data); 
               } else if($row['status_'] == 2 ) {
                  //Display QR Details Data

                  $data = array();
                  $data['dogDtl'] = $row;
                  $this->load->view('QrDetailsDisplay',$data);
               } else {
                  //Display Error Message - QR Disabled
               }          
            }
         }
      }

      public function qrEngineLoginDb(){

         $this->load->helper('url');
         $formPost = $this->input->post();

         $userName = $this->input->post('email');
         $password = $this->input->post('password');
         $urlCode = $this->input->post('urlcode');

         //echo $urlCode; die;
         //echo "In QR Login";
         $this->load->database();
         $query = $this->db->get_where("qr_m",array("qrUserName"=>$userName,"qrPassword"=>$password,  
         "unique_code"=>$urlCode)); 
         $result = $query->result();

         if($query->num_rows() > 0 ){
            foreach($query->result() as $row) {
               if($row->status_ == 1 ) {
                  
                  $array = array('username'  => $userName,
                  'uniquCode'     => $urlCode,
                  'logged_in' => TRUE);
                  $this->session->set_userdata($array);
                  //echo "User Details Matched"; die;
                  redirect(base_url().'qr/qrDetailsFill');
                  //$this->load->view('QrDetailsForm');
               } else {
                  echo "Invalid Login Details";
                  //redirect(base_url().'qr');
               }
            }
         } else {
            //redirect(base_url().'qr');
            echo "Authorisation Failed"; die;
         }

      }

      public function qrEngineForm(){
         $this->load->view('QrDetailsForm');
      }

      public function qrEngineFormDb(){


         $this->load->model('QrModel');
         $formPost = $this->input->post();
         
         $imagePrefix = time(); 
         $imagename = $imagePrefix.'_qrImage';
         
         $imgUploadFolderName = 'qrUploads';
         //image Upload Code
         $config['upload_path']          = './'.$imgUploadFolderName.'/';
         $config['allowed_types']        = 'gif|jpg|png';
         $config['max_size']             = 2000;
         $config['file_name'] = $imagename;
         //$config['max_width']            = 1024;
         //$config['max_height']           = 768;


         $this->load->helper(array('form', 'url'));

         $this->load->library('upload', $config);
         $this->upload->initialize($config);
         

         if ( ! $uploadImage = $this->upload->do_upload('petimage'))
         {
                  $error = array('error' => $this->upload->display_errors());
                  print_r($error);
                  //$this->load->view('upload_form', $error);
         } else {
            echo "\n Failed Image Upload";
         }

         $imageUploadedData = $this->upload->data();

         $petImagePath = base_url().$imgUploadFolderName.'/'.$imagename.$imageUploadedData['file_ext']; 
         //die;
         //end of image upload Code    
         $userName = $this->session->userdata('username');
         $uniquCode = $this->session->userdata('uniquCode');

         $data = array("form_data"=>json_encode($formPost),"status_"=>2,"qrProfilePhotoUrl"=>$petImagePath);
         $this->QrModel->updateQrFormDetails($userName ,$uniquCode, $data);
         redirect(base_url().'qr/qrDetails/'.$uniquCode);
   }
  
      public function hello() { 
         echo "This is hello function."; 
      } 
      public function qrDetails(){
        echo "In QR Details";
      }

      /*
      This is used for redirect short urls to it's orignal urls
      */
      public function shortenUrlCall(){
         
         $this->load->helper('url');
         $this->load->model('QrModel');

         $requestInformation = $this->input->request_headers();
         $this->load->library('user_agent');
         $requestData['browser'] = $this->agent->browser();
         $requestData['browser_version'] = $this->agent->version();
         $requestData['os'] = $this->agent->platform();
         $requestData['ip_address'] = $this->input->ip_address();
         
         if ($this->agent->is_browser())
         {
               $agent = $this->agent->browser().' '.$this->agent->version();
         }
         elseif ($this->agent->is_robot())
         {
               $agent = $this->agent->robot();
         }
         elseif ($this->agent->is_mobile())
         {
               $agent = $this->agent->mobile();
         }
         else
         {
               $agent = 'Unidentified User Agent';
         }

         
         //$platForm =  $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)

         $segs = $this->uri->segment_array();
         $urlCode = $segs[1];

         $this->load->database();
         $query = $this->db->get_where("url_master",array("surl"=>$urlCode)); 
        
         if($query->num_rows() > 0 ){
            foreach($query->result_array() as $row) {
               //print_r($row);
               $lastVisitsCount = $row['visits'];
               $data = array("visits"=>$lastVisitsCount+1);
               $this->QrModel->updateUrlCallCount($row['id'],$urlCode,$data); 

               //UrlVisitLog
               $urlLogData = array(
                  "master_id"=>$row['id'],
                  "client_id"=>"",
                  "surl"=>$urlCode,
                  "ip_address"=>$requestData['ip_address'],
                  "device"=>$agent,
                  "userName"=>$row['userName'],
                  "extra_info"=>json_encode($requestInformation)
               );

               $this->QrModel->insertUrCallLog($urlLogData); 
               redirect($row['ourl']);
            }
         }
         
      }

      public function generateUrl(){

         if($this->session->has_userdata('username')){

            

            $this->load->model('QrModel');
      
            $uniquCode = '';
            //uniqCode
            $data = $this->db->query("select uniqCode() as ucode");
            $result = $data->result_array();
            
            foreach($result as $row) {
               //print_r($row);
               $uniquCode = $row['ucode'];
            }
            //echo "UniqueCode Is :".$uniquCode;
            $data = array( 
               'surl' => $uniquCode, 
               'ourl' => $this->input->post('userUrl'),
               'visits'=> 0, 
               'userName'=>$this->session->userdata('username')
            ); 
            
            if($this->QrModel->insert($data)){
               $shortenUrl = base_url().$uniquCode;
               $shortenUrl = "<a href='".$shortenUrl."' target='_NEW'>".$shortenUrl."</a>";
               echo json_encode(array("message"=>"Shorten Url Successfully Created","surl"=>$shortenUrl));
            } else {
               echo json_encode(array("message"=>"Shorten Url Creation failed. Please try after some time"));
            }
      
            //$query = $this->db->get("url_master"); 
            //$data = $query->result_array(); 
            //$this->load->view('Stud_view',$data);
            
            
         } else {
            echo "please login";
         }
         
      }

      public function login(){
         $this->load->helper('url');
         $formPost = $this->input->post();

         $userName = $this->input->post('email');
         $password = $this->input->post('password');
         //echo "In QR Login";
         $this->load->database();
         $query = $this->db->get_where("users_security",array("userName"=>$userName,"password"=>$password)); 
         //$result = $query->result();
         //print_r($data['records']);
        // echo $query; die;
        
         if($query->num_rows() > 0 ){
            foreach($query->result() as $row) {
               //print_r($row);
               if($row->userStatus == 1 ) {
                  
                  $array = array('username'  => $userName,
                  'email'     => 'johndoe@some-site.com',
                  'logged_in' => TRUE);
                  $this->session->set_userdata($array);
                  
                  redirect(base_url().'qr/dashboard');
               } else {
                  redirect(base_url().'qr');
               }
            }
         } else {
            redirect(base_url().'qr');
         }

      }

      public function userLogout(){

      }

      
   } 
?>