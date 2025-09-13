
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('menu_master_measurement_master'); ?></h6>
    </div>
    <div class="card-body">
    

    <!-- Large modal -->
<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> <?php echo $this->lang->line('menu_master_measurement_master'); ?></button>


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('form_field_id'); ?></th>
                        <th><?php echo $this->lang->line('form_field_measurement'); ?></th>
                        <th><?php echo $this->lang->line('form_field_type'); ?></th>
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
                        foreach($mData as $row) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['type_id'];?></td>
                        <td><?php echo $row['m_name'];?></td>
                        <td><?php echo $row['visible'];?></td>
                        <td><button type="button" class="btn btn-success edit-measurement" data-mid = "<?php echo $row['m_id'];?>" data-mname = "<?php echo $row['m_name'];?>" data-visible = "<?php echo $row['visible'];?>" data-custom = "<?php echo $row['is_custom'];?>" data-mtype = "<?php echo $row['type_id'];?>"><i class="fa fa-solid fa-edit" title="Make Inactive Temprary" data-toggle="modal" data-target=".bd-example-modal-lg"></i></button></td>
                        <!--<td><button type="button" class="btn btn-danger "><i class="fa fa-solid fa-eye-slash" title="Make Inactive Temprary"></i></button></td>-->
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
            <h5 class="modal-title" id="exampleModalLabel"><?php echo $this->lang->line('menu_master_measurement_master'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" class="avighna-form" id="measurementform"  data-successresponse = "msucess" data-reset = "yes" data-action = "<?php echo base_url("Master/measurementCreateDb");?>" enctype="multipart/form-data">
            <div id="msucess"></div>
            <input type="hidden" name="m_id" value="0"/>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_type'); ?></label>
                        <select class="form-control" name="type_id" id="exampleFormControlSelect1">
                            <option>Select</option>
                            <?php 
                                foreach($typeData as $row) { ?>
                                    <option value = "<?php echo $row['type_id']; ?>"><?php echo $row['type_name']; ?></option>
                                <?php } ?>
                            
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_measurement'); ?></label>
                        <input type="text" class="form-control" name="m_name">
                    </div>
                    <div class="form-group p-4 col-3">
                        <div class="form-check p-4">
                            <input class="form-check-input" type="checkbox" name="Visible" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                <?php echo $this->lang->line('form_field_operning_visible'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group p-4 col-3">
                        <div class="form-check p-4">
                            <input class="form-check-input" type="checkbox" name="custom_input" value="" id="custom_input">
                            <label class="form-check-label" for="defaultCheck1">
                               <?php echo $this->lang->line('form_field_iscustom'); ?> 
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