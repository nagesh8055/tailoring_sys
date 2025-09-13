
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Job Slip Design</h6>
    </div>
    <div class="card-body" style="min-height:600px;">
    <style>
        #parent {
            position: relative;
            width: 210mm; /* Half of 210mm */
            height: 148.5mm; /* Half of 297mm */
            border: 1px solid black;
        }
        .textElement {
            position: absolute;
            border: 1px solid black;
            padding: 5px;
            cursor: move;
        }
    </style>    
    <?php
        if(isset($updateFlg)) {
            echo "<p class='alert alert-success'>Data Saved Successfully</p>";
        }
    ?>
    <form id="form-jobSlip" method="post" action="<?php echo base_url().'Job/slipDesign/'.$typeId;?>" enctype="multipart/form-data">
        <input type="hidden" name="typeid" value = "<?php echo $typeId;?>"/>
    <div id="parent">
            <?php 

            function convert_mm_to_pixels($mm, $dpi=96) {
                // Convert millimeters to pixels
                //$pixels = $mm * $dpi * (1 / 25.4);
                return $mm;//$pixels;
            }

            foreach($mdata as $row) {  
                ?> 
            <div class="textElement"><?php echo $row['m_name'];?>
                    <input type="hidden" name="m_id[]" value="<?php echo $row['m_id'];?>">
                    <input type="hidden" name="x[]" value = "<?php echo !empty($row['x']) ? convert_mm_to_pixels($row['x']) : 0;?>">
                    <input type="hidden" name="y[]" value = "<?php echo !empty($row['y']) ? convert_mm_to_pixels($row['y']) : 0;?>">
            </div>
            <?php } ?>
            
            <!--<button onclick="generatePDF()">Generate PDF</button>-->
         
    </div> <hr/>
    <button type="submit" class="btn btn-success">Save Job Slip</button> 
    <a class="btn btn-primary" href="<?php echo base_url().'Job/slipDesignPreview/'.$typeId;?>" target="_tab"><i class="fa fa-solid fa-draw" title="Make Inactive Temprary">Preview</i></a>
        </form>
    </div>
</div>
</div>
<!-- /.container-fluid -->