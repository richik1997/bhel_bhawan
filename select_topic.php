<?php

include "dbconnect.php";
session_start();

$d_id = $_GET['d_id'];
$t_no = $_GET['topic_no'];

$query = "SELECT * FROM `agendas` WHERE `Topic_No` = '$t_no'";
$res = mysqli_query($connection, $query);

$num_rows = mysqli_num_rows($res);
if($num_rows == 0)
{

	$ne_qry = "INSERT INTO `agendas` VALUES (NULL, '$t_no', NULL)";
	if(mysqli_query($connection, $ne_qry))
	{
		$sql = "SELECT * FROM `agendas` ORDER BY `Agenda_no` DESC LIMIT 1";
		      $res = mysqli_query($connection, $sql);

		      $no_rows = mysqli_num_rows($res); 

		      if($no_rows == 1)
		      {
		        $row = mysqli_fetch_assoc($res);
		        $agenda_no = $row['Agenda_no'];
		        
		      }


		$n_qey = "INSERT INTO `reports`(`D_id`, `Agenda_no`, `Agenda`, `Topic_no`, `Target_Date`, `Latest_Status`, `Agenda_color`) VALUES ('$d_id','$agenda_no',NULL,'$t_no',NULL,NULL,NULL)";
		if(mysqli_query($connection,$n_qey))
		{
			header('location: home.php?topic_no='.$t_no.'&d_id='.$d_id);
			
		}
		
	}
}
else
{
	header('location: home.php?topic_no='.$t_no.'&d_id='.$d_id); 
}

?>