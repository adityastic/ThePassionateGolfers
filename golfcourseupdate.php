<?php

include "connect.php";
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['mobileno']) || empty($_SESSION['mobileno'])){
  header("location: index.php");
  exit;
}


?>
<?php $getid=$_REQUEST['gcid']; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Update Golf Course</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
<link rel="stylesheet" href="css/bootstrap.css" >
<link rel="stylesheet" href="css/style.css" >
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- REQUIRED CSS -->
<?php include 'link-css.php'; ?>
<!-- // REQUIRED CSS -->
<style media="screen">
      #btnSubmit:hover{
        background: #f5b120;
        color: white;
      }
    </style>
</head>
<body>
<?php include("includes/header.php"); ?>
<div class="container-fluid">
  <div class="row"> <br>
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading" style="background: #28B463; color:white;"><span class="glyphicon glyphicon-user"></span> Update Golf Course</div>
        <div class="panel-body"><br>
          <form method="post" enctype="multipart/form-data"  action="golfupdate2.php">
            <?php

                    $get2 = mysqli_query($conn,"SELECT * FROM tbgolfcourse where gcid='$getid'");
                    while($row2 = mysqli_fetch_array($get2))
                    {
                      $gcid=$row2['gcid'];
					  $gcfullname=$row2['gcfullname'];
					  $gcshortname=$row2['gcshortname'];
					 
					  $image = $row2['gcimage'];

					  
					  $description=$row2['description'];
					  $city=$row2['city'];
					  
					  
					  
					
					  
					  
	?>
            <input type="hidden" name="gcid" id="gcid" value="<?php echo $gcid; ?>"/>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <label class="control-label">Golf Course Name</label>
                <input class="form-control" readonly="true" type="text" name="gcfullname" value="<?php echo $gcfullname; ?>" placeholder="Enter Golf Course"  />
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <label class="control-label">Golf Short Name</label>
                <input class="form-control" readonly="true" type="text" name="gcshortname" value="<?php echo $gcshortname; ?>" placeholder="Your Golf Short Name"  />
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <label class="control-label">Golf Course Picture</label>
                <br>
                <img src="images/<?php echo $image; ?>" alt="Profile Picture" style=" width: 400px; height: 200px; margin-bottom:10px;"/>
                <input type="hidden" value="<?php echo $image; ?>" name="gcimage">
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <label class="control-label">Description</label>
                </td>
                <textarea class="form-control" type="text" name="description" placeholder="description"  rows="6"><?php echo $description; ?></textarea>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <label class="control-label">City</label>
                <input class="form-control" readonly="true" type="text" name="city" placeholder="Your Golf Short Name" value="<?php echo $city; ?>" />
              </div>
              <div class="col-md-1"> </div>
            </div>
            <br>
            <?php $holes = json_decode(($row2['holes']));?>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <div class="row">
                  <?php $index = 1; ?>
                  <label class="control-label">Number of Par in each hole</label>
                  <br>
                  <br>
                  <?php foreach($holes as $value)
								{
									?>
                  <div class="col-md-4" style="margin-bottom:20px;">
                    <p><b>Hole <?php echo ($index++); ?></b></p>
                    <select name="holes[]" class="form-control">
                      <?php if($value == ""){ 
											    ?>
                      <option value="">Select Par</option>
                      <?php }else { ?>
                      <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                      <option value="3"> 3 </option>
                      <option value="4"> 4 </option>
                      <option value="5"> 5 </option>
					  <option value="0">--</option>
                    </select>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <br>
            <?php $strokeindex = json_decode(($row2['strokeindex']));?>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <div class="row">
                  <?php $index = 1; ?>
                  <label class="control-label">Number of Stroke Index in each hole</label>
                  <br>
                  <br>
                  <?php foreach($strokeindex as $value)
								{
									?>
                  <div class="col-md-4" style="margin-bottom:20px;">
                    <p><b>Stroke Index of Hole <?php echo ($index++); ?></b></p>
                    <select name="strokeindex[]" class="form-control">
                      <?php if($value == ""){ 
											    ?>
                      <option value="">Select Stroke Index</option>
                      <?php }else { ?>
                      <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                      <option value="20">20</option>
                      <option value="19">19</option>
                      <option value="18">18</option>
                      <option value="17">17</option>
                      <option value="16">16</option>
                      <option value="15">15</option>
                      <option value="14">14</option>
                      <option value="13">13</option>
                      <option value="12">12</option>
                      <option value="11">11</option>
                      <option value="10">10</option>
                      <option value="9">9</option>
                      <option value="8">8</option>
                      <option value="7">7</option>
                      <option value="6">6</option>
                      <option value="5">5</option>
                      <option value="4">4</option>
                      <option value="3">3</option>
                      <option value="2">2</option>
                      <option value="1">1</option>
					  <option value="0">--</option>
                    </select>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <button type="submit" class="btn btn-success" id="btnUpdate" name="btnUpdate">Update</button>
                <button type="reset" class="btn btn-danger" onClick="document.location.href='viewgolfcourse.php';">Cancel</button>
              </div>
              <div class="col-md-1"> </div>
            </div>
         
			 <?php } ?>
		  </form>
		  
		  
        </div>
      </div>
    </div>
    <div class="col-md-2"></div>
  </div>
</div>
</div>
<!-- ./wrapper -->
<?php include("includes/footer.php"); ?>

<!-- REQUIRED JS SCRIPTS -->
<?php include 'link-js.php'; ?>
<!-- // REQUIRED JS SCRIPTS -->
</body>

<script>
$(document).ready(function(){
	 $("#nav02").addClass("active");
});	 
</script>


</html>
