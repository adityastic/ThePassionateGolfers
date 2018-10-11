<?php

include '../connect.php';

require 'vendor/autoload.php';
include '../mail.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$id         = $_GET["id"];
$sqlJSON    = mysqli_query($conn, "SELECT * FROM tbgolftournament WHERE gtid=" . $id . "");
$scoreboard = '';
$course     = '';
$tname       = '';

if ($ansCourse = mysqli_fetch_array($sqlJSON)) {
    $scoreboard = json_decode($ansCourse['scoreboard']);
    $course     = $ansCourse['gtcourse'];
    $tname       = $ansCourse['gtname'];
}

/** Load $inputFileName to a Spreadsheet Object  **/
$inputFileName = 'template.xlsx';
$spreadsheet   = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
$sheet         = $spreadsheet->getActiveSheet();

$sheet->setCellValue('B1', $tname);

//Par and Stroke LOGIC
$courseQuery = mysqli_query($conn, "SELECT * FROM tbgolfcourse WHERE gcfullname = '" . $course . "'");
if ($courseFound = mysqli_fetch_array($courseQuery)) {
    $holes = json_decode($courseFound['holes']);
    $strin = json_decode($courseFound['strokeindex']);

    $row     = 4;
    $coloumn = 68;
    foreach ($holes as $par) {
        $sheet->setCellValue(chr($coloumn++) . $row, $par);
    }

    $row     = 5;
    $coloumn = 68;
    foreach ($strin as $index) {
        $sheet->setCellValue(chr($coloumn++) . $row, $index);
    }

}

//Scoreboard LOGIC
$row = 7;
for ($i = 0; $i < count($scoreboard); $i++) {

    $coloumn = 66;
    $flag    = false;

    $shortname = key($scoreboard[$i]);
    $score     = current($scoreboard[$i]);
    $name      = '';
    $hnd       = '';

    $memQuery = mysqli_query($conn, "SELECT * FROM tbgolfmember WHERE gmshortname = '" . $shortname . "'");

    if ($memberfound = mysqli_fetch_array($memQuery)) {
        $name = $memberfound['gmfullname'];
        $hnd  = $memberfound['handicap'];
        $flag = true;
    }

    if ($flag) {
        $sheet->setCellValue(chr($coloumn++) . $row, $name);
        $sheet->setCellValue(chr($coloumn++) . $row, $hnd);

        $sum = 0;
        foreach ($score as $sc) {
            if ($sc != -1) {
                $sheet->setCellValue(chr($coloumn++) . $row, $sc);
                $sum += $sc;
            } else {
                $sheet->setCellValue(chr($coloumn++) . $row, '-');
            }
        }
        $coloumn = $coloumn + 2;
        $sheet->setCellValue(chr($coloumn) . $row, $sum);
        echo "<br>";

        $row++;
    }

}

for ($i = 'A'; $i != $sheet->getHighestColumn(); $i++) {
    $sheet->getColumnDimension($i)->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);
$writer->save($tname  . '.xlsx');

//header("location: " . $tname . ".xlsx");


$from ="websupport@amplifymind.edu.in";
$to = "p.hinduja@amplifymind.com";
$Vcc = "manthanbhatt6225@gmail.com";
/*$to = "v.dudhe@amplifymind.com";
$Vcc = "";*/
$Vbcc = "websupport@amplifymind.edu.in";
$subject = "Test Golf Project";
$strMessage = " This is Golf Tournaments Score details.";


$path = "";// "/ExcelGeneration/";
$fileNm = $tname  . '.xlsx';
//echo"File: ".$path.$fileNm;
//exit();


$arr_files[0] = $fileNm;

$stat = sendMailwithMultAttachemrnts($from,$to,$Vcc,$Vbcc,$subject,$strMessage,$arr_files,$path);

if($stat)
{
	echo"<script>alert('Mail Send Successfully'); window.location='../TempButtonExcel.php';</script>"; //  
}
else
{
	echo"<script>alert('Mail failed to send, Please try again'); window.location='../TempButtonExcel.php';</script>"; //
}




?>