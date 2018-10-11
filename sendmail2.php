<html>
<head>
  <?php
  include 'link-css.php';
  include 'link-js.php';
  ?>
</head>
</html>
<?php


if (isset($_POST['btnSubmit']))
{

  $inputfname=$_POST['inputfname'];
  $inputemail=$_POST['inputemail'];
  $image = $_FILES['file']['name'];
  
  
 
// Settings
$name        = $inputfname;
$email       = $inputemail;
$to          = "$name <$email>";
$from        = "abhishekshah453@gmail.com";
$subject     = "Test Case";
$mainMessage = "TPG";
$fileatt     = "WordDocument/$image"; //file location
$fileatttype = "application/pdf";
$fileattname = "$image"; //name that you want to use to send or you can use the same name
$headers = "From: $from";

// File
$file = fopen($fileatt, 'rb');
$data = fread($file, filesize($fileatt));
fclose($file);

// This attaches the file
$semi_rand     = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
$headers      .= "\nMIME-Version: 1.0\n" .
  "Content-Type: multipart/mixed;\n" .
  " boundary=\"{$mime_boundary}\"";
  $message = "Greetings from Shree Shubh Holidays\n\n".
  "This is a multi-part message in MIME format.\n\n" .
  "-{$mime_boundary}\n" .
  "Content-Type: text/plain; charset=\"iso-8859-1\n" .
  "Content-Transfer-Encoding: 7bit\n\n" .
  $mainMessage  . "\n\n";

$data = chunk_split(base64_encode($data));
$message .= "Greetings from Shree Shubh Holidays\n\n".
"--{$mime_boundary}\n" .
  "Content-Type: {$fileatttype};\n" .
  " name=\"{$fileattname}\"\n" .
  "Content-Disposition: attachment;\n" .
  " filename=\"{$fileattname}\"\n" .
  "Content-Transfer-Encoding: base64\n\n" .
$data . "\n\n" .
 "-{$mime_boundary}-\n";

// Send the email
if(mail($to, $subject, $message, $headers)) {
?>
  <!-- echo "The email was sent."; -->
  <script type="text/javascript">
     successAlert("Email Send Successfully");
      setTimeout(function(){
       window.location.href='sentmail.php';
     }, 1000);
  </script>
<?php
}
else {
?>
  <!-- echo "There was an error sending the mail."; -->
    <script type="text/javascript">
     successAlert("Email Not Send Successfully");
      setTimeout(function(){
       window.location.href='sentmail.php';
     }, 1000);
  </script>
<?php
}
}
?>