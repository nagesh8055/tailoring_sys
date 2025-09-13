
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('form_field_assign_job'); ?></h6>
    </div>
    <div class="card-body">
    
    <form method="post" id="bill-filter" data-action = "<?php echo base_url("Sales/assignJob");?>" enctype="multipart/form-data">
        <div class="row">
        <div class="form-group col-4">
                    <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_custselect'); ?></label>
                    <select class="form-control selectpicker"  data-live-search="true" data-live-search-style="startsWith" name="custselect" id="custselect">
                        <option>Select</option>
                        <?php foreach($custData as $row) {
                             ?>
                            
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
                <button id="assign-job-submit" type="submit" class="form-control btn btn-primary"><?php echo $this->lang->line('form_field_view_jobs'); ?></button>
            </div>
        </div>
        <hr/>
    </form>

    <!-- Large modal -->
<!--<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> Create Worker</button>-->


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <th><?php echo $this->lang->line('form_field_id'); ?></th>
                        <th><?php echo $this->lang->line('form_field_billno'); ?></th>
                        <th><?php echo $this->lang->line('form_field_type'); ?></th>
                        <th><?php echo $this->lang->line('form_field_qty'); ?></th>
                        <th><?php echo $this->lang->line('form_field_cutting'); ?></th>
                        <th><?php echo $this->lang->line('form_field_stitching'); ?></th>
                        <th><?php echo $this->lang->line('form_field_delivered'); ?></th>
                        <th><?php echo $this->lang->line('form_field_order_date'); ?></th>
                        <th><?php echo $this->lang->line('form_field_delivery_date'); ?></th>
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
                            //print_r($row); die;
                            $availableTotalForCutting = $row['total_qty'] - $row['c_ass_qty'];
                            $availableTotalForSteaching = $row['cutter_complete_qty'] - $row['s_ass_qty'];
                    ?>
                    <tr>
                        <td><?php echo $row['jobid'];?></td>
                        <td><?php echo $row['billno'];?></td>
                        <td><?php echo $row['type_name'];?></td>
                        <td><?php echo $row['total_qty'];?></td>
                        <td><?php echo $row['c_ass_qty'];?></td>
                        <td><?php echo $row['s_ass_qty'];?></td>
                        <td><?php echo $row['deliver_qty'];?></td>

                        <td><?php echo $row['order_date'];?></td>
                        <td><?php echo $row['delivery_date'];?></td>

                        <td>
                        <?php try { if($availableTotalForCutting > 0 )  { ?>  
                        <button type="button" title="Assign Cutter" class="btn btn-success assign-job" data-jobstatus = "<?php echo $row['status'];?>" data-jobid = "<?php echo $row['jobid'];?>" data-jobtype = "0" data-maxqty = "<?php echo $availableTotalForCutting; ?>"  ><i class="fa fa-cut"></i></button>
                            <?php } } catch(Exception $e) {
                                echo $e->getMessage();
                            }
                                ?>

                            <?php if($row['cutter_complete_qty'] > 0  ) { //if($row['status'] == 2 )  { ?>  
                        <button type="button" class="btn btn-warning assign-job" data-jobstatus = "<?php echo $row['status'];?>" data-jobtype = "1" data-jobid = "<?php echo $row['jobid'];?>" data-maxqty = "<?php echo $availableTotalForSteaching; ?>" title = "Assign Steaching" ><i class="fa fa-tshirt"></i></button>
                        
                            <?php } ?>
                            <a href="<?php echo base_url().'Job/slipDesignPreview/'.$row['type_id'].'/'.$row['jobid'].'/'.$row['type_name'].'/'.$row['delivery_date'];?>" class="btn btn-primary" target="_tab" title="Print Job Slip" ><i class="fa fa-solid fa-print"></i></a>    
                    </td>
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
            <h5 class="modal-title" id="exampleModalLabel">Assign Job</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" class="avighna-form" id="assign-job-form"  data-successresponse = "assignjobsucess" data-reset = "yes" data-action = "<?php echo base_url("Job/assignJobDb");?>" enctype="multipart/form-data">
                <div id="assignjobsucess"></div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="recipient-name" class="col-form-label">Date</label>
                        <input type="date" class="form-control" name="date">
                        <input type="hidden" class="form-control" name="jobid" id="tjobid">
                        <input type="hidden" class="form-control" name="jobmaxqty" id="tjobmaxqty">
                        <input type="hidden" class="form-control" name="tstatus" id="tstatus">
                        <input type="hidden" class="form-control" name="jobtype" id="jobtype">
                        
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label">Select Worker</label>
                        <select class="form-control" id="workerselect" name="worker">
                               <option>Select</option> 
                        </select>    
                        
                    </div>
                    <div class="form-group col-3">
                        <label for="recipient-name" class="col-form-label">Enter Qty</label>
                        <input type="text" class="form-control" name="jobqty" id="tjobqty">
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