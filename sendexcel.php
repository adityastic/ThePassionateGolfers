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
<meta charset="utf-8">
<title>Send Excel Sheet</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- REQUIRED CSS -->
<?php include 'link-css.php';?>
<!-- // REQUIRED CSS -->
<link rel="stylesheet" href="css/jquery-confirm.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<br>
<div class="container">
  <div class="table-responsive">
    <div class="row">
      <div class="col-md-12">
        <center>
          <h2 class="text-success"><b>List of Golf Tournament</b></h2>
          <form class="form-inline" role="form">
            <div class=" form-group has-success has-feedback">
              <label class="control-label" for="inputSuccess4"></label>
              <input type="text" class="form-control" id="myInput" placeholder="Search Tournament">
              <span class="glyphicon glyphicon-search form-control-feedback"></span> </div>
          </form>
        </center>
      </div>
    </div>
    <table class="table table-hover">
      <tr>
        <th class="text-success"> Tournament Name </th>
        <th class="text-success"> Email </th>
        <th class="text-success"> Action </th>
      </tr>
      <?php

include 'connect.php';

$sqlJSON = mysqli_query($conn, "SELECT * FROM tbgolftournament");
while($sqlAns = mysqli_fetch_array($sqlJSON))
{
	//echo "<form method='POST' action='ExcelGeneration/excel.php?id={$sqlAns['gtid']}'>";
	echo "<form name='frmSendExcel{$sqlAns['gtid']}' method='GET' action='ExcelGeneration/excel.php'>";
	echo '<tr class="info myList">';
	echo '<td>';
	echo $sqlAns['gtname'];
	echo '</td>';
	echo '<td>';
	echo "<input type='text' name='emailTo' id='emailTo' required pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$' />";
	echo "<input type='hidden' name='id' id='id' value='{$sqlAns['gtid']}' />";
	echo '</td>';
	echo '<td>';
	//echo '<form method="POST" action="/ExcelGeneration/excel.php?id=' . $sqlAns['gtid'] . '"><input type="submit" value="Generate and Send	 Excel" class="btn btn-primary"></form>';
	echo"<input type='submit' value='Generate and Send	 Excel' class='btn btn-primary'>";
	echo '</td>';
	echo '</tr>';
	echo"</form>";
}

?>
    </table>
  </div>
</div>
<br>
<br>
<?php include("includes/footer.php"); ?>

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
	 $("#nav04").addClass("active");
});	 
</script>

<style>
.footer{
	position: fixed;
    left: 0;
    bottom: 0;
}
</style>
</html>
