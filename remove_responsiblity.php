<?php

include "dbconnect.php";
	session_start();

	$staff_no = $_GET['emp_id'];
	$agenda_no = $_GET['agenda_no'];
	$d_id = $_GET['d_id'];
	$topic_no = $_GET['topic_no'];

	
	$query = "DELETE FROM `responsiblities` WHERE `Agenda_no` = '$agenda_no' AND `Staff_Id` = '$staff_no' AND `D_id` = '$d_id' ";
	if(mysqli_query($connection,$query))
	{
		header("location: home.php?topic_no=".$topic_no);
	}
	else
	{
		header("location: home.php?topic_no=".$topic_no."&msg=4");
	}


?>