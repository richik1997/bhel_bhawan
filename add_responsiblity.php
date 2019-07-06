<?php

	include "dbconnect.php";
	session_start();

	
	$agenda_no = $_GET['agenda_no'];
	$d_id = $_GET['d_id'];
	$topic_no = $_GET['topic_no'];
	$name = $_POST['myCountry'];
	$staff_no;

	$but = "SELECT * FROM `employees` WHERE `Emp_Name` = '$name'";
	$getbut = mysqli_query($connection, $but);
	$num_r = mysqli_num_rows($getbut);
	if($num_r == 1)
	{
		$row = mysqli_fetch_assoc($getbut);
		$staff_no = $row['Staff_No'];
	}

	$g = 0;

	$check = "SELECT * FROM `responsiblities` WHERE `Agenda_no` = '$agenda_no' AND `Staff_Id` = '$staff_no' AND `D_id` = '$d_id'";
	$getit = mysqli_query($connection, $check);
	$count_rows = mysqli_num_rows($getit);

	echo $count_rows;

	if($count_rows > 0)
	{
		$g = 1;
	}
	if($g==1)
	{
		header("location: home.php?topic_no=".$topic_no);
	}
	else
	{
		$query = "INSERT INTO `responsiblities` VALUES ('$agenda_no','$staff_no','$d_id')";
		if(mysqli_query($connection,$query))
		{
			header("location: home.php?topic_no=".$topic_no);

		}
		else
		{
			header("location: home.php?topic_no=".$topic_no."&msg=4");
		}
	}
	


?>