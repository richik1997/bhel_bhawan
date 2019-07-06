<?php

	include "dbconnect.php";
	session_start();
	
	$topic_no = $_GET['topic_no'];

	$query = "SELECT * FROM `agendas` a JOIN `reports` r ON a.`Agenda_no` = r.`Agenda_no` WHERE a.`Topic_No` = '$topic_no'";

	$result = mysqli_query($connection, $query);


	while($row = mysqli_fetch_assoc($result))
	{
		$agenda_no = $row['Agenda_no'];
		$agenda = $row['Agenda'];
		$doc = $row['Date_of_Creation'];
		$target_date = $row['Target_Date'];
		$latest_status = $row['Latest_Status'];
		$agenda_colour = $row['Agenda_color'];

		echo $agenda." ".$doc." ".$target_date." ".$latest_status." ".$agenda_colour;

		$query2 = "SELECT * FROM `responsiblities` WHERE `Agenda_no` = '$agenda_no'";
		$result2 = mysqli_query($connection, $query2);


		while($row = mysqli_fetch_assoc($result2))
		{
			$staff_id = $row['Staff_Id'];
			echo "\n".$staff_id;
		}
	}


?>