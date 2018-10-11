<html>
<head>

<?php
 //error_reporting( ~E_NOTICE ); // avoid notice
 require 'connect.php';
 include 'link-js.php';
 include 'link-css.php';
  $name = ''; $type = ''; $size = ''; $error = '';

 ?>
</html>
</head>
 
 <?php

 error_reporting(0);
 function compress_image($source_url, $destination_url, $quality) {

  $info = getimagesize($source_url); 

  if ($info['mime'] == 'image/jpeg')
    $image = imagecreatefromjpeg($source_url);

  else if ($info['mime'] == 'image/gif')
    $image = imagecreatefromgif($source_url);

  else if ($info['mime'] == 'image/png')
    $image = imagecreatefrompng($source_url);

  imagejpeg($image, $destination_url, $quality);
  return $destination_url;
}
 
 
 
 if(isset($_POST['btnsave']))
 {
  $gmfullname = $_POST['gmfullname'];
  $gmshortname = strtoupper($_POST['gmshortname']);
  $image = $_FILES['gmpp']['name'];
  $city = $_POST['city'];
  $area = $_POST['area'];
  $handicap = $_POST['handicap'];


  $url = 'images/' . $image;
  $filename = compress_image($_FILES["gmpp"]["tmp_name"], $url, 50);
  
  
  
   $query = "INSERT INTO tbgolfmember(gmfullname,gmshortname,gmpp,city,area,handicap)VALUES('$gmfullname', '$gmshortname', '$image', '$city' , '$area' ,'$handicap')";
    

	mysqli_query($conn,$query);
   
 
?>
<script type="text/javascript">
      successAlert("Member Added");
    setTimeout(function(){
     window.location.href='golfmember.php';
   }, 1000);
 </script>
 <?php
}
else 
{
  ?>
  <script type="text/javascript">
    errorAlert("Member Not Added ");
    setTimeout(function(){
     window.location.href='golfcourseadd.php';
   }, 1000);
 </script>
 <?php
 }
?>
