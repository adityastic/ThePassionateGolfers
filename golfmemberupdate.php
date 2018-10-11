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
<?php $getid=$_REQUEST['gmid']; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8" />
<title>Update Golf Member</title>
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
        <div class="panel-heading" style="background: #28B463; color:white;"><span class="glyphicon glyphicon-user"></span> Update Golf Members</div>
        <div class="panel-body"><br>
          <form method="post" enctype="multipart/form-data" action="golfmemberupdate2.php">
            <?php

                    $get2 = mysqli_query($conn,"SELECT * FROM tbgolfmember where gmid='$getid'");
                    while($row2 = mysqli_fetch_array($get2))
                    {
                      $gmid=$row2['gmid'];
					  $gmfullname=$row2['gmfullname'];
					  $gmshortname=$row2['gmshortname'];
					  $gmpp=$row2['gmpp'];
					  $city=$row2['city'];
						$area=$row2['area'];
					$handicap=$row2['handicap'];
 
					  
			?>
            <input type="hidden" name="gmid" id="gmid" value="<?php echo $gmid; ?>"/>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-5">
                <!-- Full Name -->
                <label class="control-label">Golf Member Full Name</label>
                <input class="form-control" type="text" name="gmfullname" value="<?php echo $gmfullname; ?>" required placeholder="Enter Member Name"  />
              </div>
              <div class="form-group col-md-5">
                <!-- Full Name -->
                <label class="control-label">Golf Member Short Name</label>
                <input class="form-control" type="text" name="gmshortname" value="<?php echo $gmshortname; ?>" required pattern="[A-Za-z]{1,5}" maxlength="5" placeholder="Enter MemberShort Name"  />
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <label class="control-label">Member Profile Picture</label>
                <br>
                <?php if($gmpp == ""){ ?>
                <img src="images/aa.png" alt="Profile Picture" style=" width: 100px; height: 100px; margin-bottom:10px;"/>
                <?php }else{ ?>
                <img src="images/<?php echo $gmpp; ?>" alt="Profile Picture" style=" width: 100px; height: 100px; margin-bottom:10px;"/>
                <?php } ?>
                <input type="file" name="gmpp"/>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-5">
                <!-- Full Name -->
                <label class="control-label">city</label>
                <input class="form-control" type="text" name="city" value="<?php echo $city; ?>" required placeholder="Enter City"  />
              </div>
              <div class="form-group col-md-5">
                <!-- Full Name -->
                <label class="control-label">area</label>
                <input class="form-control" type="text" name="area" value="<?php echo $area; ?>" 11required placeholder="Enter Area"  />
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
                  <input type="range" min="1" max="30" value="<?php echo $handicap; ?>" name="handicap" class="slider" id="myRange">
                </div>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <button type="submit" class="btn btn-success" id="btnUpdate" name="btnUpdate">Update</button>
                <button type="reset" class="btn btn-danger" onClick="document.location.href='viewgolfmember.php';">Cancel</button>
              </div>
              <div class="col-md-1"> </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-2"></div>
  </div>
</div>
</div>
<!-- ./wrapper -->
<!-- REQUIRED JS SCRIPTS -->
<?php include 'link-js.php'; ?>
<!-- // REQUIRED JS SCRIPTS -->
<?php include("includes/footer.php"); ?>
<style>
.footer {
    position: fixed;
    left: 0;
    bottom: 0;
}
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
img {
    border-radius: 50%;
}

</style>
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
</body>
</html>
<?php
}
?>
