<!-- Begin Page Content -->
<div class="container-fluid">
    

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('form_update_customer'); ?></h6>
    </div>
    <div class="card-body">
    <?php echo validation_errors('<p style="color: red;">', '</p>'); ?>
        <!--customerform-->
        <form method="post" id="customer-form-edit" action = "<?php echo base_url("Customer/edit/").$cid;?>" enctype="multipart/form-data">
                <div id="customersucess"></div>
                <input type="hidden" class="form-control" name = "cid" value="<?php echo $customer['cid']; ?>" >
                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_name_eng'); ?></label>
                        <input type="text" class="form-control" name = "name"  value="<?php echo $customer['name']; ?>" >
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_name_mar'); ?></label>
                        <input type="text" class="form-control" name = "marathi" value="<?php echo $customer['marathi']; ?>" >
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_dob'); ?></label>
                        <input type="date" class="form-control" name="dob" value="<?php echo $customer['dob']; ?>" >
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_mobile1'); ?></label>
                        <input type="text" class="form-control" name="mobile1" value="<?php echo $customer['mobile1']; ?>">
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_mobile2'); ?></label>
                        <input type="text" class="form-control" name="mobile2" value="<?php echo $customer['mobile2']; ?>" >
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_email'); ?></label>
                        <input type="text" class="form-control" name ="email" value="<?php echo $customer['email']; ?>" >
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_weight'); ?></label>
                        <input type="text" class="form-control" name="weight" value="<?php echo $customer['weight']; ?>" >
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_height'); ?></label>
                        <input type="text" class="form-control" name="height" value='<?php echo $customer['height']; ?>' >
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_address'); ?></label>
                        <input type="text" class="form-control" name="address" value='<?php echo $customer['address']; ?>' >
                    </div>
                    
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_photo'); ?></label>
                        <input type="file" class="form-control" >
                    </div>
                </div>
            
            
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('form_field_save'); ?></button>
        </form>
        <!--end of form-->
    

    <!-- Large modal -->



        
    </div>
</div>



</div>
<!-- /.container-fluid -->