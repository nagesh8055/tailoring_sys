<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('dashboard_new_worker'); ?></h6>
    </div>
    <div class="card-body">
    
<?php if ($this->session->flashdata('success')): ?>
        <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <!-- Large modal -->
<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i><?php echo $this->lang->line('dashboard_new_worker'); ?></button>


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('form_field_id'); ?></th>

                        <th><?php echo $this->lang->line('form_field_name'); ?></th>
                        <th><?php echo $this->lang->line('form_field_mobile1'); ?></th>
                        <th><?php echo $this->lang->line('form_field_worker_prakar'); ?></th>
                        <th><?php echo $this->lang->line('form_field_dob'); ?></th>
                        <th><?php echo $this->lang->line('form_field_doj'); ?></th>
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
						if(!empty($workerData)){
                        foreach($workerData as $row) {
                           // print_r($workerData); die;
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['mobile1'];?></td>
                        <td><?php echo $row['w_type_id'];?></td>
                        <td><?php echo $row['dob'];?></td>
                        <td><?php echo $row['doj'];?></td>
                        <td><a href="<?php echo base_url('Worker/edit/').$row['w_id'];?>" class="btn btn-success "><i class="fa fa-solid fa-edit" title="<?php  echo $this->lang->line('form_field_edit_kara'); ?>"></i></button></td>
                    </button></td>
                    </tr>
                    <?php 
                    $count++ ;
                } }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo $this->lang->line('dashboard_new_worker'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" class="avighna-form" id="worker-form"  data-successresponse = "workersucess" data-reset = "yes" data-action = "<?php echo base_url("Worker/createDb");?>" enctype="multipart/form-data">
                <div id="workersucess"></div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_name_eng'); ?></label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_dob'); ?></label>
                        <input type="date" class="form-control" name="dob">
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_doj'); ?></label>
                        <input type="date" class="form-control" name="doj">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_mobile1'); ?></label>
                        <input type="text" class="form-control" name="mobile1">
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_mobile2'); ?></label>
                        <input type="text" class="form-control" name="mobile2">
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_worker_prakar'); ?></label>
                        <select class="form-control" id="workertypeselect" name="w_type_id">
                            <option>Select</option>
                            <option value="1">Cutter</option>
                            <option value="2">Steacher</option>
                            <option value="3">Manager</option>
                            <option value="4">Computer Operator</option>
                            <option value="5">Worker</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_operning_balance'); ?></label>
                        <input type="text" class="form-control" name="obal">
                    </div>
                    <div class="form-group p-4 col-4">
                        <div class="form-check p-4">
                            <input class="form-check-input" type="checkbox" value="" name="visible" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                <?php echo $this->lang->line('form_field_operning_visible'); ?>
                            </label>
                        </div>
                    </div>
                    
                </div>
            
            
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('form_field_save'); ?></button>
        </form>
        <button type="button" class="btn btn-secondary"><?php echo $this->lang->line('form_field_cancel'); ?></button>

    </div>
    </div>
    
</div>
</div>

</div>
<!-- /.container-fluid -->