<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold ">
            <b class="text-primary"><?php echo $this->lang->line('form_field_billamt'); ?> : <span id="total-bill-amount">   00 </span> </b>
            <b class="text-success"><?php echo $this->lang->line('form_field_noofitem'); ?> : <span id="total-bill-items">  00 </span> </b></h6>
    </div>
    <div class="card-body">
    
    <form method="post" class="avighna-form" id="newbill"  data-successresponse = "typesucess" data-reset = "yes" data-action = "<?php echo base_url("Sales/salesDb");?>" enctype="multipart/form-data">
            <div id="typesucess">   </div>
            <div class="row">
                <!--<div class="form-group col-2">
                    <label for="recipient-name" class="col-form-label">Bill No</label>
                    <input type="text" class="form-control"  disabled>
                </div>-->
                
                
                <div class="form-group col-2">
                    <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_date'); ?></label>
                    <input type="date" class="form-control" name="billdate" >
                </div>
                <div class="form-group col-4">
                    <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_custselect'); ?></label>
                    <!--<button type="button" onclick="startVoiceFilter()">🎙 Start Voice</button>-->
                    <select class="form-control selectpicker" data-live-search="true" name="custselect" id="custselect">
                        <option>Select</option>
                        <?php foreach($custData as $row) { ?>
                            <option value="<?php echo $row['cid'];?>"><?php echo $row['name'];?></option>
                        <?php } ?>    
                    </select>
                </div>
                <div class="form-group col-2">
                    <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_delivery_date'); ?></label>
                    <input type="date" class="form-control" name="trialdate" >
                </div>
                
                <div class="form-group col-2">
                    <label for="recipient-name" class="col-form-label"><?php echo $this->lang->line('form_field_advance_pay'); ?></label>
                    <input type="text" class="form-control" id="tadvancepayment" name="tadvancepayment" value="0">
                </div>
                <div class="form-group col-2">
                    <label for="recipient-name" class="col-form-label">-</label>
                    <button type="submit" class="form-control btn btn-primary" ><?php echo $this->lang->line('form_field_generate_bill'); ?></button>
                </div>
            </div>
            <fieldset id="billItems" class="container border border-secondary">
                <legend style="font-size:11pt;"><?php echo $this->lang->line('form_field_itemdtl'); ?></legend>
                <div class="row">
                    <div class="col-3">
                        <select class="form-control select-type"  name="type[]" id="type">
                            <option><?php echo $this->lang->line('form_field_selecttype'); ?></option>
                            <!--<option value="1" data-measurement = "A1,A2,A3,A4">Shirt</option>
                            <option value="2" data-measurement = "m1,m2,m3,m4">Pant</option>-->
                            <?php foreach($typeData as $row) {?>
                                <option value="<?php echo $row['type_id'];?>" data-measurement = "<?php echo $row['measurements'];?>" data-rate = "<?php echo $row['rate'];?>"><?php echo $row['type_name'];?></option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control rate" name="rate[]"  placeholder = "<?php echo $this->lang->line('form_field_rate'); ?>" >
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control qty" name="qty[]" placeholder = "<?php echo $this->lang->line('form_field_qty'); ?>" >
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control " id="initEvent" name="additionaldtl[]" data-hiddenfield = "mhf01" placeholder = "<?php echo $this->lang->line('form_field_additional_dtl'); ?>" data-measurement = "" >
                        <input type="hidden" id="mhf01" name = "measurements[]" />
                    </div>
                    <div class="col-2 ">
                        <button type="button" class="btn btn-success mb-3 add-bill-dtl"><?php echo $this->lang->line('form_field_add'); ?></button>
                    </div>
                </div>
            </fieldset>
            <hr/>
            
        </form>


    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="measurementModel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Measurement</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
        <form id="get-billdetails-form">     
            <div id = "measurements-form"></div>
                
            <div id="fashion-form">

            </div>

            
            
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary" >Submit</button>
        </form>
        <button type="button" class="btn btn-secondary">Cancel</button>
    </div>
    </div>
    
</div>
</div>

</div>
<!-- /.container-fluid -->