
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Job Report</h6>
    </div>
    <div class="card-body">
    <form method="post" id="bill-filter" data-action = "<?php echo base_url("Job/jobReport");?>" enctype="multipart/form-data">
        <div class="row">
        <div class="form-group col-4">
                    <label for="recipient-name" class="col-form-label">Select Customer</label>
                    <select class="form-control selectpicker"  data-live-search="true" data-live-search-style="startsWith" name="custselect" id="custselect">
                        <option>Select</option>
                        <?php foreach($custData as $row) { ?>
                            <option value="<?php echo $row['cid'];?>"><?php echo $row['name'];?></option>
                        <?php } ?>    
                    </select>
                </div>
            <div class="form-group col-3">
                <label for="recipient-name" class="col-form-label">Job Id</label>
                <input type="text" class="form-control" name="jobid" value= "<?php  if(isset($jobId)) echo $jobId; ?>">
            </div>
            <div class="form-group col-3">
                <label for="recipient-name" class="col-form-label">Bill No</label>
                <input type="text" class="form-control" name="billno" value="<?php  if(isset($billNo)) echo $billNo; ?>">
            </div>
            <div class="form-group col-2">
            <label for="recipient-name" class="col-form-label">-</label>
                <button id="assign-job-submit" type="submit" class="form-control btn btn-primary">Search</button>
            </div>
        </div>
        <hr/>
    </form>

    <!-- Large modal -->
<!--<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> Create Worker</button>-->


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>JOB ID</th>
                        <th>Bill No</th>
                        <th>Cust Name</th>
                        <th>Type</th>
                        <th>Status</th>
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
                        foreach($jobData as $row) {
                        
                        $jobStatus = '' ;
                        $assignedDate = '';
                        $workerId = 0;
                        if ($row['status'] == 0 ) { 
                            $jobStatus = 'New Order';
                        } else if($row['status'] == 1 ) {
                            $jobStatus = 'Cutter Assigned';
                        } else if($row['status'] == 2 ) {
                            $jobStatus = 'Cutting Submited';
                        } else if($row['status'] == 3 ) {
                            $jobStatus = 'Steacher Assigned';
                        } else if($row['status'] == 4 ) {
                            $jobStatus = 'Job Complited';
                        }
                        else if($row['status'] == 5 ) { // 27-Feb-2024
                            $jobStatus = 'Job Delivered';
                        }

                        //create dynamic row for displayig status
                        //$tblRow = "<tr><td>".$jobStatus."</td></tr>";
                    ?>
                    <tr>
                        <td><?php echo $row['jobid'];?></td>
                        <td><?php echo $row['billno'];?></td>
                        <td><?php echo $row['custname'];?></td>
                        <td><?php echo $row['type_name'];?></td>
                        <td><?php echo $jobStatus;?></td>
                        
                        <td><button type="button" class="btn btn-success jobtracking"  data-jobstatus = "<?php echo $row['status'];?>" data-jobid = "<?php echo $row['jobid'];?>"  >Show Tracking</button></td>
                    </tr    >
                    <?php 
                    $count++ ;
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="jobtrackingmodal" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">JOB TRACKING</h5>
        </div>
        <div class="modal-body">
            <form method="post" class="avighna-form" id="assign-job-form"  data-successresponse = "assignjobsucess" data-reset = "yes" data-action = "<?php echo base_url("Job/submitJob");?>" enctype="multipart/form-data">
                <div id="assignjobsucess"></div>
                <div class="row">
                    <!--Tracking Table -->
                    <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <tbody>   
            <tr>
                <tr>
                        <th>JOB STATUS</th>
                        <th>CUTTING</th>
                        <th>STRACHING</th>
                        <th>READY</th>
                        <th>DELIVERED</th>
                        <th>D. DATE</th>
                    </tr>
                    <tr id="trackingrow">

                    </tr>
                
                </tbody>
            </table>
            </div>
                    <!--end of Tracking table-->

                    
                    
                    
                </div>
                
            
            
        </div>
        <div class="modal-footer">
        
        
        <button type="button" class="btn btn-secondary">Cancel</button>

    </div>
    </div>
    
</div>
</div>

</div>
<!-- /.container-fluid -->