+<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('menu_bill_report'); ?></h6>
    </div>
    <div class="card-body">
    
    <form method="post" id="bill-filter" data-action = "<?php echo base_url("Sales/salesReport");?>" enctype="multipart/form-data">
        <div class="row">
			<div class="form-group col-4">
                    <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_custselect'); ?></label>
                    <select class="form-control selectpicker"  data-live-search="true" data-live-search-style="startsWith" name="custselect" id="custselect">
                        <option>Select</option>
                        <?php foreach($custData as $row) { ?>
                            <option value="<?php echo $row['cid'];?>"><?php echo $row['name'];?></option>
                        <?php } ?>    
                    </select>
                </div>
            <div class="form-group col-3">
                <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_satrt_date'); ?></label>
                <input type="date" class="form-control" name="sdate" value="<?php if(!empty($sdate)) { echo $sdate; } ?>">
            </div>
            <div class="form-group col-3">
                <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_end_date'); ?></label>
                <input type="date" class="form-control" name="edate" value = "<?php if(!empty($edate)) { echo $edate; } ?>">
            </div>
            <div class="form-group col-2">
            <label for="recipient-name" class="col-form-label">-</label>
                <button id="assign-job-submit" type="submit" class="form-control btn btn-primary"><?php echo $this->lang->line('form_field_view_report'); ?></button>
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
                        <th><?php echo $this->lang->line('form_field_billno'); ?> </th>
                        <th><?php echo $this->lang->line('form_field_date'); ?></th>
                        <th><?php echo $this->lang->line('form_field_name'); ?></th>
                        <th><?php echo $this->lang->line('form_field_disc'); ?></th>
                        <th><?php echo $this->lang->line('form_field_billamt'); ?></th>
                        <th><?php echo $this->lang->line('form_field_user'); ?></th>
                        <th><?php echo $this->lang->line('form_field_action'); ?></th>
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
                        if(!empty($billData)) {
                        foreach($billData as $row) {
                       // print_r($row); die;
                    ?>
                    <tr>
                        <td><?php echo $row['billno'];?></td>
                        <td><?php echo $row['bill_date'];?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['discount'];?></td>
                        <td><?php echo $row['total_amt'];?></td>
                        <td><?php echo $row['userid'];?></td>
                        
                        <td>
						<a href="<?php echo base_url().'Sales/generatePdf/'.$row['yearid'].'/'.$row['billno'];?>" class="btn btn-success" target="_NEW"><?php echo $this->lang->line('form_field_view_bill'); ?></a>
						</td>
                    </tr    >
                    <?php 
                    $count++ ;
                } } else { ?>
                <tr><td colspan = "7" class="text-danger">No Data Found</td></tr>
                <?php } ?>
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