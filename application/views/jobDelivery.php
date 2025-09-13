
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">JOB DELIVERY</h6>
    </div>
    <div class="card-body">
    <div id = "deliveryjobsucess"></div>

    <!-- Large modal -->
<!--<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> Create Worker</button>-->


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>JOB ID</th>
                        <th>Bill No</th>
                        <th>Type</th>
                        <th>Customer Name</th>
                        <th>TOTAL QTY</th>
                        <th>Ready</th>
                        <th>Delivered</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <!--<tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </tfoot>-->
                <tbody>
                    <?php
                        $count = 1;
                        
                        //echo "Ok"; die;
                        foreach($jobData as $row) {
                            
                        $jobStatus = '' ;
                        $assignedDate = '';
                        $btnClass = 'btn-success';
                        if($row['status'] == 4) {
                            $jobStatus = 'Completed Job';
                        }
                        
                    ?>
                    <tr>
                        <td><?php echo $row['jobid'];?></td>
                        <td><?php echo $row['billno'];?></td>
                        <td><?php echo $row['type_name'];?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['total_qty'];?></td>
                        <td><?php echo $row['complete_qty'];?></td>
                        <td><?php echo $row['deliver_qty'];?></td>

                        
                        <td><?php echo $jobStatus;?></td>
                        <td><?php echo $row['storage'];?></td>
                        <td>
                            <form class="avighna-form" id="submit-job-form-<?php echo $row['jobid']?>"  data-successresponse = "deliveryjobsucess" data-reset = "yes" data-action = "<?php echo base_url("Job/deliveryJobDb");?>" enctype="multipart/form-data">
                                <input type="text" name="tqty" value="" placeholder="Enter Delivery QTY"/>
                                <input type="hidden" name="jobid" value="<?php echo $row['jobid'];?>" >
                                <input type="hidden" name="tstatus" value="<?php echo $row['status'];?>" >
                                <button type="submit" class="btn <?php echo $btnClass;?> "  data-jobid = "<?php echo $row['jobid'];?>"  >Deliver</button>
                                <button type="button" onclick="sendWhatsAppMessage('<?php echo $row['mobile1']; ?>')" class="btn btn-warning" target="_blank">Send Notification</a>
                            </td>
                            </form>
                            <script>
                                function sendWhatsAppMessage(number) {
                                    // WhatsApp message content
                                    var message = "Your Job Is Completed, please visit and receive your dress. \n*BK TAILORS,Pandharpur*\n\nThanks";
                                    
                                    // WhatsApp number (replace with the actual number)
                                    var phoneNumber = number;//"1234567890";
                                    
                                    // Generate WhatsApp URL
                                    var whatsappURL = "https://wa.me/" + phoneNumber + "?text=" + encodeURIComponent(message);
                                    
                                    // Open WhatsApp with pre-filled message
                                    window.open(whatsappURL);
                                }
                            </script>
                            
                        </tr>
                    <?php 
                    $count++ ;
                } ?>
                </tbody>
            </table>
            <?php echo $links; ?>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="assignJobModal" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Submit Job</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" class="avighna-form" id="assign-job-form"  data-successresponse = "assignjobsucess" data-reset = "yes" data-action = "<?php echo base_url("Job/submitJob");?>" enctype="multipart/form-data">
                <div id="assignjobsucess"></div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="recipient-name" class="col-form-label">Submit Date</label>
                        <input type="date" class="form-control" name="date">
                        <input type="hidden" class="form-control" name="jobid" id="tjobid">
                        <input type="hidden" class="form-control" name="workerid" id="tworkerid">
                        <input type="hidden" class="form-control" name="tstatus" id="tstatus">
                        <input type="hidden" class="form-control" name="type" id="type">
                        
                    </div>
                    <div class="form-group col-3">
                        <label for="recipient-name" class="col-form-label">Select Rack / Storage</label>
                        <select class="form-control" id="storeselect" name="storeselect">
                               <option>Select</option> 
                               <?php foreach($storageData as $row) {?>
                                    <option value="<?php echo $row['id'];?>"><?php echo $row['storage'];?></option>
                                <?php } ?>
                        </select>    
                        
                    </div>
                    
                    <div class="form-group col-3">
                        <label for="recipient-name" class="col-form-label">Worker</label>
                        <input type="text" class="form-control" name="tworker" id="tworker" disabled>
                    </div>

                    <div class="form-group col-2">
                    <label for="recipient-name" class="col-form-label">-</label>
                    <button id="assign-job-submit" type="submit" class="form-control btn btn-primary">Submit Job</button>
                    </div>
                    
                </div>
                
            
            
        </div>
        <div class="modal-footer">
        
        </form>
        <button type="button" class="btn btn-secondary">Cancel</button>

    </div>
    </div>
    
</div>
</div>

</div>
<!-- /.container-fluid -->