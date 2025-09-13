<?php 
   class Job extends CI_Controller {  

      function __construct() {
         parent::__construct();
         $this->load->library('session');
         $this->load->model('WorkerModel');
		  $this->load->model('CustomerModel');
         $this->load->model('JobMasterModel');
		  $this->load->model('JobTrackingModel');
         $this->load->model('WorkerModel');
         $this->load->model('StorageModel');
         $this->load->model('WorkerCommisionModel');
         $this->load->model('TransactionModel');
         $this->load->model('TypeModel');
         $this->load->model('YearMasterModel');
		  $this->load->model('MeasurementModel');
		  $this->load->model('JobDeliveryLogModel');
         
		$this->load->library('PDF_Code39');//29 Feb 2024
         $this->load->library('pagination');
		  $tz = 'Asia/Kolkata';   
   			date_default_timezone_set($tz);
            load_site_language();
     }
	
     public function index(){
        
        //$this->load->database();
        //$query = $this->db->get_where("qr_m",array("unique_code"=>$urlCode)); 
        //$this->load->view('Login'); 
        
     }
     
	   /*
     public function assignJob(){

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
           // $sdate =  $this->input->post('sdate');
           // $edate =  $this->input->post('edate');
        }
      
        if(!empty($custId)) {
			$data["jobData"] = $this->JobMasterModel->get_jobMaster(array("job_m.cust_id"=>$custId,"job_m.status"=>0),array("job_m.status"=>2));
        } else {
			
            $data["jobData"] = $this->JobMasterModel->get_jobMaster(array("job_m.status"=>0),array("job_m.status"=>2));
        }
        
		$data["custData"] = $this->CustomerModel->get_cust();
        $this->template->set('title', 'Assign Job');
        $this->template->load('default_layout', 'contents' , 'assignJob', $data);
     }*/
	   public function assignJob(){

        if(!$this->session->has_userdata('username')){
           redirect('login');
        } 
        //echo $this->session->userdata('username'); die;
        //echo "welcome To Dashboard";
        header("Access-Control-Allow-Origin: *");
        $this->load->helper('url');
        
        $config = array();
        $config["base_url"] = base_url() . "Job/assignJob";
        $config["total_rows"] = $this->CustomerModel->record_count();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        
        $sdate = '';
        $edate = '';
        $custId = '' ;
        if($this->input->server('REQUEST_METHOD') === 'POST') {
            $custId =  $this->input->post('custselect');
            $sdate =  $this->input->post('sdate');
            $edate =  $this->input->post('edate');
        }
       
        //status -  '0 - New Job , 1 - In process , 2 - partialy completed , 3 - completed , 4 - partialy delivered , 5 - Delivered'
        $jobData = array();
        if(!empty($custId)) {
            $jobData = $this->JobMasterModel->get_jobMaster(array("job_m.cust_id"=>$custId),array("job_m.status"=>0 , "job_m.status"=>1 , "job_m.status"=>2),25);
        } else {
            $jobData = $this->JobMasterModel->get_jobMaster(array(),array("job_m.status=0" , "job_m.status=1" , "job_m.status=2"),$config["per_page"], $page);
        }
        
        for($i =0 ; $i < count($jobData) ; $i++ ) {
            $jobData[$i]['c_ass_qty'] = $this->JobTrackingModel->getAssignQty($jobData[$i]['jobid'],$jobData[$i]['typeid'],0);
            $jobData[$i]['s_ass_qty'] = $this->JobTrackingModel->getAssignQty($jobData[$i]['jobid'],$jobData[$i]['typeid'],1);
        }
        
        //print_r($jobData); die;
        $data["jobData"] = $jobData;
        //print_r($jobData);
        //$data["links"] = $this->pagination->create_links();
        $data["custData"] = $this->CustomerModel->get_cust();
        $data["links"] = $this->pagination->create_links();
        //$data = array();
        //$data['logData'] = array();
        $this->template->set('title', 'Assign Job');
        $this->template->load('default_layout', 'contents' , 'assignJob', $data);
        //$this->template->load('default_layout', 'contents' , 'commisonReport', $data);
     }
	   public function assignJobDb(){

        if(!$this->session->has_userdata('username')){
            redirect('login');
         } 
         header("Access-Control-Allow-Origin: *");

        $this->load->helper('url');

        $jobId = $this->input->post('jobid');
        $custId = $this->input->post('custid');
        $workerId = $this->input->post('worker');
        $assignDate = $this->input->post('date');
        $assignQty = $this->input->post('jobqty');
        //$status = $this->input->post('tstatus'); // 1- submit cutter Job
        $jobMasterRow = $this->JobMasterModel->get_job_by_id($jobId);
        $maxQty = $jobMasterRow['total_qty'];//$this->input->post('jobmaxqty');
        $jobType = $this->input->post('jobtype');

        if(!empty($jobMasterRow) && !empty($workerId) && !empty($assignDate)) {
        
            $jobData = array(
                "status"=>1,//In Process
            );

            if($jobType == 0 /*$status == 0*/) { // Assign cutter

                $existingAssQty = $this->JobTrackingModel->getAssignQty($jobId,$jobMasterRow['typeid'],$jobType);
                if($maxQty < ($existingAssQty + $assignQty )) {
                   echo "Invalid QTY. Assigned Qunatity Missmatch";
                   return 0; 
                }
                //if($maxQty < $jobMasterRow[''] )

                $jobData["cutter_id"]=$workerId;
                $jobData["cut_ass_date"]=$assignDate;
                $jobData["cut_assign_user"]="shree";   
            } else if($jobType == 1) {
                $existingAssQty = $this->JobTrackingModel->getAssignQty($jobId,$jobMasterRow['typeid'],$jobType);
                //$existingAssQty = getAssignQty($jobId,$jobMasterRow['typeid'],$jobType);
                $cutterCompleteQty = $jobMasterRow['cutter_complete_qty'];
                //$steacherCompleteQty = $jobMasterRow['steacher_complete_qty'];
                if(($existingAssQty + $assignQty ) > $cutterCompleteQty) {
                   echo "Invalid QTY. Assigned Qunatity Is Gretter Than cutter completed QTY";
                   return 0; 
                }

                $jobData["sur_id"]=$workerId;
                $jobData["sur_ass_date"]=$assignDate;
                $jobData["sur_assign_user"]="shree";   
            }

            $msg = "Cutter Assigned Successfully";
            
            $jobTrackingData = array(
            "job_id"=>$jobId, 
            "cust_id"=>$jobMasterRow['cust_id'], 
            "type_id"=>$jobMasterRow['typeid'], 
            "bill_no"=>$jobMasterRow['billno'], 
            "worker_id"=>$workerId, 
            "ass_qty"=>$assignQty, 
            "job_type"=>$jobType);
        
            $this->JobTrackingModel->insert($jobTrackingData);

            if($jobType == 1/*$status == 1*/) { // Assign steacher
                
                $msg = "Steacher Assigned Successfully";
            }

            $this->JobMasterModel->update_job($jobId,$jobData);
            echo $msg;
            // echo $jobId.'\n';
            // print_r($jobData);
            // if(!empty($this->JobMasterModel->update_job($jobId,$jobData))){
            //     echo $msg;
            // } else {
            //     echo "Failed To Assign JOb";
            // }
        } else {
            echo "Error In Assigning Job. Job Master Data Not Found Or Worker Id Or Assig Date Is Empty";
        }

    }
	
    public function completeJob(){

        if(!$this->session->has_userdata('username')){
           redirect('login');
        } 
        header("Access-Control-Allow-Origin: *");

        $data["jobData"] = $this->JobTrackingModel->get_jobTracking(array("job_tracking.status !="=>2),array("job_m.status"=>2));
        $data["workerData"] = $this->WorkerModel->get_worker();
        $data["storageData"] = $this->StorageModel->get_storage();

        

        $this->template->set('title', 'Complete Job');
        $this->template->load('default_layout', 'contents' , 'completeJob', $data);
     }
	   
     public function getWorkerName($id) {
        $row = $this->JobMasterModel->get_worker_by_id($id);   
        return $row['name'];
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

     public function getWorkerList($status = 0){
        
        header('Content-Type: application/json');   
        $where = array();
        if($status == 0 ){
            $where = array("w_type_id"=>1);
        }  else if($status == 1) {
            $where = array("w_type_id"=>2);
        }
        echo json_encode($this->WorkerModel->get_worker($where)); 
    }   
     /*
     public function getWorkerName($id) {
        $row = $this->JobMasterModel->get_worker_by_id($id);   
        return $row['name'];
     }*/
/* 12-05-2024
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
     }*/

     /* 12-05-2024
     public function getWorkerList($status = 0){
        header('Content-Type: application/json');   
        $where = array();
        if($status == 0 ){
            $where = array("w_type_id"=>1);
        }  else if($status == 2) {
            $where = array("w_type_id"=>2);
        }
        echo json_encode($this->WorkerModel->get_worker($where)); 
    }*/

    public function jobReport(){

        if(!$this->session->has_userdata('username')){
           redirect('login');
        } 
        header("Access-Control-Allow-Origin: *");


        $custId = '' ;
        $data["custId"] = '';
        $data["jobId"] = '';
        $data["billNo"] = '';

        if($this->input->server('REQUEST_METHOD') === 'POST') {
            $custId =  $this->input->post('custselect');
            $jobId =  $this->input->post('jobid');
            $billNo =  $this->input->post('billno');
            $filterArray = array();
            if(!empty($custId)) {
                
                $filterArray = array("job_m.cust_id"=> $custId);
                $data["custId"] = $custId;
            }
            if(!empty($jobId)) {
                $filterArray = array("job_m.jobid"=> $jobId);
                $data["jobId"] = $jobId;
            }
            if(!empty($billNo)) {
                $filterArray = array("job_m.billno"=> $billNo);
                $data["billNo"] = $billNo;
            }

            $data["jobData"] = $this->JobMasterModel->get_jobMaster($filterArray);
        } else {
            $data["jobData"] = $this->JobMasterModel->get_jobMaster();
        }

        $data["custData"] = $this->CustomerModel->get_cust();
        
        $data["workerData"] = $this->WorkerModel->get_worker();
        $data["storageData"] = $this->StorageModel->get_storage();

        
        $this->template->set('title', 'Job Report');
        $this->template->load('default_layout', 'contents' , 'jobreport', $data);
        
    }
     
    

     

    
    public function assignCutter(){

        if(!$this->session->has_userdata('username')){
            redirect('login');
         } 
         header("Access-Control-Allow-Origin: *");

        $this->load->helper('url');

        $jobId = $this->input->post('jobid');
        $workerId = $this->input->post('worker');
        $assignDate = $this->input->post('date');
        $status = $this->input->post('tstatus'); // 1- submit cutter Job
        
        
        if($status == 0) { // Assign cutter
            $jobData = array(
                "cutter_id"=>$workerId,
                "cut_ass_date"=>$assignDate,
                "status"=>1,
                "cut_assign_user"=>"shree"
            );
            $msg = "Cutter Assigned Successfully";
        }
        if($status == 2) { // Assign steacher
            $jobData = array(
                "sur_id"=>$workerId,
                "sur_ass_date"=>$assignDate,
                "status"=>3,
                "sur_assign_user"=>"shree"
            );
            $msg = "Steacher Assigned Successfully";
        }

		$updateJob = $this->JobMasterModel->update_job($jobId,$jobData);
        if(!empty($updateJob)){
            echo $msg;
        } else {
            echo "Failed To Assign JOb";
        }

    }

    public function submitJobBKP() {

        if(!$this->session->has_userdata('username')){
            redirect('login');
         } 
         header("Access-Control-Allow-Origin: *");

        $this->load->helper('url');

        $jobId = $this->input->post('jobid');
        $workerId = $this->input->post('workerid');
        $submitDate = $this->input->post('date');
        $storageId = $this->input->post('storeselect');
        $status = $this->input->post('tstatus'); // 1- submit cutter Job
        $typeid = $this->input->post('type'); // 1- submit cutter Job

        $jobData = array() ;

        if($status == 1 ) { //cutter Submit
            $jobData = array(
                "cut_compl_date"=>$submitDate,
                "storageid"=>$storageId,
                "status"=>2,
                "cut_compl_user"=>"shree"
            );
        }
        
        if($status == 3 ) { //Steacher Submit
            $jobData = array(
                "sur_compl_date"=>$submitDate,
                "storageid"=>$storageId,
                "status"=>4,
                "sur_compl_user"=>"shree"
            );
        }

		$updateJob = $this->JobMasterModel->update_job($jobId,$jobData);
        if(!empty($updateJob)){

            $transactionId = 0;
            $transactionYearId = 0;
            $commission = 0;

            $typeData = $this->TypeModel->get_type_by_id($typeid);
            if($status == 1) {
                $commission = $typeData['cutter_comm'];
            } else if($status == 3) {
                $commission = $typeData['surgeon_comm'];
            }

            $daid = 8;//worker commision
            $caid = 7;//Employee Account
            $drefid = $jobId;//Job Id
            $crefid = $workerId;//Employee Id
            $p_amt = $commission;
            $yearId = $this->YearMasterModel->getYearId($submitDate);
            
            $p_disc= ($status == 2) ? 'Cutter Commision' : 'Steacher Commission';
            $transactionId = $this->TransactionModel->createTransaction($submitDate , $daid, $caid , $drefid, $crefid, $p_amt , $p_disc, $this->session->has_userdata('username') );

            $transactionYearId = $yearId;

            $workerCommData = array(
                "w_id"=>$workerId,
                "jobid"=>$jobId,
                "tranid"=>$transactionId,
                "tran_yearid"=>$transactionYearId,
                "amt"=>$commission,
                "userid"=>$this->session->has_userdata('username')
            );
            
            $this->WorkerCommisionModel->insert($workerCommData);
            echo "Job Submitted Successfully";
        } else {
            echo "Failed To Submit Job";
        }

        


    }//end of submit job
	
	public function slipDesign($typeId = 0 ) {
        if(!$this->session->has_userdata('username')){
            redirect('login');
         } 
         header("Access-Control-Allow-Origin: *");
         $this->template->set('title', 'Slip Design');

         $this->load->helper('url');
         if ($this->input->method() === 'post') {

            $typeId = $this->input->post('typeid');
            $mId = $this->input->post('m_id');
            $x = $this->input->post('x');
            $y = $this->input->post('y');
           
            for($i=0; $i < count($mId) ; $i++)
            {
                $mData = array("x"=>$this->convert_pixels_to_mm($x[$i]),"y"=>$this->convert_pixels_to_mm($y[$i]));
                $this->MeasurementModel->update_measurement($mId[$i],$mData);
                $data['updateFlg'] = 1;

            }
            
         }    
         
         $data['mdata'] = $this->MeasurementModel->getMeasurementByTypeId($typeId);
         $data['typeId'] = $typeId;
        $this->template->load('default_layout', 'contents' , 'slipDesign', $data);
    }
    public function slipDesignDb(){
        if(!$this->session->has_userdata('username')){
            redirect('login');
         } 
         header("Access-Control-Allow-Origin: *");

        $this->load->helper('url');
        $typeId = $this->input->post('typeid');
        $mId = $this->input->post('m_id');
        $x = $this->input->post('x');
        $y = $this->input->post('y');

    }
	   public function slipDesignPreview($typeId = 0)
    {

        $this->load->helper('url');
        $typeId = ($this->uri->segment(3)) ? $this->uri->segment(3) : $typeId;
        $jobId = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $typeName = ($this->uri->segment(5)) ? $this->uri->segment(5) : '';
        $dDate = ($this->uri->segment(6)) ? $this->uri->segment(6) : '';

        $mData = $this->MeasurementModel->getMeasurementByTypeId($typeId);
        $finalFashions = null;
        $jobAdditionalDetails = '';


        if (!empty($jobId)) {
            //$jobData = $this->JobMasterModel->get_job_by_id($jobId);
            $jobData = $this->JobMasterModel->get_jobMaster(array("job_m.jobid"=>$jobId));
            $jobData = $jobData[0];
            //print_r($jobData); die;
            // print_r($jobData); die;


            $jobMeasurementData = json_decode($jobData['job_details'], true);
            if(!empty($jobMeasurementData)) {
                for ($i = 0; $i < count($jobMeasurementData); $i++) {
                    $jobMeasurementData[$i]['name'] = preg_replace("/[0-9-]/", "", $jobMeasurementData[$i]['name']);

                    for ($j = 0; $j < count($mData); $j++) {
                        if ($mData[$j]['m_name'] == $jobMeasurementData[$i]['name']) {
                            $mData[$j]['m_name'] = $jobMeasurementData[$i]['value'];
                        }
                    }
                }
            }
            $jobFashionDetails = null;
            $jobAdditionalDetails = $jobData['additional_details'];

            foreach (json_decode($jobData['fashion_dtl'], true) as $row) {
                $temp = explode("_", $row['name']);
                $fashionId = $temp[0];
                $subFashionId = $temp[1];

                $sql = 'SELECT f.f_name,s.sub_fashion FROM `sub_f_m` s INNER JOIN fashion_m f on f.f_id = s.f_id WHERE f.f_id = ' . $fashionId . ' and  sub_f_id = ' . $subFashionId;
                $result = $this->db->query($sql);
                $jobFashionDetails[] = $result->row_array();
            }

            //make Fashion Array

            $tempusedName = array();
            for ($i = 0; $i < count($jobFashionDetails); $i++) {
                $fashionName = $jobFashionDetails[$i]['f_name'];
                if (!in_array($fashionName, $tempusedName)) {
                    $subFashions = '';
                    for ($j = 0; $j < count($jobFashionDetails); $j++) {
                        if ($jobFashionDetails[$j]['f_name'] == $fashionName) {
                            $subFashions = $subFashions . ' ' . $jobFashionDetails[$j]['sub_fashion'] . ',';
                        }
                    }
                    $finalFashions[] = array("fashion" => $fashionName, "subFashions" => $subFashions);
                    $tempusedName[] = $fashionName;
                }
            }
            //print_r($finalFashions); die;

        }


        if (!empty($jobData)) {
            $data = array("type" => urldecode($typeName), "jobid" => $jobData['jobid'], "cutterid" => $jobData['cutter_id'], "sid" => $jobData['sur_id'], "billno" => $jobData['billno'], "custid" => $jobData['cust_id'], "deliveryData" => $jobData['delivery_date'] ,"custname"=>$jobData['name'],"jobqty"=>$jobData['total_qty']);
            $jobId = $jobData['jobid'];
        } else {
            $data = array("type" => 'TEST', "jobid" => 1, "cutterid" => '', "sid" => '', "billno" => '', "custid" => '', "deliveryData" => '');
        }

        $fashionDetails = "";

        // Custom page size in millimeters (mm)
        $width = 148.5; // Width: 210mm (A4 size)
        $height = 210; // Height: 148mm (A5 size)

        $pdf = new PDF_Code39('L', 'mm', array($width, $height));
        //$pdf->AddFont('lohitdevanagari', true);
        //$pdf->AddPage('P',array($pageWidth,$pageHeight));

        $pdf->SetLeftMargin(5);
        $pdf->SetTopMargin(10);
        $pdf->SetRightMargin(5);
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->AddPage();

        //Header
        // Title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 8, 'BK Tailors', 0, 1, 'C'); // Centered title in first row
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'Job Slip ['.$data['custname'].']', 0, 1, 'C'); // Centered title in first row


        /*$barcode = new Barcode39(1);
        //$barcode->draw($this, $x, $y, $w, $h);
        $barcode->draw($this, 10, 10, 10, 5);
        */
        //Code128(float x, float y, string code, float w, float h)
        $pdf->Code39(10, 10, '0000000' . $jobId);



        // Date
        $pdf->SetY(25);
        $cellHeight = 7;
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(40, $cellHeight, "Type", 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, "QTY", 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, "Job Id", 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, "Cutter Id", 1, 0, 'C');
        $pdf->Cell(25, $cellHeight, "Steacher Id", 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, "Bill No", 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, "Cust Id", 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, "Delivery", 1, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(40, $cellHeight, $data['type'], 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, $data['jobqty'], 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, $data['jobid'], 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, $data['cutterid'], 1, 0, 'C');
        $pdf->Cell(25, $cellHeight, $data['sid'], 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, $data['billno'], 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, $data['custid'], 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, $data['deliveryData'], 1, 0, 'C');



        $pdf->SetY(45);
        $headerHeight = 40;
        // Line break
        //$pdf->Ln(40); // Move down a bit
        $pdf->Cell(0, 0, '', 'T'); // Draw horizontal line
        $pdf->Ln(5); // Move down a bit more after the line

        foreach ($mData as $row) {
            // Set text position
            $pdf->SetXY($row['x'] / 200 * 72, $headerHeight + $row['y'] / 200 * 72);

            // Add text

            $pdf->Cell(25, 5, str_replace('-', '', ltrim($row['m_name'], '0'))); // 3 Mar 23

        }

        //Footer
        $pdf->SetY(-45);
        $pdf->Cell(0, $cellHeight, 'Fashion Details', 1, 0, 'C');
        $pdf->Ln();
        if (!empty($finalFashions)) {
            foreach ($finalFashions as $row) {
                $pdf->Cell(0, 6, $row['fashion'] . ' : ' . $row['subFashions'], 1, 0, 'L');
                $pdf->Ln();
            }
        }
        //$pdf->AddFont('Mangal','', 'mangal.mtx.php', true);
        //$pdf->AddFont('DejaVuSans Condensed', '', 'DejaVuSansCondensed.ttf');
        //$pdf->SetFont('lucon', '', 12);
        //$pdf->SetFont('Mangal', '', 12);

        // Add a Unicode font (Arial Unicode MS in this example)

        //$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
        //$pdf->SetFont('DejaVu','',14);
        // Set the font
        //$jobAdditionalDetails = "";
        $pdf->Cell(0, 6, 'Additional Details : ' . $jobAdditionalDetails, 1, 0, 'L');

        // Page number
        $pdf->SetY(-10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 0, 'C');


        $pdf->Output();
    }
	   public function commisonDetailsReport() // 16 May 2024
    {

        if (!$this->session->has_userdata('username')) {
            redirect('login');
        }
        header("Access-Control-Allow-Origin: *");
        
        $this->load->helper('url');
        $workerId = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $commDetails = $this->WorkerCommisionModel->get_commissionDetails(array("worker_comm_dtl.w_id"=>$workerId));
        $data['commdtl'] = $commDetails;
        $this->template->set('title', 'Commison Report');
        $this->template->load('default_layout', 'contents', 'commissionDetailReport', $data);
    }
	   /*
	public function slipDesignPreview($typeId = 0 ){
        
        $this->load->helper('url');
        $typeId = ($this->uri->segment(3)) ? $this->uri->segment(3) : $typeId;
        $jobId = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $typeName = ($this->uri->segment(5)) ? $this->uri->segment(5) : '';
        $dDate = ($this->uri->segment(6)) ? $this->uri->segment(6) : '';

        $mData = $this->MeasurementModel->getMeasurementByTypeId($typeId);
        $finalFashions = null;
        $jobAdditionalDetails = '';
        

        if(!empty($jobId)){
            $jobData = $this->JobMasterModel->get_job_by_id($jobId);
           // print_r($jobData); die;
        
            
        $jobMeasurementData = json_decode($jobData['job_details'],true);
        for($i =0 ; $i < count($jobMeasurementData) ; $i++) {
            $jobMeasurementData[$i]['name'] = preg_replace("/[0-9-]/", "", $jobMeasurementData[$i]['name']);
            
            for( $j =0 ; $j < count($mData) ; $j++) {
                if($mData[$j]['m_name'] == $jobMeasurementData[$i]['name']) {
                    $mData[$j]['m_name'] = $jobMeasurementData[$i]['value'];
                }
            }

        }
        
        $jobFashionDetails = null;
        $jobAdditionalDetails = $jobData['additional_details'];

        foreach(json_decode($jobData['fashion_dtl'],true) as $row) {
            $temp = explode("_",$row['name']);
            $fashionId = $temp[0];
            $subFashionId = $temp[1];
            
            $sql = 'SELECT f.f_name,s.sub_fashion FROM `sub_f_m` s INNER JOIN fashion_m f on f.f_id = s.f_id WHERE f.f_id = '.$fashionId.' and  sub_f_id = '.$subFashionId;
            $result = $this->db->query($sql);
            $jobFashionDetails[] = $result->row_array();

        }
        
        //make Fashion Array
        
        $tempusedName = array();
        for($i=0 ; $i < count($jobFashionDetails); $i++ ){
            $fashionName = $jobFashionDetails[$i]['f_name'];
            if(!in_array($fashionName, $tempusedName)) {
                $subFashions = '';
                for($j=0 ; $j < count($jobFashionDetails); $j++ ){
                    if($jobFashionDetails[$j]['f_name'] == $fashionName) {
                        $subFashions = $subFashions.' '.$jobFashionDetails[$j]['sub_fashion'].',';
                        
                    }
                }
                $finalFashions[] = array("fashion"=>$fashionName,"subFashions"=>$subFashions);
                $tempusedName[] = $fashionName; 
            }   
            

        }
        //print_r($finalFashions); die;
            
        } 
        

        if(!empty($jobData)){
            $data = array("type"=>urldecode($typeName),"jobid"=>$jobData['jobid'],"cutterid"=>$jobData['cutter_id'],"sid"=>$jobData['sur_id'],"billno"=>$jobData['billno'],"custid"=>$jobData['cust_id'],"deliveryData"=>$jobData['delivery_date']);
            $jobId = $jobData['jobid'];
        } else {
            $data = array("type"=>'TEST',"jobid"=>1,"cutterid"=>'',"sid"=>'',"billno"=>'',"custid"=>'',"deliveryData"=>'');
        }
        
        $fashionDetails = "";

        // Custom page size in millimeters (mm)
        $width = 148.5; // Width: 210mm (A4 size)
        $height = 210; // Height: 148mm (A5 size)

        $pdf = new PDF_Code39('L','mm', array($width, $height));
        //$pdf->AddPage('P',array($pageWidth,$pageHeight));

        $pdf->SetLeftMargin(5);
        $pdf->SetTopMargin(10);
        $pdf->SetRightMargin(5);
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->AddPage();

        //Header
        // Title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 8, 'BK Tailors', 0, 1, 'C'); // Centered title in first row
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'Job Slip', 0, 1, 'C'); // Centered title in first row

        
        /*$barcode = new Barcode39(1);
        //$barcode->draw($this, $x, $y, $w, $h);
        $barcode->draw($this, 10, 10, 10, 5);
        * /
        //Code128(float x, float y, string code, float w, float h)
        $pdf->Code39(10, 10, '0000000'.$jobId);


        
        // Date
        $pdf->SetY(25);
        $cellHeight = 7;
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(30, $cellHeight, "Type", 1, 0, 'C'); 
        $pdf->Cell(20, $cellHeight, "Job Id", 1, 0, 'C'); 
        $pdf->Cell(30, $cellHeight, "Cutter Id", 1, 0, 'C'); 
        $pdf->Cell(25, $cellHeight, "Steacher Id", 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, "Bill No", 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, "Cust Id", 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, "Delivery", 1, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(30, $cellHeight, $data['type'], 1, 0, 'C'); 
        $pdf->Cell(20, $cellHeight, $data['jobid'], 1, 0, 'C'); 
        $pdf->Cell(30, $cellHeight, $data['cutterid'], 1, 0, 'C'); 
        $pdf->Cell(25, $cellHeight, $data['sid'], 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, $data['billno'], 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, $data['custid'], 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, $data['deliveryData'], 1, 0, 'C');
        
        

        $pdf->SetY(45);
        $headerHeight = 40;
        // Line break
        //$pdf->Ln(40); // Move down a bit
        $pdf->Cell(0, 0, '', 'T'); // Draw horizontal line
        $pdf->Ln(5); // Move down a bit more after the line

        foreach($mData as $row){
            // Set text position
        $pdf->SetXY($row['x']/200*72, $headerHeight+$row['y']/200*72);

        // Add text
        //$pdf->Cell(25, 5, $row['m_name']);
			$pdf->Cell(25, 5, str_replace('-','',ltrim($row['m_name'], '0')));// 3 Mar 23
        
        }

        //Footer
        $pdf->SetY(-45);
        $pdf->Cell(0, $cellHeight,'Fashion Details', 1, 0, 'C');
        $pdf->Ln();
        if(!empty($finalFashions)){
            foreach($finalFashions as $row){
                $pdf->Cell(0, 6,$row['fashion'].' : '.$row['subFashions'], 1, 0, 'L');
                $pdf->Ln();
            }
            
        }
        $pdf->Cell(0, 6,'Additional Details : '.$jobAdditionalDetails, 1, 0, 'L');

        // Page number
        $pdf->SetY(-10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 0, 'C');
        

        $pdf->Output();
    }*/
	   
	public function deliveryJob(){

        if(!$this->session->has_userdata('username')){
            redirect('login');
            } 
            header("Access-Control-Allow-Origin: *");
            $this->load->helper('url');
            $config = array();
            $config["base_url"] = base_url() . "Job/deliveryJob";
            $config["total_rows"] = $this->CustomerModel->record_count();
            $config["per_page"] = 20;
            $config["uri_segment"] = 3;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            $data["jobData"] = $this->JobMasterModel->get_jobMaster(array(),array("job_m.status=2" , "job_m.status=3" , "job_m.status=4"),$config["per_page"], $page);
            $this->template->set('title', 'Assign Job');
            
            $this->template->load('default_layout', 'contents' , 'jobDelivery', $data);
        
    
    }
	/*public function submitJob() {

        if(!$this->session->has_userdata('username')){
            redirect('login');
         } 
         header("Access-Control-Allow-Origin: *");

        $this->load->helper('url');

        $jobId = $this->input->post('jobid');
        $status = $this->input->post('tstatus'); // 1- submit cutter Job
        
        if($status != 4) {

        
        $workerId = $this->input->post('workerid');
        $submitDate = $this->input->post('date');
        $storageId = $this->input->post('storeselect');
        $typeid = $this->input->post('type'); // 1- submit cutter Job

        }
        $jobData = array() ;

        if($status == 1 ) { //cutter Submit
            $jobData = array(
                "cut_compl_date"=>$submitDate,
                "storageid"=>$storageId,
                "status"=>2,
                "cut_compl_user"=>"shree"
            );
        }
        
        if($status == 3 ) { //Steacher Submit
            $jobData = array(
                "sur_compl_date"=>$submitDate,
                "storageid"=>$storageId,
                "status"=>4,
                "sur_compl_user"=>"shree"
            );
        }

        if($status == 4 ) { //4 - completed Job
            $jobData = array(
                "delivery_date"=>date("Y-m-d"),
                "status"=>5,
                "sur_compl_user"=>"shree"
            );
        }
        
        //print_r($jobId); die; 
		$jobUpdateStatus = $this->JobMasterModel->update_job($jobId,$jobData);   
        if(!empty($jobUpdateStatus)){

            if($status != 4 ) {

            

            $transactionId = 0;
            $transactionYearId = 0;
            $commission = 0;

            $typeData = $this->TypeModel->get_type_by_id($typeid);
            if($status == 1) {
                $commission = $typeData['cutter_comm'];
            } else if($status == 3) {
                $commission = $typeData['surgeon_comm'];
            }

            $daid = 8;//worker commision
            $caid = 7;//Employee Account
            $drefid = 0;//$jobId;//Job Id
            $crefid = $workerId;//Employee Id
            $p_amt = $commission;
            $yearId = $this->YearMasterModel->getYearId($submitDate);
            
            $p_disc= ($status == 2) ? 'Steacher Commission' : 'Cutter Commision';
            $transactionId = $this->TransactionModel->createTransaction($submitDate , $daid, $caid , $drefid, $crefid, $p_amt , $p_disc, $this->session->has_userdata('username') );

            $transactionYearId = $yearId;

            $workerCommData = array(
                "w_id"=>$workerId,
                "jobid"=>$jobId,
                "tranid"=>$transactionId,
                "tran_yearid"=>$transactionYearId,
                "amt"=>$commission,
                "userid"=>$this->session->has_userdata('username')
            );
            
            $this->WorkerCommisionModel->insert($workerCommData);
            echo "Job Submitted Successfully";
        } else  {
            echo "Job Delivered To Customer Successfully";
        }
        } else {
            echo "Failed To Submit Job";
        }
    }*/

    public function submitJob() {

        if(!$this->session->has_userdata('username')){
            redirect('login');
            } 
            header("Access-Control-Allow-Origin: *");
    
        $this->load->helper('url');
    
        $jobId = $this->input->post('jobid');
        $trackingid = $this->input->post('trackingid');
        $submitqty = $this->input->post('tsubmitqty');
        //$maxQty = $this->input->post('tjobmaxqty');
        $storageId = $this->input->post('storeselect');
        $submitDate = $this->input->post('date');
        $jobType = $this->input->post('jobtype'); // 0 - cutter , 1 - steacher
        $workerId = $this->input->post('workerid'); // 0 - cutter , 1 - steacher
    	$jobTrackingDetail = $this->JobTrackingModel->get_job_tracking_by_id($trackingid);
		$assQty =  $jobTrackingDetail['ass_qty'];
		$submitQtyJT = $jobTrackingDetail['submit_qty'];
		$submitqty =  $submitqty + $submitQtyJT;
    
            $totalJobQty = 0;
    
            $status = 0 ; //0 - assigned , 1 - partialy completed , 2 - completed
    
            $completedQty = 0 ;
            
            if( $submitqty > $assQty) {
                echo "Invalid QTY";
                return 0;
            } else if($assQty == $submitqty) {
                $status = 2 ;
            } else {
                $status = 1 ;
            }
    
            $jobTrackingData = array(
                "submit_qty" => $submitqty,
                "storageid" => $storageId,
                "status" => $status,
                "update_date" => $submitDate
            ) ;
            $jt_update = $this->JobTrackingModel->update_jobTracking($trackingid,$jobTrackingData);
		   if(!empty($jt_update)) {
                $jobDetail = $this->JobMasterModel->get_job_by_id($jobId);
                $typeData = $this->TypeModel->get_type_by_id($jobDetail['typeid']);
                $commision = 0;
                $transactionDiscription = '';
                
                $totalJobQty = $jobDetail['total_qty'];
                $jobStatus = 1 ; //0 - New Job , 1 - In process , 2 - partialy completed , 3 - completed , 4 - partialy delivered , 5 - Delivered
    
                $jobData = array();
    
                if($jobType == 0 ) {
                    $completedQty = $jobDetail['cutter_complete_qty'];
                    $completedQty = $completedQty + $submitqty;
                    
                    $jobData['cutter_complete_qty'] = $completedQty;
    
                    $commision = $typeData['cutter_comm'] * $submitqty;
                    $transactionDiscription = 'Cutter Commision';
                    if($totalJobQty == $completedQty) {
                        $jobStatus = 1;
                    }
                } else {
                    $completedQty = $jobDetail['steacher_complete_qty'];
                    $completedQty = $completedQty + $submitqty; 
    
                    $jobData['steacher_complete_qty'] = $completedQty;
                    $jobData['complete_qty'] = $jobDetail['complete_qty'] + $submitqty ; 
                    $commision = $typeData['surgeon_comm'] * $submitqty;
                    $transactionDiscription = 'Steacher Commision';
    
                    if($totalJobQty == $completedQty) {
                        $jobStatus = 3;
                        
                    } else {
                        $jobStatus = 2;
                    }
                }
    
                $jobData['status'] = $jobStatus;

                $jm_update = $this->JobMasterModel->update_job($jobId,$jobData);
                if(!empty($jt_update)){
    
                    $transactionId = 0;
                    $transactionYearId = 0;
                    $daid = 8;//worker commision
                    $caid = 7;//Employee Account
                    $drefid = 0 ;$jobId;//Job Id
                    $crefid = $workerId;//Employee Id
                    $p_amt = $commision;
                    $yearId = $this->YearMasterModel->getYearId($submitDate);
                    
                    //$p_disc= ($status == 2) ? 'Steacher Commission' : 'Cutter Commision' ;
                    $transactionId = $this->TransactionModel->createTransaction($submitDate , $daid, $caid , $drefid, $crefid, $p_amt , $transactionDiscription, $this->session->has_userdata('username') );
        
                    $transactionYearId = $yearId;
        
                    $workerCommData = array(
                        "w_id"=>$workerId,
                        "jobid"=>$jobId,
                        "job_tracking_id"=>$trackingid,
                        "tranid"=>$transactionId,
                        "tran_yearid"=>$transactionYearId,
                        "amt"=>$commision,
                        "userid"=>$this->session->has_userdata('username')
                    );
                    
                    $this->WorkerCommisionModel->insert($workerCommData);
                    echo "Job Submitted Successfully";
                
            } else {
                echo "Error In Submit Job";
            }    
        }
    		
          
    }
    public function deliveryJobDb(){
        if(!$this->session->has_userdata('username')){
            redirect('login');
        } 
        header("Access-Control-Allow-Origin: *");
        $this->load->helper('url');
    
        $jobId = $this->input->post('jobid');
        $deliverQty = $this->input->post('tqty');
    
        if(!empty($deliverQty)) {
        $jobDetail = $this->JobMasterModel->get_job_by_id($jobId);
        $completedQty = $jobDetail['complete_qty'];
        $existingDeliveredQty = $jobDetail['deliver_qty'];
        $jobTotalQty = $jobDetail['total_qty'];
        $jobStatus = 4; //Partially Delivered
        if(($existingDeliveredQty+$deliverQty) > $completedQty ) {
            echo "Invalid Qty.";
        } else {
    
            if(($existingDeliveredQty+$deliverQty) == $jobTotalQty ) {
                $jobStatus = 5; //Partially Delivered
            }
            $jobData = array(
                "deliver_qty"=>$existingDeliveredQty+$deliverQty,
                "status"=>$jobStatus,
            );
            $this->JobMasterModel->update_job($jobId,$jobData);
    
            $jobDeliveryLogData = array(
                "job_id"=>$jobId,
                "data_"=>json_encode(array("deliver_qty"=>$deliverQty,"status"=>$jobStatus
            )));
    
            $this->JobDeliveryLogModel->insert($jobDeliveryLogData);
            echo "Job Delivered Successfully";
    
        }
        } else {
            echo "Quntity Should not be empty";
        }
    
    }
    
    public function getJobTracking($jobId) {
    
        if(!$this->session->has_userdata('username')){
            redirect('login');
         } 
         header("Access-Control-Allow-Origin: *");
    
        $this->load->helper('url');
        $data = array(); 
        $data["jobData"] = $this->JobTrackingModel->get_jobTracking(array("job_id"=>$jobId));
        $this->template->set('title', 'Job Tracking');
        $this->template->load('default_layout', 'contents' , 'jobTracking', $data);
        
    }
	   public function convert_pixels_to_mm($pixels, $dpi = 96) {
        // Convert pixels to millimeters
        //$mm = $pixels / $dpi * (1 / 25.4);
        return $pixels;//$mm;
    }
    public function convert_mm_to_pixels($mm, $dpi=96) {
        // Convert millimeters to pixels
        $pixels = $mm * $dpi * (1 / 25.4);
        return $pixels;
    }
	   
	   //18-03-2024
	   public function commisonReport(){

        if(!$this->session->has_userdata('username')){
           redirect('login');
        } 
        header("Access-Control-Allow-Origin: *");

        
        $sql = "SELECT * FROM worker_m w LEFT JOIN os_status_m s on w.w_id = s.id and s.aid = 7";
        $query = $this->db->query($sql);

        $result = $query->result_array();
        
        
        $data["workerData"] = $result;
        

        $this->template->set('title', 'Commison Report');
        $this->template->load('default_layout', 'contents' , 'commisonReport', $data);
    }

    public function customerMeasurement(){
        if(!$this->session->has_userdata('username')){
            redirect('login');
         } 
         header("Access-Control-Allow-Origin: *");
         $data = array();
         
        if ($this->input->post()) {
        
            $mobileno = $this->input->post('mobileno'); 
            $custId = $this->input->post('custselect');
            
            
            if(!empty($mobileno)) {
                $cid=$this->CustomerModel->getCustomerIdByMobileNo($mobileno);
                $custId = $cid;
                 
            }
            
            if(!empty($custId) && $custId > 0) {
                $measurements = $this->JobMasterModel->getCustomerMeasurements($custId);
            }
            
          
            if(!empty($measurements)) {
                $data['custId'] = $custId; 
                $data['measurement'] = $measurements; 
            } else {
                $this->session->set_flashdata('measurementMsg', 'No Data Found.');
            }
            
            
            
            //redirect(base_url('Job/customerMeasurement'));
        }
    
        $data["custData"] = $this->CustomerModel->get_cust();
        $this->template->set('title', 'Customer Measurement Search');
        $this->template->load('default_layout', 'contents' , 'customerMeasurement', $data);
    }
      
   } 
?>