
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Customer Measurement Search</h6>
    </div>
    <div class="card-body">
    <form method="post" id="bill-filter" action = "<?php echo base_url("Job/customerMeasurement");?>" enctype="multipart/form-data">
        <div class="row">
        <div class="form-group col-4">
                    <label for="recipient-name" class="col-form-label">Select Customer</label>
                    <select class="form-control selectpicker"  data-live-search="true" data-live-search-style="startsWith" name="custselect" id="custselect">
                        <option>Select</option>
                        <?php 
                        
                        foreach($custData as $row) { 
                            
                            ?>
                            
                            <option value="<?php echo $row['cid'];?>" <?php if(isset($custId) && $row['cid']==$custId) {echo "selected";} ?> ><?php echo $row['name'];?></option>
                            
                        <?php } ?>    
                    </select>
                </div>
                <div class="form-group col-1 text-center text-danger">
                <label for="recipient-name" class="col-form-label" style="margin-top:40px;">OR</label>
                
            </div>
            <div class="form-group col-3">
                <label for="recipient-name" class="col-form-label">Mobile No.</label>
                <input type="text" class="form-control" name="mobileno" value= "<?php  if(isset($mobileno)) echo $mobileno; ?>">
            </div>
            <div class="form-group col-2">
            <label for="recipient-name" class="col-form-label">-</label>
                <button id="assign-job-submit" type="submit" class="form-control btn btn-primary">Search</button>
            </div>
        </div>
        <hr/>
    </form>

    <!-- Large modal -->
<!--<button type="button" class="btn btn-primary d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-4" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> Create Worker</button>-->


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Type</th>
                        <th>Measurements</th>
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
                <?php if ($this->session->flashdata('measurementMsg')) {
                    echo '<p class="alert alert-danger">'.$this->session->flashdata('measurementMsg').'</p>';
                } ?>
                    <?php if(isset($measurement)) {
                        
                        $i =0;
                        foreach($measurement as $row) { $i++; 
                        //print_r($row);
                        //echo gettype($row);
                        ?>
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['type_name'] ?></td>
                        <td><?php foreach (json_decode($row['job_details'],true) as $row ) {
                            echo strstr($row['name'],'-',true).":".$row['value']."<br/>";
                            
;                        } ?></td>
                    </tr>

                        <?php }//end of forach
                    }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



</div>
<!-- /.container-fluid -->