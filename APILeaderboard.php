
<?php
include "connect.php";
$id = $_GET["id"];
$sqlJSON = mysqli_query($conn, "SELECT * FROM tbgolftournament WHERE gtid=" . $id . "");
$scoreboard = '';
if($ansCourse = mysqli_fetch_array($sqlJSON))
{
	$scoreboard = json_decode($ansCourse['scoreboard']);
}

$allscorearray = array();

for ($i = 0; $i < count($scoreboard); $i++) {
    $flag = false;
    $memberInfo       = new stdClass();
    $memberInfo->shortname = key($scoreboard[$i]);
	$memberInfo->score = current($scoreboard[$i]);

	$memQuery = mysqli_query($conn, "SELECT * FROM tbgolfmember WHERE gmshortname = '" . $memberInfo->shortname . "'");
    if($memberfound = mysqli_fetch_array($memQuery))
    {
    	$memberInfo->name = $memberfound['gmfullname'];
    	$flag = true;
    }

    if($flag)
        $allscorearray[] = $memberInfo;
        
}
echo json_encode($allscorearray);
?>
