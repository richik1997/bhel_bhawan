<?php

include "dbconnect.php";
session_start();

$d_id = $_GET['date'];

if(isset($_POST))
{
	$name = $_POST['emp_name'];
	$mails = $_POST['emp_mail'];
	$msgs = $_POST['msg_to_emp'];
	$len = sizeof($mails);


	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';
	require 'PHPMailer/src/Exception.php';

	// echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";

	$mail = new PHPMailer\PHPMailer\PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
	$mail->SMTPOptions = array(
    	'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    	)
	);

	/* ---------------- For gmail ---------------- */
	$mail->Host = gethostbyname('smtp.gmail.com');
	$mail->Port = 465; // or 587
	/* -------------------------------------------- */
	$mail->IsHTML();
	$mail->Username = "richikbhattacharjee@gmail.com";
	$mail->Password = "Richik@1997";
	$mail->SetFrom("richikbhattacharjee@gmail.com");

	$flag = 0;

	for($i = 0; $i <$len; $i++)
	{
		
		$mail->Subject = "Reminder to Update Status of Agendas";
		$mail->Body =	'<div style="float:left;">'.str_ireplace("\n","<br>",$msgs[$i]).'
							<p>Please login <a href="enter link here">here</a> to update status.</p>

							<p>This is a system generated mail. Please do not reply.</p>


							</div>';
		$mail->AddAddress($mails[0]);

		if($mail->Send()) 
		{
    		$sql = "INSERT INTO `messages` VALUES ('$name[$i]','$mails[$i]','$msgs[$i]',NOW())";
    		if(mysqli_query($connection, $sql))
    		{
    			continue;
    		}
 		} 
 		else
 		{
 			$flag = 1;
 		}
	}


 	if($flag == 0)
 	{
 		header("location: home.php?msg=7");
 	}
 	else
 	{
 		header("location: home.php?msg=8");
 	}


}



 ?>