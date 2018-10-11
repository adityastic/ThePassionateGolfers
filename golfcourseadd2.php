<html>
<head>

<?php
 //error_reporting( ~E_NOTICE ); // avoid notice
 require 'connect.php';
 include 'link-js.php';
 include 'link-css.php';
 
 $name = ''; $type = ''; $size = ''; $error = '';
 
/* print_r($_POST);
 exit();*/
 ?>
</html>
</head>
 
 <?php
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
 
 
 
if(isset($_POST['btnsave']))
 {
  $gcfullname = $_POST['gcfullname'];
  $gcshortname = $_POST['gcshortname'];
  
  $a = $_POST['gcimage'];
  $image =  substr($a,49);
  $description = $_POST['description'];

  $city = $_POST['city'];
  
	$holes1 = $_POST['holes'];
	$holes = json_encode($holes1);
	
	$strokeindex1 = $_POST['strokeindex'];
	$strokeindex = json_encode($strokeindex1);
	
  
  

  
  $query = "INSERT INTO tbgolfcourse(gcfullname,gcshortname,gcimage,description,city,holes,strokeindex)VALUES('$gcfullname', '$gcshortname', '$image' , '$description' ,'$city' , '$holes', '$strokeindex'  )";
    

	mysqli_query($conn,$query);
   
 
?>
<script type="text/javascript">
      successAlert("  Uploaded ");
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
    errorAlert(" Not Uploaded ");
    setTimeout(function(){
     window.location.href='golfcourseadd.php';
   }, 1000);
 </script>
 <?php
}




?>
