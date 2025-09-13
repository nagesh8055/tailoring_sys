
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">My Short Url's</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>SHORT URL</th>
                        <th>NO OF HITS</th>
                        <th>STATUS</th>
                        <th>CREATED DATE</th>
                        <th>ACTION</th>
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
                        foreach($urlList as $row) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td title="<?php echo $row['ourl'];?>"><?php echo base_url().$row['surl'];?></td>
                        <td><?php echo $row['visits'];?></td>
                        <td><?php echo ($row['urlStatus']==1)?'Acitive':'Inactive';?></td>
                        <td><?php echo $row['cdate'];?></td>
                        <td><button type="button" class="btn btn-danger "><i class="fa fa-solid fa-eye-slash" title="Make Inactive Temprary"></i></button></td>
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