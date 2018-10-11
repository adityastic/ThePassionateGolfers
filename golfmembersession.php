<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['mobileno']) || empty($_SESSION['mobileno'])){
  header("location: index.php");
  exit;
}
?>
<?php
// Include config file
require_once 'connect.php';
 
// Define variables and initialize with empty values
$gmfullname = $gmshortname = $city = $area = $handicap = "";
$gmfullname_err = $gmshortname_err = $city_err = $area_err = $handicap_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_gmfullname = trim($_POST["gmfullname"]);
    if(empty($input_gmfullname)){
        $gmfullname_err = "Please enter a full name.";
    } elseif(!filter_var(trim($_POST["gmfullname"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $gmfullname_err = 'Please enter a valid name.';
    } else{
        $gmfullname = $input_gmfullname;
    }
    
    
    $input_gmshortname = trim($_POST["gmshortname"]);
    if(empty($input_gmshortname)){
        $gmshortname_err = 'Please enter a short name.';     
    } else{
        $gmshortname = $input_gmshortname;
    }
	
	 $input_city = trim($_POST["city"]);
    if(empty($input_city)){
        $city_err = 'Please enter a city.';     
    } else{
        $city = $input_city;
    }
	
	 $input_area = trim($_POST["area"]);
    if(empty($input_area)){
        $area_err = 'Please enter a area.';     
    } else{
        $area = $input_area;
    }
	
	
    
    // Validate handicap
    $input_handicap = trim($_POST["handicap"]);
    if(empty($input_handicap)){
        $handicap_err = "Please enter the handicap number.";     
    } elseif(!ctype_digit($input_handicap)){
        $handicap_err = 'Please enter a positive integer value.';
    } else{
        $handicap = $input_handicap;
    }
    
    // Check input errors before inserting in database
    if(empty($gmfullname_err) && empty($gmshortname_err) && empty($city_err) && empty($area_err) && empty($handicap_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO tbgolfmember (gmfullname, gmshortname, city, area ,handicap) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_gmfullname, $param_gmshortname, $param_city , $param_area , $param_handicap);
            
            // Set parameters
            $param_gmfullname = $gmfullname;
            $param_gmshortname = $gmshortname;
            $param_city = $city;
			$param_area =$area;
			$param_handicap = $handicap;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				
				
                // Records created successfully. Redirect to landing page
                header("location: viewmembers.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
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

<!-- Mirrored from demo.themepixels.com/webpage/shamcey/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2013], Mon, 30 Dec 2013 02:49:10 GMT -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Register Golf Member</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />

<link rel="stylesheet" href="css/responsive-tables.css">
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="js/responsive-tables.js"></script>
<script type="text/javascript" src="js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
            "sScrollY": "300px"
        });
        
    });
</script>
</head>

<body>

<div id="mainwrapper" class="mainwrapper">
    
    <div class="header">
        <div class="logo">
            <a href="gm.html"><h3 style="color: white;">The Passionate Golfers</h3></a>
        </div>
        <div class="headerinner">
            <ul class="headmenu">
                <li class="right">
                    <div class="userloggedinfo">
                        <img src="images/admin.png" alt="" />
                        <div class="userinfo">
                            <h5>Admin<small>- admin@admin.com</small></h5>
                            <ul>
                                <li><a href="logout.php">Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul><!--headmenu-->
        </div>
    </div>
    
    <div class="leftpanel">
        
        <div class="leftmenu">        
            <ul class="nav nav-tabs nav-stacked">
            	<li class="nav-header">Navigation</li>
                <li class="active"><a href="golfmember.php"><span class="iconfa-user"></span>Golf Members</a></li>
				<li><a href="golfcourse.php"><span class="iconfa-flag-alt"></span>Golf Course</a></li>
				<li><a href="golftournament.php"><span class="iconfa-calendar"></span>Create Golf Tournament</a></li>
				<li><a href="emaillog.php"><span class="iconfa-list"></span>Email Logs</a></li>
            </ul>
        </div><!--leftmenu-->
        
    </div><!-- leftpanel -->
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="dashboard.html"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Golf Member</li>
            <li class="right">
            </li>
        </ul>
        
        <div class="pageheader">
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>Member Management</h5>
                <h1>Golf Member</h1>
            </div>
        </div><!--pageheader-->
        
                <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
			<a href="viewmembers.php" class="btn btn-primary">View Mebers</a>
			
            <h4 class="widgettitle">Register Memeber</h4>
            <div class="widgetcontent">
                    <form class="stdform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="par control-group">
                                    <label class="control-label" for="fullname">Full Name</label>
                                <div class="controls"><input type="text" name="gmfullname"  id="gmfullname" class="input-xxlarge" /></div>
                            </div>
                            
                            <div class="par control-group">
                                    <label class="control-label" for="shortname">Short Name</label>
                                <div class="controls"><input type="text" name="gmshortname"  id="gmshortname" class="input-xxlarge" /></div>
                            </div>
                            
							
							<div class="par control-group">
                                    <label class="control-label" for="city">City</label>
                                <div class="controls"><input type="text" name="city" id="city"  class="input-xxlarge" /></div>
                            </div>
							
							<div class="par control-group">
                                    <label class="control-label" for="area">Area</label>
                                <div class="controls"><input type="text" name="area" id="area"  class="input-xxlarge" /></div>
                            </div>
							
							<div class="par control-group">
                                    <label class="control-label" for="handicap">Handicap</label>
                                <div class="controls"><input type="number" name="handicap" id="handicap"  class="input-xxlarge" /></div>
                            </div>
                                                    
                            <p class="stdformbutton">
                                    <input type="submit" value="Register Member" name="Submit" id="submit" class="btn btn-primary" />
									<input type="reset" name="reset" value="Reset" class="btn btn-danger" />
                            </p>
                    </form>
					
					
       <div class="footer">
                    <div class="footer-left">
                        <span>&copy; 2018. Admin Panel. All Rights Reserved.</span>
                    </div>
                    <div class="footer-right">
                        <span>Designed by: <a href="http://www.amplifymind.com/">Amplify Mindware</a></span>
                    </div>
                </div><!--footer-->
                
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
    
</div><!--mainwrapper-->

</body>
</html>
