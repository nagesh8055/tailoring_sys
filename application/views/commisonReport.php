<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('menu_commission_report');?></h6>
    </div>
    <div class="card-body">
    

    <!-- Large modal -->
<!--<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> Create Worker</button>-->


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('form_field_srno');?></th>
                        <th><?php echo $this->lang->line('form_field_worker_name');?></th>
                        <th><?php echo $this->lang->line('form_field_worker_type');?></th>
                        <th><?php echo $this->lang->line('form_field_tot');?></th>
                        <th><?php echo $this->lang->line('form_field_action');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count = 1;
                        foreach($workerData as $row) {
                        $wtype = "";
                        if($row['w_type_id'] == 1) { $wtype = "Cutter" ; }
                        if($row['w_type_id'] == 2) { $wtype = "Steacher" ; }
                        if($row['w_type_id'] == 3) { $wtype = "Manager" ; }
                        if($row['w_type_id'] == 4) { $wtype = "Computer Operator" ; }
                    ?>
                    <tr>
                        <td><?php echo $count;?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $wtype;?></td>
                        <td class="text-primary text-center"><b><?php echo number_format(abs($row['camt']),2);?></b></td>
                        
                        <td><a href="<?php echo base_url().'Job/commisonDetailsReport/'.$row['w_id'];?>" class="btn btn-success " > <?php echo $this->lang->line('form_field_view_dtl');?></button></td>
                    </tr    >
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