<html>
<head>
  <?php
  include 'link-css.php';
  include 'link-js.php';
  
 
  ?>
</head>
</html>
<?php
//error_reporting(0);
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
	 
	$gmid = $_POST['gmid'];
	$gmfullname = $_POST['gmfullname'];
	$gmshortname = strtoupper($_POST['gmshortname']);
	$city = $_POST['city'];
	$area = $_POST['area'];
	$handicap = $_POST['handicap'];
	 $image = $_FILES['gmpp']['name'];
  
  
   $query = mysqli_query($conn,"select gmpp from tbgolfmember where gmid = '$gmid' ") ;
   while($row2 = mysqli_fetch_array($query))
   {
	   $image1 = $row2['gmpp'];
	   
	   
   }


 if($image == '')
  {
	$query = "UPDATE tbgolfmember SET gmfullname = '$gmfullname' ,gmshortname = '$gmshortname' ,gmpp = '$image1' ,city = '$city' , area = '$area',handicap = '$handicap' where gmid='$gmid' ";  
  }
  
  else if ($image != '')  {	  
	$query = "UPDATE tbgolfmember SET gmfullname = '$gmfullname' ,gmshortname = '$gmshortname' ,gmpp = '$image' ,city = '$city' , area = '$area',handicap = '$handicap' where gmid='$gmid' ";	  
  }
 
 $a = mysqli_query($conn,$query);
  //$a = 1;

  if ($a==1){


  ?>
  <script type="text/javascript">
    successAlert("Member Detail Updated");
    setTimeout(function(){
     window.location.href='viewgolfmember.php';
   }, 1000);
 </script>
 <?php
}

else {
  ?>
  <script type="text/javascript">
    successAlert("Oops something went wrong please try again later");
    setTimeout(function(){
     window.location.href='viewgolfmember.php';
   }, 1000);
 </script>

  <?php
}
 }
?>