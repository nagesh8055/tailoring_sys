<!DOCTYPE html>
<html lang="en">
<head>
  <title>QR Details Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Login 5 - Bootstrap Brain Component -->
<section class="p-3 p-md-4 p-xl-5">
  <div class="container">
    <div class="card border-light-subtle shadow-sm">
      <div class="row g-0">
        <!--Basic Information-->
        <div class="col-12 col-md-6">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="row">
              <div class="col-12">
                <div class="mb-5">
                  <h3>Please Fill Pet Details</h3>
                </div>
              </div>
            </div>
            <form action="<?php echo base_url().'qr/qrDetailsFillDb';?>" method = "POST"  enctype="multipart/form-data" >
              <div class="row gy-3 gy-md-4 overflow-hidden">
                <div class="col-12">
                  <label for="email" class="form-label">Pet Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="petname" id="petname" placeholder="petname" required>
                </div>
                <div class="col-6">
                   <label for="exampleFormControlSelect1" class="form-label">Select Pet Type</label>
				    <select class="form-control" id="pettype" name="pettype">
				      <option value="Select">Select</option>
				      <option value="Cat">Cat</option>
				      <option value="Dog">Dog</option>
				    </select>
                </div>
                <div class="col-6">
                   <label for="exampleFormControlSelect1" class="form-label">Select Gender</label>
				    <select class="form-control" id="petgender" name="petgender">
				      <option value="Select">Select</option>
				      <option value="Male">Male</option>
				      <option value="Female">Female</option>
				    </select>
                </div>

                <div class="col-6">
                  <label for="password" class="form-label">Whats App Number <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="wnumber" id="wnumber" value="" required>
                </div>
                <div class="col-6">
                  <label for="password" class="form-label">Alternet Contact Number <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="alternetcontactnumber" id="alternetcontactnumber" value="" required>
                </div>
                <div class="col-6">
                  <label for="password" class="form-label">Please Enter Pet Color <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="petcolor" id="petcolor" value="" required>
                </div>
                <div class="col-6">
                  <label for="password" class="form-label">Care Taker Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="caretaker" id="caretaker" value="" required>
                </div>
                <div class="col-6">
                  <label for="password" class="form-label">City <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="city" id="city" value="" required>
                </div>
                <div class="col-6">
                  <label for="password" class="form-label">Landmark<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="landmark" id="landmark" value="" required>
                </div>
                <div class="col-12">
                  <label for="password" class="form-label">Please Enter Full Address <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                </div>

                <div class="col-12">
                  <label for="password" class="form-label">Pet Image <span class="text-danger">*</span></label>
                	<input type="file" class="form-control-file" id="petimage" name="petimage">
            	</div>
                

                <!--<div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
                    <label class="form-check-label text-secondary" for="remember_me">
                      Keep me logged in
                    </label>
                  </div>
                </div>-->
                
              </div>
            <!--</form>-->
            <!--<div class="row">
              <div class="col-12">
                <hr class="mt-5 mb-4 border-secondary-subtle">
                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                  <a href="#!" class="link-secondary text-decoration-none">Create new account</a>
                  <a href="#!" class="link-secondary text-decoration-none">Forgot password</a>
                </div>
              </div>
            </div>-->
            
          </div>
        </div>
        <!--End Of Basic Information-->

        <!--Medical Information-->
        <div class="col-12 col-md-6">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="row">
              <div class="col-12">
                <div class="mb-5">
                  <h3>Please Fill Medical Details of Pet</h3>
                </div>
              </div>
            </div>
            <!--<form action="<?php echo base_url().'qr/qrDetailsLogin';?>" method = "POST">-->
              <div class="row gy-3 gy-md-4 overflow-hidden">
                <div class="col-12">
                  <label for="password" class="form-label">Medical History <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="medicalhistory" name="medicalhistory" rows="3"></textarea>
                </div>
                
                <div class="col-12">
                  <label for="email" class="form-label">Last Deworming Date <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" name="ldd" id="ldd" placeholder="Last Deworming Date" required>
                </div>
                <div class="col-6">
                   <label for="exampleFormControlSelect1" class="form-label">Sterilization Status</label>
				    <select class="form-control" id="strrilizationstatus" name="strrilizationstatus">
				      <option value="Select">Select</option>
				      <option value="Done">Done</option>
				      <option value="NO">NOt Done</option>
				      <option value="N/A">N/A</option>
				    </select>
                </div>
                

                <div class="col-6">
                  <label for="password" class="form-label">Last Vaccination Date Of ARV<span class="text-danger">*</span></label>
                  <input type="date" class="form-control" name="arvdate" id="arvdate" value="" required>
                </div>
                <div class="col-6">
                  <label for="password" class="form-label">Last Vaccination Date Of Viral <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" name="viraldate" id="viraldate" value="" required>
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button class="btn bsb-btn-xl btn-primary" type="submit">Submit Details</button>
                  </div>
                </div>
                
                
                </div>
              </div>
            </form>
            <!--<div class="row">
              <div class="col-12">
                <hr class="mt-5 mb-4 border-secondary-subtle">
                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                  <a href="#!" class="link-secondary text-decoration-none">Create new account</a>
                  <a href="#!" class="link-secondary text-decoration-none">Forgot password</a>
                </div>
              </div>
            </div>-->
            
          </div>
        </div>
        <!--End Of Medical Information-->
      </div>
    </div>
  </div>
</section></body>
</html>
