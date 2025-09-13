<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
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
        
        <div class="col-12 col-md-6">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="row">
              <div class="col-12">
                <div class="mb-5">
                  <h3>Litly</h3>
                </div>
              </div>
            </div>
            <form action="qr/createlink" method = "POST">
              <div class="row gy-3 gy-md-4 overflow-hidden">
               
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2" name="userurl" id="userurl" >
					<div class="input-group-append">
						<button class="btn btn-primary" type="submit">Create Link</button>
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
      </div>
    </div>
  </div>
</section></body>
</html>
