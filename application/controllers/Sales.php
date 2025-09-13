<?php 
   class Sales extends CI_Controller {  

      function __construct() {
         parent::__construct();
         $this->load->library('session');
         $this->load->model('CustomerModel');
         $this->load->model('TypeModel');
         $this->load->model('FashionModel');
         $this->load->model('MeasurementModel');

         $this->load->model('BillMasterModel');
         $this->load->model('BillDetailModel');
         $this->load->model('JobMasterModel');
         $this->load->model('TransactionModel');
		  $this->load->library('pagination');//27 Feb 2024
		  $this->load->library('pdf_generator');//28 Feb 2024

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

        $data = array();

        $sql = "SELECT t.type_id,t.type_name,t.rate,(SELECT GROUP_CONCAT(m.m_name) from measurement_m m WHERE m.type_id = t.type_id) as measurements FROM type_m t";
        $query = $this->db->query($sql);
        $data = array();
        $data['typeData'] = $query->result_array();
        
        
        $data['logData'] = array();
        $data["custData"] = $this->CustomerModel->get_cust();
        //$data["fashionMData"] = $this->CustomerModel->get_cust();
        
        
        
        $this->template->set('title', 'New Bil');
        $this->template->load('default_layout', 'contents' , 'newBill', $data);
     }

     public function salesDb(){

      if(!$this->session->has_userdata('username')){
         redirect('login');
      } 
      header("Access-Control-Allow-Origin: *");
      $this->load->helper('url');

      $custId = $this->input->post('custselect'); 
      $billDate = $this->input->post('billdate');
      $trialDate = $this->input->post('trialdate');
	  $advancePayment = $this->input->post('tadvancepayment');//31 March 2024	 
      $yearId = 1; 
      $taxFlag = 0;
      $discount = 0;
      $taxAmount = 0 ;
      $storeId = 1;

      $items = $this->input->post('type');
      $rate = $this->input->post('rate');
      $qty = $this->input->post('qty');
      $additionaldtl = $this->input->post('additionaldtl');
      $measurement = $this->input->post('measurements'); 

	  //start 25 Mar 2024
      if(empty($custId) || empty($billDate) || empty($additionaldtl)  ) {
            echo "Please Enter Proper Data"; 
            return 0;
      }
      //end 25 Mar 2024
		 
      $totalAmount = 0;

      for($i = 0; $i < count($rate) ; $i++ ) {
         $totalAmount = $totalAmount + ( $rate[$i] * $qty[$i] ) ;
      }
      
      //call Tranaction procedure
      $daid = 1;
      $caid = 4;
      $drefid = $custId;
      $crefid = 0;
      $p_amt = $totalAmount;
      $p_disc= 'Sales Bill';

      
      $transactionId = $this->TransactionModel->createTransaction($billDate , $daid, $caid , $drefid, $crefid, $p_amt , $p_disc, $this->session->has_userdata('username') );
      

      //BillMasterModel,BillDetailModel,JobMasterModel,TransactionModel
      $billMasterData = array(
         "yearid"=>$yearId,
         "bill_date"=>$billDate,
         "cid"=>$custId,
         "discount"=>$discount,
         "tax_amt"=>$taxAmount, 
         "total_amt"=>$totalAmount,
         "userid"=>$this->session->has_userdata('username'),
         "tranid"=>$transactionId,
		 "advance_payment"=>$advancePayment,//31 March 2024
         "t_flag"=>0
      );
      $billMasterId = $this->BillMasterModel->insert($billMasterData);

      $this->TransactionModel->updateTransaction($transactionId,$yearId,array("crefid"=>$billMasterId));
      
      if(!empty($billMasterId)) {
		  
		  if($advancePayment > 0) { //start-  31 March 2024
            
            $caid =1;   
            $daid =  2 ; // 2 - cash account, 3 - bank account
            $drefid =  0;
            $crefid = $custId; //Customer Id Or worked Id
            $p_disc = array("Payment"=>"customer payment","PaymentType"=>"Cash");
            
            $transactionId = $this->TransactionModel->createTransaction($billDate , $daid, $caid , $drefid, $crefid, $advancePayment , json_encode($p_disc), $this->session->has_userdata('username') );
         } // end - 31 March 2024

         for($i = 0; $i < count($items) ; $i++ ) {

            $md = !empty($measurement[$i]) ? json_decode($measurement[$i],true) : array();
      
            $measurementArray = array();
            $fashionDetailsArray = array();

            // Iterate over the array
            foreach ($md as $element) {
               // Check if the name starts with a number
               if (preg_match('/^\d/', $element['name'])) {
                  // Add to array with number
                  $fashionDetailsArray[] = $element;
               } else {
                  // Add to array without number
                  $measurementArray[] = $element;
               }
            }

            $jobMData = array(
               "yearid"=> $yearId,
               "billno"=> $billMasterId,
				"cust_id"=>$custId,//1 Mar 2024
               "typeid"=> $items[$i],
				"total_qty"=>$qty[$i], // 04 May 2024
               "fashion_dtl"=> json_encode($fashionDetailsArray), 
               "status"=> 0, 
               "order_date"=> $billDate,
               "delivery_date"=> $trialDate,
               "note"=> "",
               "storageid"=>$storeId, 
               "job_details"=> json_encode($measurementArray), 
               "additional_details"=> $additionaldtl[$i]
            );

            //print_r($jobMData); die;
            $jobMasterId = $this->JobMasterModel->insert($jobMData);

            if(!empty($jobMasterId)) {
               $billDetailsData = array(
                  "bill_no"=>$billMasterId, 
                  "yearid"=> $yearId,
                  "type_id"=> $items[$i],  
                  "trial_date"=>$trialDate, 
                  "delivery_date"=>$trialDate, 
                  "jobid"=>$jobMasterId, 
                  "t_flg"=>$taxFlag, 
                  "discount"=> $discount,
                  "rate"=> $rate[$i],
                  "qty"=> $qty[$i],
                  "tax_amt"=>$taxAmount
               );
               $billDetailId = $this->BillDetailModel->insert($billDetailsData);
            } else {
               echo "Error In Adding Bill. Job Master Id Is Empty ";
               return 0;
            }

            
         } // End foreach of Bill Details
         echo "Bill Saved Successfully";

         

      } else {
         echo "Error In Adding Bill. Bill Master Id Is Empty";
      }
      
      
      

     }

     function getFashionMData($typeId =  0 ) {
      
      header('Content-Type: application/json');   
      echo json_encode($this->FashionModel->getFashionByTypeId($typeId));
     
   }
/*
   public function getMeasurementByTypeId($typeId = 0 ) {
      //echo "hi";  die;
      header('Content-Type: application/json');   
      echo json_encode($this->MeasurementModel->getMeasurementByTypeId($typeId));
      
   }*/
	   
   public function getMeasurementByTypeId($typeId = 0 ) { //22 April 2024
      //echo "hi";  die;
      header('Content-Type: application/json');   
      $custId = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      //echo $custId; die;

      $measurement = $this->JobMasterModel->getMeasurementByCustId($custId,$typeId);
      
      echo json_encode(array("measurement"=>$this->MeasurementModel->getMeasurementByTypeId($typeId),"custMeasurement"=>json_decode($measurement),true));
      
   }	   
	   
   //27 Feb 2024
   public function salesReport(){

      if(!$this->session->has_userdata('username')){
         redirect('login');
      } 
      //echo $this->session->userdata('username'); die;
      //echo "welcome To Dashboard";
      header("Access-Control-Allow-Origin: *");
      
      $this->load->helper('url');

      $sdate = '';
      $edate = '';
	   $custId = '' ;
      if($this->input->server('REQUEST_METHOD') === 'POST') {
		  $custId =  $this->input->post('custselect');
         $sdate =  $this->input->post('sdate');
         $edate =  $this->input->post('edate');
         
      }
      

      $config = array();
      $config["base_url"] = base_url() . "Master/salesReport";
      $config["total_rows"] = $this->BillMasterModel->record_count();
      $config["per_page"] = 1000;
      $config["uri_segment"] = 3;

      $this->pagination->initialize($config);
      $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
      $billData = $this->BillMasterModel->getBillMaster($config["per_page"], $page , $sdate, $edate, $custId);
      $data["billData"] = !empty($billData) ? $billData : array();
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
	   $data["custData"] = $this->CustomerModel->get_cust();
      $data["links"] = $this->pagination->create_links();
      
      
      $this->template->set('title', 'Sales Report');
      $this->template->load('default_layout', 'contents' , 'salesReport', $data);

   }	

	   //28 Feb 2024
public function generatePdf($billData = array()){
   // Your dynamic data for the table

   if(!$this->session->has_userdata('username')){
      redirect('login');
   } 
   //echo $this->session->userdata('username'); die;
   //echo "welcome To Dashboard";
   header("Access-Control-Allow-Origin: *");
   /*
   if($this->input->server('REQUEST_METHOD') === 'POST') {
      $sdate =  $this->input->post('sdate');
      $edate =  $this->input->post('edate');
   }
   */
  $yearId = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
  $billNo = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

  $billData = $this->BillMasterModel->getBillMasterByBillNo(array("billno"=>$billNo,"yearid"=>$yearId));
  $billDtlData = $this->BillDetailModel->getBillDetailByBillNo(array("bill_no"=>$billNo,"yearid"=>$yearId));

  //print_r($billDtlData); die;
   $this->load->helper('url');
        
      $mData = array("billno"=>$billData['billno'],"billDate"=>$billData['bill_date'],"custname"=>$billData['name'],"advancePayment"=>$billData['advance_payment']);
      
      $data = array();

      $i = 1;
      $totalAmt = 0;
      $totalQty = 0;
      foreach($billDtlData as $row) {
         //print_r($row); die;
         $totalAmt = $totalAmt + ($row['qty']*$row['bill_rate']);
         $totalQty = $totalQty +  $row['qty'];
         $data[] = array("sr"=> $i , 'item' => $row['type_name'] , 'qty' => $row['qty'] ,'rate' => $row['bill_rate'], 'total' => ($row['qty']*$row['bill_rate']) );
         $i++;
      }
      $data[] = array("sr"=> '' , 'item' => 'TOTAL' , 'qty' => $totalQty ,'rate' => '', 'total' => $totalAmt );
	
	if($billData['advance_payment'] > 0) { //start - 31 March 2024
         $data[] = array("sr"=> '' , 'item' => 'Advance Payment' , 'qty' => '' ,'rate' => '', 'total' => $billData['advance_payment'] );   
		$data[] = array("sr"=> '' , 'item' => 'Remaining Bill O/S Amount' , 'qty' => '' ,'rate' => '', 'total' => $totalAmt-$billData['advance_payment'] );   
      } //end - 31 March 2024
      
      /*
      $data = array(
            
            array('sr' => 1, 'item' => 'Item 1', 'qty' => 2, 'rate' => 10, 'total' => 20),
            array('sr' => 2, 'item' => 'Item 2', 'qty' => 3, 'rate' => 15, 'total' => 45),
            array('sr' => '', 'item' => '', 'qty' => '', 'rate' => '', 'total' => ''),
            array('sr' => '', 'item' => '', 'qty' => '', 'rate' => '', 'total' => ''),
            array('sr' => '', 'item' => '', 'qty' => '', 'rate' => '', 'total' => ''),
            
            // Add more rows as needed
        );
        */
        // Generate PDF
        $this->pdf_generator->generate_pdf($data,$mData);
}
      
   } 
?>