
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('form_field_payment'); ?></h6>
    </div>
    <div class="card-body">
            <form method="post" class="avighna-form" id="fadd-type-form" name ="fadd-payment-form"  data-successresponse = "paysucess" data-reset = "yes" data-action = "<?php echo base_url("payment/paymentDb");?>" enctype="multipart/form-data">
                <div id="paysucess"></div>    
                <div class="row">
                    <div class="form-group col-2">
                        <input type="hidden" name="paymentformtype" value="<?php echo $paymentFormType;?>"/>
                        <label for="dateSelect"><?php echo $this->lang->line('form_field_select_date'); ?></label>
                        <input type="date" class="form-control" id="dateSelect" name="date">
                    </div>
                    <div class="form-group col-4">
                        <label for="customerSelect"><?php echo $paymentFormType==1 ? $this->lang->line('form_field_custselect') : $this->lang->line('form_field_workerselect') ;?></label>
                        <select class="form-control" id="customer_worker" name="customer_worker">

                        
                        
                        <option>Select</option>
                            <?php 
                            
                            
                                if(isset($customerData) && !empty($customerData)) {
    
                                    foreach($customerData as $row) {
                            ?>        
                            <option value="<?php echo $row['cid'];?>" data-camt="<?php echo $row['camt'];?>"><?php echo $row['name'];?></option>
                            <?php
                                }    
                                } elseif(isset($workerData) && !empty($workerData)){ 

                                    foreach($workerData as $row) { ?>
                                        
                                        <option value="<?php echo $row['w_id'];?>" data-camt="<?php echo abs($row['camt']);?>"><?php echo $row['name'];?></option>
                                    <?php }

                                }

                            ?>
                            
                            
                            <!-- Add more options here -->
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <div class="form-group">
                            <label for="totalOustandingInput"><?php echo $this->lang->line('form_field_totos'); ?></label>
                            <input type="text" class="form-control" id="totalOustandingInput" name="total_outstanding" pattern="[0-9]+(\.[0-9]{1,2})?" title="Decimal number with up to 2 decimal places" readonly>
                        </div>
                    </div>
                    <div class="form-group col-2">
                        <div class="form-group">
                            <label for="amountInput"><?php echo $this->lang->line('form_field_enter_amount'); ?></label>
                            <input type="text" class="form-control" id="amountInput" name="amount" pattern="[0-9]+(\.[0-9]{1,2})?" title="Decimal number with up to 2 decimal places">
                        </div>
                    </div>
                    <div class="form-group col-2">
                        <label for="remainingAmountInput"><?php echo $this->lang->line('form_field_remaining_amount'); ?></label>
                        <input type="text" class="form-control" id="remainingAmountInput" name="remaining_amount" pattern="[0-9]+(\.[0-9]{1,2})?" title="Decimal number with up to 2 decimal places" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-2">    
                        <label for="paymentTypeSelect"><?php echo $this->lang->line('form_field_payment_type'); ?></label>
                        <select class="form-control" id="paymentTypeSelect" name="payment_type">
                            <option value=""></option>
                            <option value="1">Cash</option>
                            <option value="2">UPI Payment</option>
                            
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label for="transactionNoInput"><?php echo $this->lang->line('form_field_tran_no'); ?></label>
                        <input type="text" class="form-control" id="transactionNoInput" name="transaction_no">
                    </div>    
                    <div class="form-group col-3">
                        <label for="transactionNoInput">*</label>
                        <button type="submit" class="btn btn-primary form-control"><?php echo $this->lang->line('form_field_payment'); ?></button>
                    </div>
                </div>
            </div>
            
        <div class="modal-footer">
        
        </form>

    
    </div>
</div>



</div>
<!-- /.container-fluid -->