
<?php
// Include config file
require 'connect.php';
 
// Define variables and initialize with empty values
$mobileno = $password = "";
$mobileno_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["mobileno"]))){
        $mobileno_err = 'Please enter mobile no.';
    } else{
        $mobileno = trim($_POST["mobileno"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($mobileno_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT mobileno, password FROM tbadmin WHERE mobileno = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_mobileno);
            
            // Set parameters
            $param_mobileno = $mobileno;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $mobileno, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['mobileno'] = $mobileno;      
                            header("location:golfmember.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $mobileno_err = 'No account found with that mobile no.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
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
<div class="col-md-3"></div>
<div class="well col-md-6">
<fieldset>
<center>
<h2 class="text-white"><i class="material-icons" style="font-size: 25px;">golf_course</i> The Passionate Golfers</h2>
<br>
<div class="loginform">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
       
			<input type="text" name="mobileno" id="mobno" placeholder="Enter User ID" class="form-control"/><br>
            
			
            <input type="password" name="password" id="password" placeholder="Enter password" class="form-control"/><br>
				
            


  
                <button name="submit" class=" btn background border text-white form-control">Sign In</button>
   


            
        
        <br>
                <button name="butn" onClick="window.open('../TPG.apk')" class=" btn border btn-primary form-control">Get The APK</button>
</div></center>
			</form>
		<center>
		<h4 class="text-danger"><?php echo $password_err; ?></h4>
		</center>
    
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
</html>
