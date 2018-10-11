<?php
session_start();

include "connect.php";
// Initialize the session
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['mobileno']) || empty($_SESSION['mobileno'])){
  header("location: index.php");
  exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
<title>Reset Leaderboard</title>
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
    <!--<div class="row">
      <div class="col-md-12 text-center"> 
          <h2 class="text-success"><b>Reset Leaderboard</b></h2> 
      </div>
    </div>-->
	
	<div class="row">
		<div class="col-md-8 col-md-push-2">
    		<form name="frmResetTournament" id="frmResetTournament" method="post" action="#">
			  <?php
				
				include 'connect.php';
				
				//$opt_gtname = "<option value=''>Select Tournament Name</option>";
				//$opt_gtname = "<option value='{$sqlAns['gtid']}'>{$sqlAns['gtname']}</option>";
				
				$sqlJSON = mysqli_query($conn, "SELECT * FROM tbgolftournament where gtdate>=CURDATE() order by gtstartdate DESC LIMIT 0,1 ");
				$sqlAns = mysqli_fetch_array($sqlJSON);
				//echo $sqlAns['gtname']." Date:".$sqlAns['gtdate'];
				
				
				echo"<div class='panel panel-success'>";
					echo"<div class='panel-heading text-center'><h2>Current active Tournament</h2></div>";
					echo"<div class='panel-body'>";
						if(!empty($sqlAns['gtname']))
						{
							//echo"Tournament Name: {$sqlAns['scoreboard']}";
							echo"<h3>Tournament Name: {$sqlAns['gtname']} </h3> <div class='1text-right'><h4>Date: ".date("d M Y", strtotime($sqlAns['gtdate']))." </h4></div>";
							echo"<input type='hidden' name='gtid'	id='gtid' value='{$sqlAns['gtid']}' />";
							echo"<div class='text-center'><button type='submit' name='btnResetTournament' id='btnResetTournament' class='btn btn-info' value='Reset Leaderboard' >Reset Leaderboard</button></div>";
						}
						else
						{
							echo"<h4>Currently no active tournament found.....</h4>";
						}						
						
					echo"</div>";		
				echo"</div>";
				
				
				/*{
					
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
				}*/
		
				?>
			</form>
			
			
			<?php
	
				//print_r($_POST);
				
				if(isset($_POST['gtid']))
				{
					$gtid = $_POST['gtid'];
					$query = "UPDATE tbgolftournament SET scoreboard=''  WHERE gtid='{$gtid}' ";
					//echo"<br>".$query;
					$query_update = mysqli_query($conn,$query);
					if($query_update)
					{
						echo"<div class='alert alert-success'><strong>Leaderboard has been resetted successfully...</strong></div>";
					}
					else
					{
						echo"<div class='alert alert-danger'><strong>Error: Leaderboard has not been resetted this time, Please try again later..</strong></div>";
					}
					
				}
			
			?>
		</div>
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
	 $("#nav06").addClass("active");
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
