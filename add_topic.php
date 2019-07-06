<?php

include "dbconnect.php";
session_start();

$topic = $_POST['new_topic'];

$sql = "INSERT INTO `topics`(`Topic_No`, `Topic_Name`, `curr_status`) VALUES (NULL,'$topic','1')";
if(mysqli_query($connection,$sql))
{
	header("location: home.php?msg=0");
}
else
{
	header("location: home.php?msg=4");
}

?>