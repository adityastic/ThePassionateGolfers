<?php
session_start();
// Include config file
require 'connect.php';
 
// Define variables and initialize with empty values
$mobileno = $password = "";
$mobileno_err = $password_err = "";
$login_err = "";
$apkDN = "";
 //print_r($_POST);
 
// Processing form data when form is submitted
if(isset($_POST['butn'])) {
	$apkDN = "After TPG.apk is downloaded, check 'Download' folder in your device. Tap on TPG.apk to install it.";
}else 
if(isset($_POST['submit'])) { //($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["mobileno"]))){
        $mobileno_err = 'Please enter the valid Admin User ID and Password'; //'Please enter mobile no.';
		$login_err = $mobileno_err;
    } else{
        $mobileno = trim($_POST["mobileno"]);
    }
	
	if (empty(trim($_POST['password']))){
        $password_err = 'Please enter the valid Admin User ID and Password'; //'Please enter your password.';
		$login_err = $password_err;
    } else{
        $password = trim($_POST['password']);
    }

    $_SESSION['mobileno'] = $mobileno;  
                                
                            //header("location:golfmember.php");
                            echo"<script>window.location='golfmember.php';</script>";
    // Validate credentials
    // if(empty($mobileno_err) && empty($password_err)){
    //     // Prepare a select statement
    //     $sql = "SELECT mobileno, password FROM tbadmin WHERE mobileno = ?";
    //     //echo"<br>".$sql;
		
    //     if($stmt = mysqli_prepare($conn, $sql)){
    //         // Bind variables to the prepared statement as parameters
    //         mysqli_stmt_bind_param($stmt, "s", $param_mobileno);
            
    //         // Set parameters
    //         $param_mobileno = $mobileno;
            
    //         // Attempt to execute the prepared statement
    //         if(mysqli_stmt_execute($stmt)){
    //             // Store result
    //             mysqli_stmt_store_result($stmt);
                
    //             // Check if username exists, if yes then verify password
    //             if(mysqli_stmt_num_rows($stmt) == 1){                    
    //                 // Bind result variables
    //                 mysqli_stmt_bind_result($stmt, $mobileno, $hashed_password);
    //                 if(mysqli_stmt_fetch($stmt)){
				// 		//echo"<br>{$password}, {$hashed_password} ".password_verify($password, $hashed_password);
    //                     if(password_verify($password, $hashed_password)){
    //                         /* Password is correct, so start a new session and
    //                         save the username to the session */
                            
                            
    //                     } else{
    //                         // Display an error message if password is not valid
    //                         $password_err = 'The admin password you entered was not valid.';
				// 			$login_err = $password_err;
    //                     }
    //                 }
    //             } else{
    //                 // Display an error message if username doesn't exist
    //                 $mobileno_err = 'No admin account found with that mobile no.';
				// 	$login_err = $mobileno_err;
    //             }
    //         } else{
    //             $login_err = "Oops! Something went wrong. Please try again later.";
    //         }
    //     }
        
        // Close statement
        mysqli_stmt_close($stmt);
    
    
    // Close connection
    mysqli_close($conn);
}
?>




<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<title>The Passionate Golfers</title>
	<meta charset="utf-8" />
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
	<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
	<link rel="stylesheet" href="css/bootstrap.css" >
	<link rel="stylesheet" href="css/style.css" >
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>

<body class="loginbg">
<div class="container">
<div class="row">
<!--<div class="col-md-3"></div>-->
<div class="well col-md-6 col-md-push-3">
<fieldset>
<center>
<h2 class="text-white"><i class="material-icons" style="font-size: 25px;">golf_course</i> The Passionate Golfers</h2>
<br>
<div class="loginform11">
			<div class="col-md-8 col-md-push-2">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off"  >
       
			<input type="text" name="mobileno" id="mobno" placeholder="Enter User ID" 11required class="form-control" autocomplete="off" /><br>
            
			
            <input type="password" name="password" id="password" placeholder="Enter password" 11required class="form-control" autocomplete="off" /><br>
				
            


  
                <button name="submit" type="submit" class=" btn background border text-white form-control">Sign In</button>
   
				<br><br>
				 
				<button name="butn" id="butnApkDn"  class=" btn border btn-primary form-control">Download The APK </button><!--onClick="window.open('TPG.apk');"-->
				<!--<span style="font-size:11px;color:#FFF;"> After TPG.apk is downloaded, check 'Download' folder in your device. Tap on TPG.apk to install it.</span>-->
				

            
        </form>
		</div>
		<div class="col-md-12 text-center"> <br>
			<?php
			if(!empty($login_err)) {
				echo"<div class='alert alert-danger'><strong>{$login_err}</strong></div>";
			} else if(!empty($apkDN)) {
				echo"<div class='alert alert-success'><strong>{$apkDN}</strong></div>";
			}
			
			?>
		</div>
</div></center>
		<!--<center>
		<h4 class="text-danger"><?php //echo $login_err; //$password_err; ?></h4>
		</center>-->
    
</fieldset>
</div>
<div class="col-md-3"></div>
</div>
</div>
</body>
<style>
.well{
background: rgba(0, 0, 0, .5);

}
.row{
	margin-top:150px;
}
.loginform{
	padding-left:100px;
	padding-right:100px;
}
</style>
<!-- Mirrored from demo.themepixels.com/webpage/shamcey/index.html by HTTrack Website Copier/3.x [XR&CO'2013], Mon, 30 Dec 2013 02:51:10 GMT -->

<script>
$("#butnApkDn").click(function(e){
	window.open('TPG.apk');
	//window.open('TPG Testing.apk');
	alert("After TPG.apk is downloaded, check 'Download' folder in your device. Tap on TPG.apk to install it.");
	//e.preventDefault();
});
</script>
</html>
