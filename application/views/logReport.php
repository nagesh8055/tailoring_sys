
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Log Report</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>SHORT URL</th>
                        <th>IP ADDRESS</th>
                        <th>Device</th>
                        <th>DATE</th>
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
                        foreach($logData as $row) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td title=""><?php echo base_url().$row['surl'];?></td>
                        <td><?php echo $row['ip_address'];?></td>
                        <td><?php echo $row['device'];?></td>
                        <td><?php echo $row['date_'];?></td>
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

</div>
<!-- /.container-fluid -->