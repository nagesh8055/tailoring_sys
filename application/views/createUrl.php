
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Generate Url</h6>
    </div>
    <div class="card-body">
        
    <!--Form-->
    <form  method = "POST">
              <div class="row gy-3 gy-md-4 overflow-hidden">
               
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Enter Url" aria-label="Enter Url" aria-describedby="basic-addon2" name="userurl" id="userurl" >
					<div class="input-group-append">
						<button class="btn btn-primary" id="create-link" type="submit">Create Link</button>
					</div>
				</div>
              </div>
            </form>
    <!--end of Form-->
    <div class="row gy-3 gy-md-4 overflow-hidden" id="create-url-response">
    </div>

    <div class="row gy-3 gy-md-4 overflow-hidden" id="create-url-response1">
    </div>

    </div>
</div>

</div>
<!-- /.container-fluid -->