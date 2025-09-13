
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $this->lang->line('form_commission_dtl_report');?></h6>
    </div>
    <div class="card-body">
    

    <!-- Large modal -->
<!--<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> Create Worker</button>-->


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('form_field_srno');?></th>
                        <th><?php echo $this->lang->line('form_field_date');?></th>
                        <th><?php echo $this->lang->line('form_field_jobid');?></th>
                        <th><?php echo $this->lang->line('form_field_billno');?></th>
                        <th><?php echo $this->lang->line('form_field_type');?></th>
                        <th><?php echo $this->lang->line('form_field_qty');?></th>
                        <th><?php echo $this->lang->line('form_field_tot');?></th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count = 1;
                        //print_r($commdtl); die;
                        foreach($commdtl as $row) {
                        // if($row['w_type_id'] == 1) { $wtype = "Cutter" ; }
                        // if($row['w_type_id'] == 2) { $wtype = "Steacher" ; }
                        // if($row['w_type_id'] == 3) { $wtype = "Manager" ; }
                        // if($row['w_type_id'] == 4) { $wtype = "Computer Operator" ; }
                    ?>
                    <tr>
                        <td><?php echo $count;?></td>
                        <td><?php echo $row['update_date'];?></td>
                        <td><?php echo $row['jobid'];?></td>
                        <td><?php echo $row['bill_no'];?></td>
                        <td><?php echo $row['type_name'];?></td>
                        <td><?php echo $row['submit_qty'];?></td>
                        <td><?php echo $row['amt'];?></td>
                        
                    </tr>
                    <?php 
                    $count++ ;
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



</div>
<!-- /.container-fluid -->