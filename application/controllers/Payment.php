<?php 
   class Payment extends CI_Controller {  

      function __construct() {
         parent::__construct();
         $this->load->library('session');
         $this->load->model('TransactionModel');
         $this->load->model('CustomerModel');
         $this->load->model('WorkerModel');
         

         
         $this->load->library('pagination');
         load_site_language();
     }
	
     public function index(){
        
        //$this->load->database();
        //$query = $this->db->get_where("qr_m",array("unique_code"=>$urlCode)); 
        //$this->load->view('Login'); 
        
     }
     
     public function payment(){

        if(!$this->session->has_userdata('username')){
           redirect('login');
        } 
        header("Access-Control-Allow-Origin: *");
        $data = array();
        
        $paymentFormType = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $formTitle = ($paymentFormType == 1) ? 'Customer Payment' : 'Worker Payment';

        if($paymentFormType == 1 ) {
            $data["customerData"] = $this->CustomerModel->get_cust();    
        } else {
            $data["workerData"] = $this->WorkerModel->get_worker();
        }
        
        //$data["links"] = $this->pagination->create_links();
        
        $data['title'] = $formTitle;
        $data['paymentFormType'] = $paymentFormType;

        $this->template->set('title', $formTitle);
        $this->template->load('default_layout', 'contents' , 'payment', $data);
     }

     public function paymentDb(){

      $this->load->helper('url');
         //$formPost = $this->input->post();

         $paymentFormType = $this->input->post('paymentformtype'); // 1 - Customer

         $date_ = $this->input->post('date');
         $id = $this->input->post('customer_worker');
         $amount = $this->input->post('amount');
         $payment_type = $this->input->post('payment_type');
         $transaction_no = $this->input->post('transaction_no');

         if($paymentFormType == 1){
            $caid =1;   
            $daid =  ( $payment_type == 1 ) ?  2 : 3; // 2 - cash account, 3 - bank account
            $drefid =  0;
            $crefid = $id; //Customer Id Or worked Id
         } else {
            $caid = ( $payment_type == 1 ) ?  2 : 3; // 2 - cash account, 3 - bank account;   
            $daid = 7;
            $drefid =  $id;
            $crefid = 0; //Customer Id Or worked Id
         }

         $caid = ( $paymentFormType == 1 ) ? 1 : 7 ; // 1 = customer account , 7 = Employee Account
         
         
         
         $p_amt = $amount;
         if($paymentFormType == 1) {
            $p_disc = array("Payment"=>"customer payment","PaymentType"=>"Cash");
         } else {
            $p_disc = $p_disc = array("Payment"=>"Worker payment","PaymentType"=>"Cash","transactionId"=>$transaction_no);
         }
         

         $transactionId = $this->TransactionModel->createTransaction($date_ , $daid, $caid , $drefid, $crefid, $p_amt , json_encode($p_disc), $this->session->has_userdata('username') );

        if(!empty( $transactionId)) {
            echo "Customer payment Successfull";
        } else {
            echo "Something went wrong";
        }
        
         
     }
      
   } 
?>