
<?php
include "connect.php";
$sqlTour = mysqli_query($conn, "SELECT * FROM tbgolftournament ");

$allTourArray = array();

while ($ansTour = mysqli_fetch_array($sqlTour)) {
    $tournament       = new stdClass();
    $tournament->id = $ansTour['gtid'];
    $tournament->name = $ansTour['gtname'];
    $tournament->date = $ansTour['gtdate'];
    $tournament->reglast = $ansTour['gtstartdate'];
    $tournament->time = $ansTour['gttime'];

    $sqlCourse = mysqli_query($conn, "SELECT * FROM tbgolfcourse WHERE gcfullname='" . $ansTour['gtcourse'] . "'");
    $course    = new stdClass();
    if ($ansCourse = mysqli_fetch_array($sqlCourse)) {
        $course->name        = $ansCourse['gcfullname'];
        $course->sname       = $ansCourse['gcshortname'];
        $course->description = $ansCourse['description'];
        $course->city        = $ansCourse['city'];
        $holes               = json_decode($ansCourse['holes']);
        $strindex               = json_decode($ansCourse['strokeindex']);

        $holesArray = array();
        for($i =0 ; $i < count($holes) ; $i++)
        {
            $holeInfo = new stdClass();
            $holeInfo->par = $holes[$i];
            $holeInfo->strin = $strindex[$i];
            $holesArray[] = $holeInfo;
        }
        $course->holes = $holesArray;
    }
    $tournament->course = $course;

    $members     = json_decode($ansTour['gtmember']);
    $memberArray = array();
    foreach ($members as $member) {
        $flag = false;
        $memQuery = mysqli_query($conn, "SELECT * FROM tbgolfmember WHERE gmid = " . $member);
        $member   = new stdClass();
        while ($memberfound = mysqli_fetch_array($memQuery)) {
            $member->id      = $memberfound['gmid'];
            $member->name      = $memberfound['gmfullname'];
            $member->shortname = $memberfound['gmshortname'];
            $member->handicap  = $memberfound['handicap'];
            $flag = true;
        }
        if($flag)
            $memberArray[] = $member;
    }
    $tournament->members = $memberArray;

    $allTourArray[] = $tournament;
}

echo json_encode($allTourArray);
?>
