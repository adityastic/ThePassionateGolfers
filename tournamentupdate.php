<?php

include "connect.php";
session_start();
if(!isset($_SESSION['mobileno']) || empty($_SESSION['mobileno'])){
header("location: index.php");
exit;
}

?>
<?php $getid=$_REQUEST['gtid']; ?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
        <div class="panel-heading" style="background: #28B463; color:white;"><span class="glyphicon glyphicon-user"></span> Update Golf Tournament</div>
        <div class="panel-body"><br>
          <form method="post" enctype="multipart/form-data" action="tournamentupdate2.php">
            <?php
$get3 = mysqli_query($conn,"SELECT * FROM tbgolfcourse");
$get4 = mysqli_query($conn,"SELECT * FROM tbgolfmember");
                    $get2 = mysqli_query($conn,"SELECT * FROM tbgolftournament where gtid='$getid'");
                    while($row2 = mysqli_fetch_array($get2))
                    {
                      $gtid=$row2['gtid'];
					  $gtname=$row2['gtname'];
					  $gtstartdate = $row2['gtstartdate'];
					  $gtdate=$row2['gtdate'];
					 $gttime=$row2['gttime'];
					$gtcourse=$row2['gtcourse'];
					 //$gtmember =$row2['gtmember'];
					  
			?>
            <input type="hidden" name="gtid" id="gtid" value="<?php echo $gtid; ?>"/>
            <div class="row">
              <div class="form-group col-md-7">
                <!-- Full Name -->
                <label class="control-label">Golf Tournament Name</label>
                <input class="form-control" type="text" name="gtname" value="<?php echo $gtname; ?>" placeholder="Enter Golf Course"  />
              </div>
              <div class="form-group col-md-5">
                <!-- Full Name -->
                <label class="control-label">Golf Course</label>
                <select class="form-control" name="gtcourse">
                  <option value="<?php echo $gtcourse; ?>"><?php echo $gtcourse; ?></option>
                  <option value="<?php echo $gtcourse; ?>">Select Different Course</option>
                  <?php 				
					 while($row3 = mysqli_fetch_array($get3))
					 {
						 $gcfullname = $row3['gcfullname'];
						 if($gcfullname != $gtcourse){
						 
					?>
                  <option value="<?php echo $gcfullname; ?>"><?php echo $gcfullname; ?></option>
                  <?php } }?>
                </select>
              </div>
            </div>
            <div class="row"> 
              <div class="form-group col-md-4">
                <!-- Full Name -->
                <label class="control-label">Tournament Last Registration Date</label>
                <input class="form-control" type="date" name="gtstartdate" value="<?php echo $gtstartdate; ?>" placeholder="Your Golf Short Name"  />
              </div>
              <div class="form-group col-md-4">
                <!-- Full Name -->
                <label class="control-label">Tournament Date</label>
                <input class="form-control" type="date" name="gtdate" value="<?php echo $gtdate; ?>" placeholder="Your Golf Short Name"  />
              </div>
              <div class="form-group col-md-4">
                <!-- Full Name -->
                <label class="control-label">Time</label>
                <input class="form-control" type="time" name="gttime" value="<?php echo $gttime; ?>" placeholder="Your Golf Short Name"  />
              </div>
            </div>
            <?php $gtmembers = json_decode(($row2['gtmember']));?>
            <br>
            <!--<div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <div class="row">
                  <div class="col-md-8">
                    <label>Golf Member Playing Tournament</label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="myInput" placeholder="Search">
                  </div>
                </div>
                <hr>
                <div class="panel-body" style="max-height: 80px;overflow-y: scroll; margin-top:-20px;">
                  <div class="row" >
                    <?php 
		   				/*foreach($gtmembers as $value){
						$get2 = mysqli_query($conn,"SELECT * FROM tbgolfmember WHERE gmid = '$value' ORDER BY gmfullname");
						  while($row2 = mysqli_fetch_array($get2))
						  {
						   
							$gmfullname=$row2['gmfullname'];
							$gmid=$row2['gmid'];*/
					?>
                    <div class="col-md-4">
                      <p style="display:inline; " class="myList">
                        <input type="checkbox"  name="gtmember[]" checked value="<?php echo $gmid;  ?>">
                        &nbsp;<?php //echo $gmfullname;  ?>&nbsp;</p>
                    </div>
                    <?php  //} } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-1"> </div>
            </div>-->
            <br>
            <br>
            <div class="row">
              <div class="form-group col-md-12">
                <div class="row">
                  <div class="col-md-8">
                    <label>Select Golf Member Playing Tournament</label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="myInput1" placeholder="Search">
                  </div>
                </div>
                <hr>
                <div class="panel-body" style="max-height: 280px;overflow-y: scroll; margin-top:-20px;">
                  <div class="row" >
                    <?php 
						$get5 = mysqli_query($conn,"SELECT gmfullname,gmid FROM tbgolfmember ORDER BY gmfullname");
					  	while($row5 = mysqli_fetch_array($get5))
					  	{
					   		$gmfullname=$row5['gmfullname'];
							$gmid=$row5['gmid'];
							$strChk = "";
							$chkTxtColor = "";
							if(in_array($row5['gmid'], $gtmembers))
							{
								$strChk = "checked";
								$chkTxtColor = "text-info";
							}
												
					?>
                    <div class="col-md-3">
                      <p style="display:inline; " class="myList1 <?=$chkTxtColor?>">
                        <input type="checkbox"  name="gtmember[]"  value="<?php echo $gmid;  ?>" <?=$strChk?> />
                        &nbsp;<?php echo $gmfullname;  ?>&nbsp;</p>
                    </div>
                    <?php  }  ?>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <br>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <button type="submit" class="btn btn-success" id="btnUpdate" name="btnUpdate">Update</button>
                <button type="reset" class="btn btn-danger" onClick="document.location.href='viewgolftournament.php';">Cancel</button>
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
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".myList").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script>
$(document).ready(function(){
  $("#myInput1").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".myList1").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script>
$(document).ready(function(){
	 $("#nav03").addClass("active");
});	 
</script>
<!-- ./wrapper -->
<!-- REQUIRED JS SCRIPTS -->
<?php include 'link-js.php'; ?>
<!-- // REQUIRED JS SCRIPTS -->
</body>
</html>
