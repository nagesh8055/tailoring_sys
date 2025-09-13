
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('menu_master_fashion_master'); ?></h6>
    </div>
    <div class="card-body">
    

    <!-- Large modal -->
<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> <?php echo $this->lang->line('menu_master_fashion_master'); ?></button>


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('form_field_id'); ?></th>
                        <th><?php echo $this->lang->line('form_field_type'); ?></th>
                        <th><?php echo $this->lang->line('form_field_fashionname'); ?></th>
                        <th><?php echo $this->lang->line('form_field_operning_visible'); ?></th>
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
                        
                        foreach($fData as $row) {
                            
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['type_id'];?></td>
                        <td><?php echo $row['f_name'];?></td>
                        <td><?php echo $row['visible'];?></td>
                        <td><button type="button" class="btn btn-success "><i class="fa fa-solid fa-edit" title="Make Inactive Temprary"></i></button></td>
                         <!-- <button 
                                type="button" 
                                class="btn btn-success edit-type-btn" 
                                data-toggle="modal" 
                                data-target=".bd-example-modal-lg"
                                data-type_id="<?php echo $row['fashion_id'];?>"
                                data-type_name="<?php echo htmlspecialchars($row['f_name'], ENT_QUOTES);?>"
                                <?php if (!empty($row['f_name_marathi'])) { ?>
                                    data-type_name_marathi="<?php echo htmlspecialchars($row['type_name_marathi'], ENT_QUOTES); ?>"
                                <?php } ?>
                                data-cutter_comm="<?php echo htmlspecialchars($row['cutter_comm'], ENT_QUOTES);?>"
                                data-surgeon_comm="<?php echo htmlspecialchars($row['surgeon_comm'], ENT_QUOTES);?>"
                                data-rate="<?php echo htmlspecialchars($row['rate'], ENT_QUOTES);?>"
                                data-visible="<?php echo $row['visible'];?>"
                            >
                                <i class="fa fa-solid fa-edit" title="Edit"></i>
                            </button> -->
                    </tr>
                    <?php 
                    $count++ ;
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo $this->lang->line('menu_master_fashion_master'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form method="post" class="avighna-form" id="fashion-form"  data-successresponse = "fsucess" data-reset = "yes" data-action = "<?php echo base_url("Master/fashionCreateDb");?>" enctype="multipart/form-data">
                <div id="fsucess"></div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_type'); ?></label>
                        <select class="form-control" name="type_id" id="exampleFormControlSelect1">
                            <option>Select</option>
                            <?php 
                                foreach($typeData as $row) { ?>
                                    <option value = "<?php echo $row['type_id']; ?>"><?php echo $row['type_name']; ?></option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_fashionname'); ?></label>
                        <input type="text" class="form-control" name="f_name">
                    </div>
                    <div class="form-group p-4 col-4 " style="margin-top:20px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="<?php echo $this->lang->line('form_field_operning_visible'); ?>" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                <?php echo $this->lang->line('form_field_operning_visible'); ?>
                            </label>
                        </div>
                    </div>
                </div>
                <fieldset id="subFashionSection" class="container border border-secondary">
                    <legend style="font-size:11pt;"></legend><?php echo $this->lang->line('form_field_fashiondtl'); ?>
                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control" name="fdtl[]" placeholder="<?php echo $this->lang->line('form_field_fashiondtl'); ?>">
                        </div>
                        <div class="col-3">
                        <div class="form-check mt-1">
                            <input class="form-check-input" type="checkbox" value="" name="fdtlchk[]" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                <?php echo $this->lang->line('form_field_operning_visible'); ?>
                            </label>
                        </div>
                        </div>
                        <div class="col-3 ">
                            <button type="button" class="btn btn-primary mb-3 add-fashion-dtl"><?php echo $this->lang->line('form_field_add'); ?></button>
                        </div>
                    </div>
                </fieldset>
            
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary" ><?php echo $this->lang->line('form_field_save'); ?></button>
        </form>
        <button type="button" class="btn btn-secondary"><?php echo $this->lang->line('form_field_cancel'); ?></button>
    </div>
    </div>
    
</div>
</div>

</div>
<!-- /.container-fluid -->