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
<title>List of Golf Member</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
<link rel="stylesheet" href="css/bootstrap.css" >
<link rel="stylesheet" href="css/style.css" >
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- REQUIRED CSS -->
<?php include 'link-css.php'; ?>
<!-- // REQUIRED CSS -->
<link rel="stylesheet" href="css/jquery-confirm.css">
</head>
<body>
<?php include("includes/header.php"); ?>
<br>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8" style="margin-top:5px;"> <a href="golfmember.php">
      <button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New Golf Member</button>
      </a> </div>
    <div class="col-md-4">
      <form class="form-inline" role="form">
        <div class=" form-group has-success has-feedback">
          <label class="control-label" for="inputSuccess4"></label>
          <input type="text" class="form-control" id="myInput" placeholder="Search">
          <span class="glyphicon glyphicon-search form-control-feedback"></span> </div>
      </form>
    </div>
  </div>
</div>
<div class="container-fluid">
<br>
<?php

  $get2 = mysqli_query($conn,"SELECT * FROM tbgolfmember ORDER BY gmfullname");
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
<div class="col-md-4 well myList" style="">
  <div class="col-md-12 myList">
    <?php if($gmpp == ""){ ?>
    <div class="row ">
      <div class="col-md-3 "> <img src="images/aa.png" alt="Profile Picture" style=" width: 50px; height: 50px;"/> </div>
      <?php }else{ ?>
      <div class="row ">
        <div class="col-md-3"> <img src="images/<?php echo $gmpp; ?>" alt="Profile Picture" style=" width: 50px; height: 50px;"/> </div>
        <?php } ?>
        <div class="col-md-9 ">
          <p style="font-size: 18px;"><strong><?php echo $gmfullname; ?></strong> (<?php echo $gmshortname; ?>)</p>
          <div>
            <div class="row ">
              <div class="col-md-12" style="font-size: 13px; ">
                <p><i class="material-icons" style="font-size: 13px;">location_on</i> <?php echo $area; ?>,<?php echo $city; ?></p>
                <p>Member ID: <?php echo $gmid; ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" style=" font-size: 13px;">
                <p>Handicap: <?php echo $handicap; ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6" style="padding-top:15px;"> <a href="golfmemberupdate.php?gmid=<?php echo $gmid; ?>" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Edit Member </a> </div>
              <div class="col-md-6" style="padding-top:15px;">
                <button class="btn btn-danger" value="delete" onClick="delete_row('<?php echo $gmid;?>')"><span class="glyphicon glyphicon-trash"></span> Delete Member</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<br>
<br>
<br>
<br>
<?php include("includes/footer.php"); ?>

<!-- REQUIRED JS SCRIPTS -->
<?php include 'link-js.php'; ?>
<!-- // REQUIRED JS SCRIPTS -->
<!-- jAlert -->
<script src="js/jAlert.js"></script>
<script src="js/jAlert-functions.js"></script>
<script src="js/jquery-confirm.js"></script>
<link rel="stylesheet" href="css/jAlert.css">
<link rel="stylesheet" href="css/jquery-confirm.css">
<!-- jAlert -->
<script type="text/javascript">
  function delete_row(id)
{

      $.confirm({
        title: 'Confirmation!',
        content: 'Are you sure?',
        buttons: {
            confirm: function () {
                
               $.ajax({
               type: 'POST',
               url: 'golfmemberdelete.php',
               data: ({ id: id }),
               success: function(response) {
                alert(response);
               if(response == "1" || response == 1 )
               {
                 successAlert(" Deleted");
                 setTimeout(function(){
                   window.location.href='viewgolfmember.php';
                 }, 1000);
               }
               else
               {
                 errorAlert("Undefined Error!");
               }
               }
              });
            },
            cancel: function () {
                
            }
        }
    });

}
</script>
<style>
img {
    border-radius: 50%;
}
.well{
	background: white;
	border: 1px solid lightgrey;
	box-shadow: 5px 5px rgba(182, 182, 182, 0.75);
}
</style>
</body>
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
	 $("#nav01").addClass("active");
});	 
</script>
</html>
