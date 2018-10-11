<?php

include "connect.php";
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['mobileno']) || empty($_SESSION['mobileno'])) {
    header("location: index.php");
    exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>List of Golf Course</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- REQUIRED CSS -->
<?php include 'link-css.php';?>
<!-- // REQUIRED CSS -->
<link rel="stylesheet" href="css/jquery-confirm.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<br>
<div class="container-fluid"> <a href="golfcourseadd.php">
  <button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New Golf Course</button>
  </a> </div>
<div class="container-fluid"> <br>
  <?php

$get2 = mysqli_query($conn, "SELECT * FROM tbgolfcourse ORDER BY gcfullname");
while ($row2 = mysqli_fetch_array($get2)) {
    $gcid        = $row2['gcid'];
    $gcfullname  = $row2['gcfullname'];
    $gcshortname = $row2['gcshortname'];
    $gcimage     = $row2['gcimage'];
    $description = $row2['description'];
    $city        = $row2['city'];

    ?>
  <div class="well" style=" background-image: linear-gradient(rgba(20,20,20, .5),rgba(20,20,20, .5)), url('images/<?php echo $gcimage; ?>'); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-postion:fixed; ">
    <div class="row" >
      <div class="col-md-3" >
        <?php $holes = json_decode($row2['holes']);?>
        <p class="text-white" style="font-size: 20px; margin-top:10px;"><strong><?php echo $gcfullname; ?></strong> (<?php echo $gcshortname; ?>)</p>
        <h3 class="text-white "><i class="material-icons" style="font-size: 18px;">location_on</i> <?php echo $city; ?></h3>
        <h4 class="text-white"><i class="material-icons" style="font-size: 15px;">golf_course</i> <?php echo count(array_filter($holes)); ?> Holes</h4>
      </div>
      <div class="col-md-8">
        <p class="text-white" style="padding-top:15px; font-size:17px;" ><b><?php echo $description; ?></b></p>
        <br>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-6"> <a href="golfcourseupdate.php?gcid=<?php echo $gcid; ?>">
        <button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Edit Golf Course Details</button>
        </a> </div>
      <div class="col-md-6">
        <button class="btn  btn-danger" value="delete" onClick="delete_row('<?php echo $gcid; ?>')"><span class="glyphicon glyphicon-trash"></span> Delete Golf Course</button>
      </div>
    </div>
  </div>
  <?php }?>
</div>
<br>
<br>
<?php include("includes/footer.php"); ?>

<!-- REQUIRED JS SCRIPTS -->
<?php include 'link-js.php';?>
<!-- // REQUIRED JS SCRIPTS -->
<!-- jAlert -->
<script src="js/jAlert.js"></script>
<script src="js/jAlert-functions.js"></script>
<script src="js/jquery-confirm.js"></script>
<link rel="stylesheet" href="css/jAlert.css">
<link rel="stylesheet" href="css/jquery-confirm.css">
<!-- jAlert -->
<script type="text/javascript">
                function delete_row(id) {

                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure?',
                        buttons: {
                            confirm: function() {

                                $.ajax({
                                    type: 'POST',
                                    url: 'golfcoursedelete.php',
                                    data: ({
                                        id: id
                                    }),
                                    success: function(response) {
                                        alert(response);
                                        if (response == "1" || response == 1) {
                                            successAlert("Golf Course Deleted");
                                            setTimeout(function() {
                                                window.location.href = 'viewgolfcourse.php';
                                            }, 1000);
                                        } else {
                                            errorAlert("Undefined Error!");
                                        }
                                    }
                                });
                            },
                            cancel: function() {

                            }
                        }
                    });

                }
            </script>
<script>
$(document).ready(function(){
	 $("#nav02").addClass("active");
});	 
</script>
</body>
<style>
.row{
	padding:20px;
}
</style>
</html>
