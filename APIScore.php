<?php

include "connect.php";

$incJSON     = file_get_contents("php://input");
$sqlPrevJSON = mysqli_query($conn, "SELECT * FROM tbgolftournament WHERE gtid=" . $_GET['id'] . "");
$prevJSON    = '[]';
if ($ansCourse = mysqli_fetch_array($sqlPrevJSON)) {
    $prevJSON = $ansCourse['scoreboard'];
}

$prevJSONArr = json_decode($prevJSON);
$incJSONArr  = json_decode($incJSON);

$indextoDelete = array();

for ($i = 0; $i < count($incJSONArr); $i++) {
    for ($j = 0; $j < count($prevJSONArr); $j++) {
        if (key((array) $prevJSONArr[$j]) == key((array) $incJSONArr[$i])) {
            break;
        }
    }
    if ($j < count($prevJSONArr)) {
        unset($prevJSONArr[$j]);
        $reindex         = array_values($prevJSONArr);
        $prevJSONArr     = $reindex;
        $prevJSONArr[]   = $incJSONArr[$i];
        $indextoDelete[] = key($incJSONArr[$i]);
    }
}

foreach ($indextoDelete as $key) {
    for ($i = 0; $i < count($incJSONArr); $i++) {
        if (key($incJSONArr[$i]) == $key) {
            unset($incJSONArr[$i]);
            $reindex    = array_values($incJSONArr);
            $incJSONArr = $reindex;
        }
    }
}

for ($i = 0; $i < count($incJSONArr); $i++) {
    $prevJSONArr[] = $incJSONArr[$i];
}

$id = $_GET["id"];

$query   = "UPDATE tbgolftournament SET scoreboard='" . json_encode($prevJSONArr) . "' where gtid=" . $id;
$sqlTour = mysqli_query($conn, $query);
if ($sqlTour) {
    echo "done";
} else {
    echo "nai hua";
}
