<?php
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['mobileno']) || empty($_SESSION['mobileno'])){
header("location: index.php");
exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include "connect.php"; ?>
<meta charset="utf-8" />
<title>Add Golf Member</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
<link rel="stylesheet" href="css/bootstrap.css" >
<link rel="stylesheet" href="css/style.css" >
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<?php include("includes/header.php"); ?>

<div class="container-fluid">
  <div class="row"> <br />
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-user"></span> Add Golf Members</div>
        <div class="panel-body" ><br>
          <form method="post" enctype="multipart/form-data"  action="golfmemberadd.php">
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <div class="row">
                  <div class="col-md-6">
                    <label class="control-label">Member Full Name</label>
                    <input class="form-control" type="text" name="gmfullname" required pattern="[A-Za-z\s]+" placeholder="Enter Member Name"  />
                  </div>
                  <div class="col-md-6">
                    <label class="control-label">Member Short Name</label>
                    <input class="form-control" type="text" name="gmshortname" required pattern="[A-Za-z]{1,5}" maxlength="5" placeholder="Enter Member Short Name"  />
                  </div>
                </div>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <label class="control-label">Member Profile Picture </label>
                <input type="file" name="gmpp" accept="image/*" value="aa.png" />
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <div class="row">
                  <div class="col-md-6">
                    <label class="control-label">City</label>
                    <input class="form-control" type="text" name="city" required pattern="[A-Za-z\s]+" placeholder="Enter City"  />
                  </div>
                  <div class="col-md-6">
                    <label class="control-label">Area</label>
                    <input class="form-control" type="text" name="area"  placeholder="Enter Area"  />
                  </div>
                </div>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <div class="slidecontainer">
                  <p>
                    <label class="control-label">Handicap</label>
                    <b>Value:</b> <span id="demo"></span></p>
                  <input type="range" min="1" max="30" value="50" name="handicap" class="slider" id="myRange">
                </div>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <button type="submit" name="btnsave" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Register New Member</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
              </div>
              <div class="col-md-1"> </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-3" >
      <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-user"></span> List of Golf Members</div>
        <div class="panel-body" style="max-height: 470px;overflow-y: scroll;">
          <?php $get2 = mysqli_query($conn,"SELECT gmfullname,gmshortname,handicap FROM tbgolfmember ORDER BY gmfullname");
			  while($row2 = mysqli_fetch_array($get2))
			  {
			   
				$gmfullname=$row2['gmfullname']; 
				$gmshortname = $row2['gmshortname'];
				$handicap = $row2['handicap'];	
				
			?>
			  <a href="viewgolfmember.php">
				  <div class="row">
					<div class="col-md-3">
					  <p><b><?php echo $gmshortname;  ?></b></p>
					</div>
					<div class="col-md-7">
					  <p class="text-info"><b><?php echo $gmfullname;  ?></b></p>
					</div>
					<div class="col-md-2">
					  <p><b><?php echo $handicap; ?> </b></p>
					</div>
				  </div>
			  </a>
			  <hr>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<br>

<?php include("includes/footer.php"); ?>
<style>

.slidecontainer {
    width: 100%;
}

.slider {
    -webkit-appearance: none;
    width: 100%;
    height: 25px;
    background: #d3d3d3;
    outline: none;
    opacity: 0.7;
    -webkit-transition: .2s;
    transition: opacity .2s;
}

.slider:hover {
    opacity: 1;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 25px;
    height: 25px;
    background: #4CAF50;
    cursor: pointer;
}

.slider::-moz-range-thumb {
    width: 25px;
    height: 25px;
    background: #4CAF50;
    cursor: pointer;
}
.row{
    margin-bottom: 3.5px;
}
</style>
</body>
<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}

 
</script>

<script>
$(document).ready(function(){
	 $("#nav01").addClass("active");
});	 
</script>
</html>
