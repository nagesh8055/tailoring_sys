<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-8 col-8">
        <div class="card shadow mb-4">
            
            <!-- Card Body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-3 mt-4">
                        <a href="<?php echo base_url().'Customer/create';?>" class="btn btn-success" style="width:100%;" >
                            <h3 class="fas fa-user"></h3><br/> <?php echo $this->lang->line('dashboard_new_customer'); ?>
                        </a>
                    </div>
                    <div class="col-3 mt-4">
                        <a href="<?php echo base_url().'Worker/create';?>" class="btn btn-success" style="width:100%;" >
                            <h3 class="fas fa-user-tie"></h3><br/> <?php echo $this->lang->line('dashboard_new_worker'); ?>
                        </a>
                    </div>
                    <div class="col-3 mt-4">
                        <a href="<?php echo base_url().'Sales/salesCreate';?>" class="btn btn-success" style="width:100%;" >
                            <h3 class="fas fa-receipt"></h3><br/> <?php echo $this->lang->line('dashboard_new_bill'); ?>
                        </a>
                    </div>
                    <div class="col-3 mt-4">
                        <a href="<?php echo base_url().'Payment/payment/1';?>" class="btn btn-success" style="width:100%;" >
                            <h3 class="fas fa-wallet"></h3><br/> <?php echo $this->lang->line('dashboard_cust_payment'); ?>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 mt-4">
                        <a href="<?php echo base_url().'Payment/payment/2';?>" class="btn btn-success" style="width:100%;" >
                            <h3 class="fas fa-wallet"></h3><br/> <?php echo $this->lang->line('dashboard_worker_payment'); ?>
                        </a>
                    </div>
                    
                    <div class="col-3 mt-4">
                        <a href="<?php echo base_url().'Job/assignJob';?>" class="btn btn-success" style="width:100%;" >
                            <h3 class="fas fa-plus"></h3><br/> <?php echo $this->lang->line('dashboard_assign_job'); ?>
                        </a>
                    </div>
                    <div class="col-3 mt-4">
                        <a href="<?php echo base_url().'Job/completeJob';?>" class="btn btn-success" style="width:100%;" >
                            <h3 class="fas fa-plus"></h3><br/> <?php echo $this->lang->line('dashboard_submit_job'); ?>
                        </a>
                    </div>
                    <div class="col-3 mt-4">
                        <a href="<?php echo base_url().'Job/deliveryJob';?>" class="btn btn-success" style="width:100%;" >
                            <h3 class="fas fa-plus"></h3><br/> <?php echo $this->lang->line('dashboard_delivery_job'); ?>
                        </a>
                    </div>
                    <div class="col-3 mt-4">
                        <a href="<?php echo base_url().'Job/jobReport';?>" class="btn btn-danger" style="width:100%;" >
                            <h3 class="fas fa-search"></h3><br/> <?php echo $this->lang->line('dashboard_search_job'); ?>
                        </a>
                    </div>
                    <div class="col-3 mt-4">
                        <a href="<?php echo base_url().'Job/customerMeasurement';?>" class="btn btn-warning" style="width:100%;" >
                            <h3 class="fas fa-search"></h3><br/> Measurement
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-4">
        <div class="card shadow mb-4">
            <div class="card-header text-center">This Month Birthday's </div>
            <div class="card-body">
                <?php foreach($birthdays as $row) { ?>
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                        <span class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $row['day'];?>  </span>  <?php echo $row['name'];?> 
                        <a href="javascript:sendWhatsAppMessage('<?php echo $row['mobile1']; ?>')"  title="send Whatsapp Message"><i class="fa fa-comment fa-2x text-green-300"></i></a>    
                    </div>
                        
                        
                        <hr/>
                    </div>
                    
                </div>
                <?php } ?>        
            </div>
        </div>
    </div>        

    
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total JOBS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $counts[0]['totalUrls'];?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Cutter Pendings</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $counts[0]['totalVisits'];?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Steacher Pending
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total OS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
<!-- /.container-fluid -->

<script>
    function sendWhatsAppMessage(number) {
        // WhatsApp message content
        var message = "We wish your birthday to be filled with love, joy, and happiness. We hope that you have the strength to accomplish all that you aspire in your days ahead. Happy birthday! \n*BK TAILORS,Pandharpur*\n";
        
        // WhatsApp number (replace with the actual number)
        var phoneNumber = number;//"1234567890";
        
        // Generate WhatsApp URL
        var whatsappURL = "https://wa.me/" + phoneNumber + "?text=" + encodeURIComponent(message);
        
        // Open WhatsApp with pre-filled message
        window.open(whatsappURL);
    }
</script>