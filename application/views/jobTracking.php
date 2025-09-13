
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('form_job_tracking'); ?></h6>
    </div>
    <div class="card-body">
    

    <!-- Large modal -->
<!--<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> Create Worker</button>-->


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('form_field_custid'); ?></th>
                        <th><?php echo $this->lang->line('form_field_jobid'); ?></th>
                        <th><?php echo $this->lang->line('form_field_type'); ?></th>
                        <th><?php echo $this->lang->line('form_field_qty'); ?></th>
                        <th><?php echo $this->lang->line('form_field_worker_prakar'); ?></th>
                        <th><?php echo $this->lang->line('form_field_assigned_date'); ?></th>
                        <th><?php echo $this->lang->line('form_field_status'); ?></th>
                        
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
                           
                            $jobType = $row['job_type'] == 0 ? 'Cutter' : 'Steacher' ;
                            $status = '';//
                            if($row['status'] == 0 ) { $status = 'Assigned'; }
                            if($row['status'] == 1 ) { $status = 'Partialy Completed'; }
                            if($row['status'] == 2 ) { $status = 'Completed'; }
                    ?>
                    <tr>
                        <td><?php echo $row['id'];?></td>
                        <td><?php echo $row['job_id'];?></td>
                        <td><?php echo $row['type_name'];?></td>
                        <td><?php echo $row['ass_qty'];?></td>
                        <td><?php echo $jobType;?></td>
                        <td><?php echo $row['create_date'];?></td>
                        <td><?php echo $status;?></td>
                        
                        
                        
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