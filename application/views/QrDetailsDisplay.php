<!DOCTYPE html>
<html lang="en">
<head>
  <title>QR Details Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
<style type="text/css">
    body{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}
.card-img-top {
    width:300px;
    height: 300px;

}
</style>
</head>
<body>
<?php 
$formData = json_decode($dogDtl['form_data'],true);
?>
<div class="container emp-profile">

        <div class="card " >
    <div class="card-header">
            <h4 class="text-center"><?php echo $formData['petname'];?></h4>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <div class="p-2">    
                    <img class="card-img-top rounded-circle border border-dark" src="<?php echo $dogDtl['qrProfilePhotoUrl'];?>"  alt="Card image cap">
                </div>
            </div>
            <div class="col-8">
            <div class="row">
                <div class="d-flex">
                    <div class="p-4">
                        <h5>Color : <?php echo $formData['petcolor'];?></h5>
                    </div>
                    <div class="p-4">
                        <h5>Type : <?php echo $formData['pettype'];?></h5>
                    </div>
                    <div class="p-4">
                        <h5>Gender : <?php echo $formData['petgender'];?></h5>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="d-flex flex-nowrap">
                    <div class="p-2">
                        <h5>Care Taker: <?php echo $formData['caretaker'];?></h5>
                    </div>
                    <div class="p-2">
                        <h5>Whatsapp Number: <?php echo $formData['wnumber'];?></h5>
                    </div>
                    <div class="p-2">
                        <h5>Alternet Contact Number: <?php echo $formData['alternetcontactnumber'];?></h5>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="d-flex flex-nowrap">
                    <div class="p-2">
                        <h5>City: <?php echo $formData['city'];?></h5>
                    </div>
                    <div class="p-2">
                        <h5>Landmark: <?php echo $formData['landmark'];?></h5>
                    </div>
                    <div class="p-2">
                        <h5>Address :<br/><?php echo $formData['address'];?></h5>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><b>Medicalhistory:</b>
        <div>
            <?php echo $formData['medicalhistory'];?>
        </div>
    </li>
    <li class="list-group-item"><b>Last Deworming:
            <?php echo $formData['ldd'];?></b>
    </li>
    <li class="list-group-item"><b>Sterilization Status:
            <?php echo $formData['strrilizationstatus'];?></b>
    </li>
    <li class="list-group-item"><b>Last Vaccinated Date Of ARV:
            <?php echo $formData['arvdate'];?></b>
    </li>
    <li class="list-group-item"><b>Last Vaccinated Date Of Viral:
            <?php echo $formData['viraldate'];?></b>
    </li>
  </ul>
  <div class="card-body">
    <a href="#" class="card-link">Reset Data</a>
    <a href="#" class="card-link">Share Live Location</a>
    <a href="#" class="card-link">Quick Call</a>
  </div>
</div>    

                      
        </div>