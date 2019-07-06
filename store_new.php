<?php

include "dbconnect.php";
session_start();

$d_id = $_GET['d_id'];
$topic_no = $_GET['topic_no'];

if(isset($_POST))
{
	$latest_status_arr = $_POST['latest_status'];
	// print_r($latest_status_arr);

	$a_no_arr = [];
	$ctr = 0;

	$emp_id = $_SESSION['Staff_No'];

	$query = "SELECT `Agenda_no` FROM `responsiblities` WHERE `Staff_Id` = '$emp_id' AND `D_id` = '$d_id'";
	$fetch = mysqli_query($connection, $query);
	while($row = mysqli_fetch_assoc($fetch))
	{
		$agenda_no = $row['Agenda_no'];
		// echo $agenda_no;
		$sql = "SELECT `Topic_no` FROM `agendas` WHERE `Agenda_no` = '$agenda_no'";
		$getit = mysqli_query($connection, $sql);
		$num_rows = mysqli_num_rows($getit);
		if($num_rows == 1)
		{
			$a_no_arr[$ctr] = $agenda_no;
			$ctr+=1;
		}
	}

	// print_r($a_no_arr);
	// echo $emp_id;

	for($i = 0; $i < $ctr ; $i++)
      {
      	$ls = trim($latest_status_arr[$a_no_arr[$i]]," ");
      	$an = trim($a_no_arr[$i]," ");
      	// echo $an." ".$ls;

      	$upd_query = "UPDATE `reports` SET `Latest_Status`='$ls' WHERE `D_id` = '$d_id' AND `Agenda_no` = '$an' AND `Topic_no` = '$topic_no'";
      	if(mysqli_query($connection, $upd_query))
      	{
      		header('location: home.php?topic_no='.$topic_no.'&d_id='.$d_id);
      	}
      }
}

?>