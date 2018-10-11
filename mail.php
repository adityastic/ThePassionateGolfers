<?php


function sendMailwithMultAttachemrnts($from,$to,$Vcc,$Vbcc,$subject,$strMessage,$files,$path)
{
	
	if(preg_match("/http/i","$message")){echo "Spam Content Detected.......";exit();}
	if(preg_match("/http/i","$to")){echo "Spam Content Detected......."; exit();}
	
	$Vbcc = "websupport@amplifymind.edu.in";
	
	$headers = "From: ".$from." \n";	
	$headers .="Reply-To: ".$from. "\n";
	$headers .= "CC: ".$Vcc."\n";
	$headers .= "BCC: ".$Vbcc;

	 
	// boundary 
	$semi_rand = md5(time()); 
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
	 
	// headers for attachment 
	$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" ;
	$headers .= " boundary=\"{$mime_boundary}\""; 
	 
	// multipart boundary 
	$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" ;
	$message .= "Content-Transfer-Encoding: 7bit\n\n" . $strMessage . "\n\n"; 
	$message .= "--{$mime_boundary}\n";
	 
	// preparing attachments	
	 for($x=0;$x<count($files);$x++)
	 {
	   if(file_exists($path.$files[$x]))
	   {
		$file = fopen($path.$files[$x],"rb");
		$data = fread($file,filesize($path.$files[$x]));
		fclose($file);
		$data = chunk_split(base64_encode($data));
		$message .= "Content-Type: {\"application/vnd.ms-excel\"};\n" . " name=\"{$files[$x]}\"\n" . 
		"Content-Disposition: attachment;\n" . " filename=\"{$files[$x]}\"\n" . 
		"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
		$message .= "--{$mime_boundary}\n";
	   } 
	 }
	 
	// send
	 
	$ok = @mail($to, $subject, $message, $headers); 
	
	return $ok;	
 
 
} /// End Function 


?>