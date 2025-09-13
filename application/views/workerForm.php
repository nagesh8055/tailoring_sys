<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('form_update_worker'); ?></h6>
        </div>
        <div class="card-body">
            <?php echo validation_errors('<p style="color: red;">', '</p>'); ?>
            <!--customerform-->
           <form method="post" class="" id="worker-form"  data-successresponse = "workersucess" data-reset = "yes" data-action = "<?php echo base_url("Worker/edit/{$cid}");?>" enctype="multipart/form-data">
                <div id="workersucess"></div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_name_eng'); ?></label>
                        <input type="text" class="form-control" name="name" <?php if(isset($worker['name'])) echo 'value="'.$worker['name'].'"'; ?>>
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_dob'); ?></label>
                        <input type="date" class="form-control" name="dob" <?php if(isset($worker['dob'])) echo 'value="'.$worker['dob'].'"'; ?>>
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_doj'); ?></label>
                        <input type="date" class="form-control" name="doj" <?php if(isset($worker['doj'])) echo 'value="'.$worker['doj'].'"'; ?>>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_mobile1'); ?></label>
                        <input type="text" class="form-control" name="mobile1" <?php if(isset($worker['mobile1'])) echo 'value="'.$worker['mobile1'].'"'; ?>>
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_mobile2'); ?></label>
                        <input type="text" class="form-control" name="mobile2" <?php if(isset($worker['mobile2'])) echo 'value="'.$worker['mobile2'].'"'; ?>>
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_worker_prakar'); ?></label>
                        <select class="form-control" id="workertypeselect" name="w_type_id">
                            <option>Select</option>
                            <option value="1" <?php if(isset($worker['w_type_id']) && $worker['w_type_id']==1 ) echo "selected"; ?>>Cutter</option>
                            <option value="2" <?php if(isset($worker['w_type_id']) && $worker['w_type_id']==2 ) echo "selected"; ?>>Steacher</option>
                            <option value="3" <?php if(isset($worker['w_type_id']) && $worker['w_type_id']==3 ) echo "selected"; ?>>Manager</option>
                            <option value="4" <?php if(isset($worker['w_type_id']) && $worker['w_type_id']==4 ) echo "selected"; ?>>Computer Operator</option>
                            <option value="5" <?php if(isset($worker['w_type_id']) && $worker['w_type_id']==5 ) echo "selected"; ?>>Worker</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <!--<div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_operning_balance'); ?></label>
                        <input type="text" class="form-control" name="obal">
                    </div>-->
                    <div class="form-group p-4 col-4">
                        <div class="form-check p-4">
                            <input class="form-check-input" type="checkbox" value="" name="visible" id="defaultCheck1" <?php if(isset($worker['visible']) && $worker['visible']==1) echo "checked"; ?>>
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


            <!-- Large modal -->




        </div>
    </div>



</div>
<!-- /.container-fluid -->