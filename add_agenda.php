<?php

include "dbconnect.php";
session_start();

$da_id = $_GET['date'];
$t_no = $_GET['topic_no'];
$get_date = date('Y-m-d');



$add = "INSERT INTO `agendas` VALUES (NULL,'$t_no','$get_date')";
	if(mysqli_query($connection, $add))
	{

		$get_a_no = "SELECT * FROM `agendas` WHERE `Topic_No` = '$t_no' ORDER BY `Agenda_No` DESC LIMIT 1";
		$res = mysqli_query($connection, $get_a_no);
			$row = mysqli_fetch_assoc($res);
			$agenda_no = $row['Agenda_no'];

		

		$new_ad = "INSERT INTO `reports` VALUES ('$da_id','$agenda_no',NULL,'$t_no',NULL,NULL,NULL)";
		if(mysqli_query($connection, $new_ad))
			header('location: home.php?topic_no='.$t_no); 
	}
	else
	{
		header('location: home.php?topic_no='.$t_no);
	}


?>