<?php if (!function_exists('base_url')) { $this->load->helper('url'); } ?>
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('menu_master_type_master'); ?></h6>
    </div>
    <div class="card-body">
    

    <!-- Large modal -->
<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> <?php echo $this->lang->line('menu_master_type_master'); ?></button>


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('form_field_id'); ?></th>
                        <th><?php echo $this->lang->line('form_field_item_type'); ?></th>
                        <th><?php echo $this->lang->line('form_field_cutter_commission'); ?></th>
                        <th><?php echo $this->lang->line('form_field_surgeon_commission'); ?></th>
                        <th><?php echo $this->lang->line('form_field_rate'); ?></th>
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
						if(!empty($typeData)) {
                        foreach($typeData as $row) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['type_name'].'('.$row['type_name_marathi'].')';?></td>
                        <td><?php echo $row['cutter_comm'];?></td>
                        <td><?php echo $row['surgeon_comm'];?></td>
                        <td><?php echo $row['rate'];?></td>
                        <td><?php echo $row['visible'];?></td>
                        <td>
                            <button 
                                type="button" 
                                class="btn btn-success edit-type-btn" 
                                data-toggle="modal" 
                                data-target=".bd-example-modal-lg"
                                data-type_id="<?php echo $row['type_id'];?>"
                                data-type_name="<?php echo htmlspecialchars($row['type_name'], ENT_QUOTES);?>"
                                <?php if (!empty($row['type_name_marathi'])) { ?>
                                    data-type_name_marathi="<?php echo htmlspecialchars($row['type_name_marathi'], ENT_QUOTES); ?>"
                                <?php } ?>
                                data-cutter_comm="<?php echo htmlspecialchars($row['cutter_comm'], ENT_QUOTES);?>"
                                data-surgeon_comm="<?php echo htmlspecialchars($row['surgeon_comm'], ENT_QUOTES);?>"
                                data-rate="<?php echo htmlspecialchars($row['rate'], ENT_QUOTES);?>"
                                data-visible="<?php echo $row['visible'];?>"
                            >
                                <i class="fa fa-solid fa-edit" title="Edit"></i>
                            </button>
<a class="btn btn-warning" href="<?php echo base_url().'Job/slipDesign/'.$row['type_id'];?>" target="_NEW"><i class="fa fa-solid fa-draw" title="Make Inactive Temprary"><?php echo $this->lang->line('slip_design'); ?></i></a>
</td>
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
            <h5 class="modal-title" id="exampleModalLabel"><?php echo $this->lang->line('menu_master_type_master'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" class="avighna-form" id="worker-form"  data-successresponse = "typesucess" data-reset = "yes" data-action = "<?php echo base_url("Master/typeCreateDb");?>" enctype="multipart/form-data">
                <div id="typesucess"></div>
                <input type="hidden" name="hidden_type_id" id="hidden_type_id" value="">    
                <div class="row">
                    <div class="form-group col-4">
                        <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_item_type'); ?></label>
                        <input type="text" class="form-control" name="type_name" id ="type_name">
                    </div>
                    <div class="form-group col-4">
                        <label for="type_name_marathi" class="col-form-label">
                            <?php echo $this->lang->line('form_field_item_type_mar'); ?>
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="type_name_marathi" id="type_name_marathi" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="itemGroupBtn" title="Voice Comamnd">
                                    <span class="glyphicon glyphicon-mic">V</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-4">
                        <label for="cutter_comm" class="col-form-label"><?php echo $this->lang->line('form_field_cutter_commission'); ?></label>
                        <input type="text" class="form-control" name="cutter_comm" id="cutter_comm">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        <label for="surgeon_comm" class="col-form-label"><?php echo $this->lang->line('form_field_surgeon_commission'); ?></label>
                        <input type="text" class="form-control" name="surgeon_comm" id="surgeon_comm">
                    </div>
                    <div class="form-group col-4">
                        <label for="rate" class="col-form-label"><?php echo $this->lang->line('form_field_rate'); ?></label>
                        <input type="text" class="form-control" name="rate" id="rate">
                    </div>
                    <div class="form-group p-4 col-4">
                        <div class="form-check p-4">
                            <input class="form-check-input" type="checkbox" value="1" name="visible" id="visible">
                            <label class="form-check-label" for="visible">
                                <?php echo $this->lang->line('form_field_operning_visible'); ?>
                            </label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="type_id" id="type_id">
            
           
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