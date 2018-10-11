<?php

include 'connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$id = $_POST['id'];


	$query_update = mysqli_query($conn,"DELETE FROM tbgolftournament WHERE gtid='$id'");

	echo "1"; 				
}

?>