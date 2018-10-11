<?php  
 

//connection file 
$conn = new mysqli('localhost', 'root', '');  
mysqli_select_db($conn, 'wt');  

//fetch it from database table name
$setSql = "SELECT * FROM `employees`";  
$setRec = mysqli_query($conn, $setSql);  
  
$columnHeader = '';  
$columnHeader = "Playrer Name" . "\t" . "1" . "\t" . "2" . "\t". "3" . "\t". "4" . "\t". "5" . "\t". "6" . "\t". "7" . "\t". "8" . "\t"
									   . "9" . "\t". "10" . "\t". "11" . "\t". "12" . "\t". "13" . "\t". "14" . "\t". "15" . "\t". "16" . "\t"
										. "17" . "\t". "18" . "\t";  
  
$setData = '';  
  
while ($rec = mysqli_fetch_row($setRec)) {  
    $rowData = '';  
    foreach ($rec as $value) {  
        $value = '"' . $value . '"' . "\t";  
        $rowData .= $value;  
    }  
    $setData .= ($rowData) . "\n";  
}  
  
  
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=User_Detail_Reoprt.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  
  
echo ucwords($columnHeader) . "\n" . $setData . "\n";  
  
?>  