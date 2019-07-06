<?php

include "dbconnect.php";
session_start();

$agenda_no = $_GET['agenda_no'];
$d_id = $_GET['d_id'];
$topic_no = $_GET['topic_no'];

// echo $agenda_no." ".$d_id." ".$topic_no;

$query = "DELETE FROM `reports` WHERE `D_id` = '$d_id' AND `Agenda_no` = '$agenda_no'";
if(mysqli_query($connection,$query))
{
	$new_q = "SELECT *FROM `reports` WHERE `D_id` = '$d_id' AND `Topic_no` = '$topic_no'";
	$result = mysqli_query($connection,$new_q);

	$num_rows = mysqli_num_rows($result);

	if($num_rows == 0)
	{
		header("location: del_topic.php?topic_no=".$topic_no);
	}
	else
	{
		header("location: home.php?topic_no=".$topic_no);
	}
}

?>