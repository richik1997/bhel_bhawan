<?php

include "dbconnect.php";
session_start();

$t_no = $_GET['topic_no'];
$query = "UPDATE `topics` SET `curr_status` = '0' WHERE `topic_no` = '$t_no'";
if(mysqli_query($connection,$query))
{
	header("location: home.php?msg=3");
}
else
{
	header("location: home.php?msg=4");
}

?>