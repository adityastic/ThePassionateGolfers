<?php  
$runon=0;
global $conn;
if($runon)
{
	$test =0;
	$servername = "localhost";
	$username = "root";
	$password = "";
	
	if($test)
	{
		$dbname = "proj_golf_test";
		//$username = "amplify";
	}
	else
	{
		$dbname = "proj_golf";
	}
	
	
	//$baseurl = "http://geekyinfotech.com.preview.services/";
	// Attempt to connect to MySQL database
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if($conn === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
}
else
{
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "geekyinf_tpg";
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if (!$conn) { 
		die('Could not connect: ' . mysql_error()); 
	} 
}
?>