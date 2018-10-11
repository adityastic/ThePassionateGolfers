<html>
<head>

<?php

require 'connect.php';
include 'link-js.php';
include 'link-css.php';

?>
</html>
</head>

 <?php
if (isset($_POST['btnsave'])) {
    $gtname = $_POST['gtname'];
	$gtstartdate = $_POST['gtstartdate'];
    $gtdate = $_POST['gtdate'];
    $gttime = $_POST['gttime'];

    $gtcourse = $_POST['gtcourse'];

    $gtmember1 = $_POST['gtmember'];
    $gtmember  = json_encode($gtmember1);

    $query = "INSERT INTO tbgolftournament(gtname,gtstartdate,gtdate,gttime,gtmember,gtcourse)VALUES('$gtname', '$gtstartdate', '$gtdate', '$gttime', '$gtmember' , '$gtcourse')";

    mysqli_query($conn, $query);
    ?>
<script type="text/javascript">
      successAlert("Tournament Was Created.");
    setTimeout(function(){
     window.location.href='viewgolftournament.php';
   }, 1000);
 </script>
 <?php
} else {
    ?>
  <script type="text/javascript">
    errorAlert("Oops something went wrong please try again later.");
    setTimeout(function(){
     window.location.href='tournament.php';
   }, 1000);
 </script>
 <?php
}

?>
