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
<meta charset="utf-8">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>List of Tournament</title>
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
<link rel="stylesheet" href="css/jquery-confirm.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<br>
<div class="container-fluid"> <a href="tournament.php">
  <button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New Golf Tournament</button>
  </a> </div>
<div class="container-fluid"> <br>
  <?php

  $get2 = mysqli_query($conn,"SELECT * FROM tbgolftournament ORDER BY gtid desc");
  while($row2 = mysqli_fetch_array($get2))
  {
		$gtid = $row2['gtid'];
		$gtname = $row2['gtname'];
		$gtstartdate = $row2['gtstartdate'];
		$gtdate = $row2['gtdate'];
		$gttime = $row2['gttime'];
		
  
		$gtcourse = $row2['gtcourse'];
	
	
	
?>
  <div class="well" style=" background-image: linear-gradient(rgba(20,20,20, .5),rgba(20,20,20, .5)), url('images/tournament.jpg'); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-postion:fixed; ">
    <div class="row" >
      <div class="col-md-4" >
        <p class="text-white" style="font-size: 25px; margin-top:10px;"><strong><?php echo $gtname; ?></strong></p>
        <h3 class="text-white "><i class="material-icons" style="font-size: 18px;">av_timer</i> <?php echo date('h:i a',strtotime($gttime)); ?></h3>
        <h4 class="text-white"><i class="material-icons" style="font-size: 15px;">golf_course</i> <?php echo $gtcourse; ?> </h4>
        <h4 class="text-white"><i class="material-icons" style="font-size: 15px;">date_range</i> Last Registration Date: <?php echo date('d  F Y' ,strtotime($gtstartdate)); ?></h4>
        <h4 class="text-white"><i class="material-icons" style="font-size: 15px;">date_range</i> Match Day: <?php echo date('d  F Y' ,strtotime($gtdate)); ?></h4>
      </div>
      <div class="col-md-8" >
        <h3 class="text-white">All Golf Players</h3>
        <div class="row">
          <?php $gtmember = json_decode(($row2['gtmember']));?>
          <?php 
           
			$index= 1;
            foreach($gtmember as $value)
			
								{
								      $get3 = mysqli_query($conn,"SELECT * FROM tbgolfmember WHERE gmid='$value' ORDER BY gmfullname ");
  while($row3 = mysqli_fetch_array($get3))
  {
		$gmfullname = $row3['gmfullname'];
									
									?>
          <div class="col-md-4 text-white">
            <p style="font-size: 17px;"><?php echo  ($index++) . ". " .$gmfullname;?></p>
          </div>
          <?php } }?>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-6"> <a href="tournamentupdate.php?gtid=<?php echo $gtid; ?>" >
        <button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Edit Golf Tournaament</button>
        </a> </div>
      <div class="col-md-6">
        <button value="delete" class="btn btn-danger" onClick="delete_row('<?php echo $gtid;?>')"><span class="glyphicon glyphicon-trash"></span> Delete Golf Tournament</button>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
</div>
</div>
<br>
<br>
<?php include("includes/footer.php"); ?>

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
               url: 'tournamentdelete.php',
               data: ({ id: id }),
               success: function(response) {
                alert(response);
               if(response == "1" || response == 1 )
               {
                 successAlert("Tournament was removed.");
                 setTimeout(function(){
                   window.location.href='viewgolftournament.php';
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

<script>
$(document).ready(function(){
	 $("#nav03").addClass("active");
});	 
</script>

</body>
<style>
.row{
	padding:20px;
}
</style>
</html>
