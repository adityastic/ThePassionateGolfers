
<?php
date_default_timezone_set('Asia/Kolkata');
$dateti = new stdClass();
$dateti->currentdate = date('Y-d-m',time());
echo json_encode($dateti);
?>
