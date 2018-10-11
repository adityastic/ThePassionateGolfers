<html>
<head>
  <?php
  include 'link-css.php';
  include 'link-js.php';

  ?>
</head>
</html>
<?php
include 'connect.php';

//print_r($_POST);



if(isset($_POST['btnUpdate']))
 {
	 
	$gtid = $_POST['gtid'];
  $gtname = $_POST['gtname'];
  $gtdate = $_POST['gtdate'];
  $gttime = $_POST['gttime'];
  
  
  
  
	$holes1 = $_POST['gtmember'];
	$holes = json_encode($holes1);
	
	$gtcourse = $_POST['gtcourse'];
 

 $query = "UPDATE tbgolftournament SET gtname = '$gtname' ,gtdate = '$gtdate' , gttime = '$gttime', gtmember = '$holes', gtcourse = '$gtcourse'  where gtid='$gtid' ";

	//echo"<br>".$query; 
 mysqli_query($conn,$query);



  ?>
  <script type="text/javascript">
    successAlert("Golf Tournament Updated");
    setTimeout(function(){
     window.location.href='viewgolftournament.php';
   }, 1000);
 </script>
 <?php
}

 
else 
{
  ?>
  <script type="text/javascript">
    successAlert("Oops something went wrong please try again later.");
    setTimeout(function(){
     window.location.href='viewgolftournament.php';
   }, 1000);
 </script>

  <?php
}
?>