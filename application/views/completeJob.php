
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('form_field_completed_job'); ?></h6>
    </div>
    <div class="card-body">
    

    <!-- Large modal -->
<!--<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> Create Worker</button>-->


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('form_field_id'); ?></th>
                        <th><?php echo $this->lang->line('form_field_billno'); ?></th>
                        <th><?php echo $this->lang->line('form_field_type'); ?></th>
                        <th><?php echo $this->lang->line('form_field_assigned'); ?></th>
                        <th><?php echo $this->lang->line('form_field_completed'); ?></th>
                        <th><?php echo $this->lang->line('form_field_assigned_date'); ?></th>
                        <th><?php echo $this->lang->line('form_field_worker'); ?></th>
                        <th><?php echo $this->lang->line('form_field_status'); ?></th>
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
                        foreach($jobData as $row) {
                           // print_r($row); die;
                        $jobStatus = '' ;
                        $assignedDate = '';
                        $workerId = 0;
                        
                        $type = ($row['job_type'] == 0 ) ? 'Cutting' : 'steaching' ;
                        $btnClass = 'btn-success';//$row['status']==1 ? 'btn-success' : 'btn-warning';
                        $workerName = "";//$this->getWorkerName($row['worker_id']);   
                        $submitMaxQty = $row['ass_qty'] - $row['submit_qty'];
                        if($row['status'] == 0 ) {
                            $jobStatus = 'Assigned';
                        } else if($row['status'] == 1) {
                            $jobStatus = 'Partially Completed';
                        }
                          
                        //print_r($workerData);die;
                        foreach ($workerData as $item) {
                            if ($item['w_id'] === $row['worker_id']) {
                                //return $item;
                                $workerName = $item['name'];
                                $workerId = $item['w_id'];
                            }
                        }
                        /*
                        if ($row['status'] == 1 || $row['status'] == 3 ) { 
                            $jobStatus =   $row['status']==1 ? 'Cutter Assined' : 'Steacher Assigned' ; 
                            $assignedDate = $row['status']==1 ? $row['cut_ass_date'] : $row['sur_ass_date'];
                            $workerName = "";//$this->getWorkerName($row['cutter_id']);
                            $btnClass = $row['status']==1 ? 'btn-success' : 'btn-warning';

                            $key = $row['status']==1 ? 'cutter_id'  : 'sur_id' ;
                            foreach ($workerData as $item) {
                                if ($item['w_id'] === $row[$key]) {
                                    //return $item;
                                    $workerName = $item['name'];
                                    $workerId = $item['w_id'];
                                }
                            }
                        }*/
                    ?>
                    <tr>
                        <td><?php echo $row['job_id'];?></td>
                        <td><?php echo $row['bill_no'];?></td>
                        <td><?php echo $type;?></td>
                        <td><?php echo $row['ass_qty'];?></td>
                        <td><?php echo $row['submit_qty'];?></td>
                        <td><?php echo $row['create_date'];?></td>
                        <td><?php echo $workerName;?></td>
                        <td><?php echo $jobStatus;?></td>
                        
                        <td><button type="button" class="btn <?php echo $btnClass;?> assign-job" data-wname = "<?php echo $workerName;?>" data-trackingid = "<?php echo $row['id'];?>" data-workerid = <?php echo $workerId; ?> data-type = "<?php echo $row['type_id'];?>" data-jobstatus = "<?php echo $row['status'];?>" data-jobid = "<?php echo $row['job_id'];?>" data-maxqty = "<?php echo $submitMaxQty;?>" data-jobtype = "<?php echo $row['job_type'];?>"  >Submit Job</button></td>
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
                    <div class="form-group col-2">
                        <label for="recipient-name" class="col-form-label">Submit Date</label>
                        <input type="date" class="form-control" name="date">
                        <input type="hidden" class="form-control" name="jobid" id="tjobid">
                        <input type="hidden" class="form-control" name="trackingid" id="trackingid">
                        <input type="hidden" class="form-control" name="tjobmaxqty" id="tjobmaxqty">
                        <input type="hidden" class="form-control" name="workerid" id="tworkerid">
                        <input type="hidden" class="form-control" name="tstatus" id="tstatus">
                        <input type="hidden" class="form-control" name="type" id="type">
                        <input type="hidden" class="form-control" name="jobtype" id="jobtype">
                        
                    </div>
                    <div class="form-group col-3">
                        <label for="recipient-name" class="col-form-label">Rack / Storage</label>
                        <select class="form-control" id="storeselect" name="storeselect">
                               <option>Select</option> 
                               <?php foreach($storageData as $row) {?>
                                    <option value="<?php echo $row['id'];?>"><?php echo $row['storage'];?></option>
                                <?php } ?>
                        </select>    
                        
                    </div>
                    <div class="form-group col-2">
                        <label for="recipient-name" class="col-form-label">Submit Qty</label>
                        <input type="text" class="form-control" name="tsubmitqty" id="tsubmitqty" >
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