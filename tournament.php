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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Add Golf Tournament</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
<link rel="stylesheet" href="css/bootstrap.css" >
<link rel="stylesheet" href="css/style.css" >
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<?php include("includes/header.php"); ?>

<div class="container-fluid">
  <div class="row"> <br>
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-flag"></span> Add New Golf Tournament</div>
        <div class="panel-body">
          <form method="post" enctype="multipart/form-data" action="tournamentadd.php">
            <div class="row">
              <div class="form-group col-md-6">
                <label class="control-label" style="margin-bottom:10px;">Tournament Name</label>
                <input class="form-control" type="text" name="gtname" required placeholder="Enter Tournament Name"  />
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Golf Course</label>
                <select name="gtcourse"  class="form-control" required >
                  <option value="">Select Golf Course</option>
                  <?php 
					
						$get2 = mysqli_query($conn,"SELECT gcfullname,gcid FROM tbgolfcourse");
					  while($row2 = mysqli_fetch_array($get2))
					  {
			 
						$gcfullname=$row2['gcfullname'];
						$gcid=$row2['gcid'];
					?>
                  <option value="<?php echo $gcfullname;  ?>"><?php echo $gcfullname;  ?></option>
                  <?php  }  ?>
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="form-group col-md-4">
                <label class="control-label">Tournament Last Registration Date</label>
				<?php $todayDt = date("Y-m-d"); ?>
                <input class="form-control" type="date" name="gtstartdate" id="gtstartdate" min="<?=$todayDt?>" required   />
              </div>
              <div class="form-group col-md-4">
                <label class="control-label">Tournament Date</label>
                <input class="form-control" type="date" name="gtdate" id="gtdate" min="<?=$todayDt?>" required   />
              </div>
              <div class="form-group col-md-4">
                <label class="control-label">Tournament Timing</label>
                <input class="form-control" type="time" name="gttime"  required  />
              </div>
            </div>
            <br>
            <div class="row">
              <div class="form-group col-md-12">
                <div class="row">
                  <div class="col-md-8">
                    <label>Select Golf Members for Tournament</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-inline" role="form">
                      <div class=" form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4"></label>
                        <input type="text" class="form-control" id="myInput" placeholder="Search">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span> </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="panel-body" style="max-height: 350px;overflow-y: scroll; margin-top:-20px;">
                  <div class="row" >
                    <?php 
		
	$get2 = mysqli_query($conn,"SELECT gmfullname,gmid FROM tbgolfmember ORDER BY gmfullname");
  while($row2 = mysqli_fetch_array($get2))
  {
   
    $gmfullname=$row2['gmfullname'];
    $gmid=$row2['gmid'];
	?>
                    <div class="col-md-3">
                      <p style="display:inline; " class="myList">
                        <input type="checkbox"  name="gtmember[]" value="<?php echo $gmid;  ?>">
                        &nbsp;<?php echo $gmfullname;  ?>&nbsp;</p>
                    </div>
                    <?php  }  ?>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <br>
            <br>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <button type="submit" name="btnsave" class="btn btn-primary">Register New Tournament</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
              </div>
              <div class="col-md-1"> </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-flag"></span> List of Golf Tournament</div>
        <div class="panel-body" style="max-height: 470px;overflow-y: scroll;">
          <?php $get2 = mysqli_query($conn,"SELECT gtname,gtdate FROM tbgolftournament");
  while($row2 = mysqli_fetch_array($get2))
  {
   
    $gtname =$row2['gtname']; 
	$gtdate = $row2['gtdate']; 
	
 	?>
          <a href="viewgolftournament.php">
          <div class="row">
            <div class="col-md-7">
              <p class="text-info"><b><?php echo $gtname;  ?></b></p>
            </div>
            <div class="col-md-5">
              <p><b><?php echo date('d-m-Y' ,strtotime($gtdate));  ?></b></p>
            </div>
            </a> </div>
          <hr>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php"); ?>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".myList").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

///// Validate Tournament Date
$("#gtstartdate, #gtdate").on("change",function(){
	
	//alert("vv");
	var startDate = new Date($("#gtstartdate").val());
	var lastDate = new Date($("#gtdate").val());
	
	//alert(startDate);
	if(startDate > lastDate)
	{
		alert("Please select valid date");
		$(this).val('');
	}

});


});
</script>

<script>
$(document).ready(function(){
	 $("#nav03").addClass("active");
});	 
</script>

</body>
</html>
