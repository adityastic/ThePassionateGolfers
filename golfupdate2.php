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

$name = ''; $type = ''; $size = ''; $error = '';
function compress_image($source_url, $destination_url, $quality) {

  $info = getimagesize($source_url); 

  if ($info['mime'] == 'image/jpeg')
    $image = imagecreatefromjpeg($source_url);

  elseif ($info['mime'] == 'image/gif')
    $image = imagecreatefromgif($source_url);

  elseif ($info['mime'] == 'image/png')
    $image = imagecreatefrompng($source_url);

  imagejpeg($image, $destination_url, $quality);
  return $destination_url;
}


if(isset($_POST['btnUpdate']))
 {
	 
	$gcid = $_POST['gcid'];
  $gcfullname = $_POST['gcfullname'];
  $gcshortname = $_POST['gcshortname'];
  
  
  $description = $_POST['description'];

  $city = $_POST['city'];
  
	$holes1 = $_POST['holes'];
	$holes = json_encode($holes1);
	
	$strokeindex1 = $_POST['strokeindex'];
	$strokeindex = json_encode($strokeindex1);
	
	$image = $_POST['gcimage'];
	
	$query = mysqli_query($conn,"select gcimage from tbgolfcourse where gcid = '$gcid' ") ;
   while($row2 = mysqli_fetch_array($query))
   {
	   $image1 = $row2['gcimage'];
	   
	   
   }
	
	
 

  if($image == '')
  {
  
 $query = "UPDATE tbgolfcourse SET gcfullname = '$gcfullname' ,gcshortname = '$gcshortname' ,gcimage = '$image1' ,description = '$description',city = '$city',holes = '$holes',strokeindex = '$strokeindex' where gcid='$gcid' ";
  }
  
  else if ($image != '')  {
	  
		 $query = "UPDATE tbgolfcourse SET gcfullname = '$gcfullname' ,gcshortname = '$gcshortname' ,gcimage = '$image' ,description = '$description',city = '$city',holes = '$holes',strokeindex = '$strokeindex' where gcid='$gcid' ";

	  
  }
 
 mysqli_query($conn,$query);



  ?>
  <script type="text/javascript">
    successAlert("Golf Course Detail Updated");
    setTimeout(function(){
     window.location.href='viewgolfcourse.php';
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
     window.location.href='viewgolfcourse.php';
   }, 1000);
 </script>

  <?php
}
?>