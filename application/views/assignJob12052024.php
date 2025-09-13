<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Assign Job</h6>
    </div>
    <div class="card-body">
    
    <form method="post" id="bill-filter" data-action = "<?php echo base_url("Sales/assignJob");?>" enctype="multipart/form-data">
        <div class="row">
        <div class="form-group col-4">
                    <label for="recipient-name" class="col-form-label">Select Customer</label>
                    <select class="form-control selectpicker"  data-live-search="true" data-live-search-style="startsWith" name="custselect" id="custselect">
                        <option>Select</option>
                        <?php foreach($custData as $row) { ?>
                            <option value="<?php echo $row['cid'];?>"><?php echo $row['name'];?></option>
                        <?php } ?>    
                    </select>
                </div><!--
            <div class="form-group col-3">
                <label for="recipient-name" class="col-form-label">Start Date</label>
                <input type="date" class="form-control" name="sdate" value="<?php if(!empty($sdate)) { echo $sdate; } ?>">
            </div>
            <div class="form-group col-3">
                <label for="recipient-name" class="col-form-label">End Date</label>
                <input type="date" class="form-control" name="edate" value = "<?php if(!empty($edate)) { echo $edate; } ?>">
            </div>-->
            <div class="form-group col-2">
            <label for="recipient-name" class="col-form-label">-</label>
                <button id="assign-job-submit" type="submit" class="form-control btn btn-primary">View Jobs</button>
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
                        <th>Type</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
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
                            
                    ?>
                    <tr>
                        <td><?php echo $row['jobid'];?></td>
                        <td><?php echo $row['billno'];?></td>
                        <td><?php echo $row['type_name'];?></td>
                        <td><?php echo $row['order_date'];?></td>
                        <td><?php echo $row['delivery_date'];?></td>

                        <td>
                        <?php if($row['status'] == 0 )  { ?>  
                        <button type="button" class="btn btn-success assign-job" data-jobstatus = "<?php echo $row['status'];?>" data-jobid = "<?php echo $row['jobid'];?>"  >Assign Cutter</button>
                            <?php } ?>

                            <?php if($row['status'] == 2 )  { ?>  
                        <button type="button" class="btn btn-warning assign-job" data-jobstatus = "<?php echo $row['status'];?>" data-jobid = "<?php echo $row['jobid'];?>"  >Assign Steacher</button>
                        
                            <?php } ?>
                            <a href="<?php echo base_url().'Job/slipDesignPreview/'.$row['type_id'].'/'.$row['jobid'].'/'.$row['type_name'].'/'.$row['delivery_date'];?>" class="btn btn-primary" target="_tab">Print Job Slip</a>    
                    </td>
                    </tr>
                    <?php 
                    $count++ ;
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="assignJobModal" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Assign Job</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" class="avighna-form" id="assign-job-form"  data-successresponse = "assignjobsucess" data-reset = "yes" data-action = "<?php echo base_url("Job/assignCutter");?>" enctype="multipart/form-data">
                <div id="assignjobsucess"></div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label">Date</label>
                        <input type="date" class="form-control" name="date">
                        <input type="hidden" class="form-control" name="jobid" id="tjobid">
                        <input type="hidden" class="form-control" name="tstatus" id="tstatus">
                        
                    </div>
                    <div class="form-group col-6">
                        <label for="recipient-name" class="col-form-label">Select Worker</label>
                        <select class="form-control" id="workerselect" name="worker">
                               <option>Select</option> 
                        </select>    
                        
                    </div>
                    <div class="form-group col-2">
                    <label for="recipient-name" class="col-form-label">-</label>
                    <button id="assign-job-submit" type="submit" class="form-control btn btn-primary">Assign</button>
                    
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