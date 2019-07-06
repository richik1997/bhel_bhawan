<?php

include "dbconnect.php";
session_start();

$status = $_GET['status'];
$staff_no = $_GET['staff_no'];

$query = "UPDATE `employees` SET `RW` = '$status' WHERE `Staff_No` = '$staff_no'";
if(mysqli_query($connection, $query))
{
	header("location: employees.php");
}
else
{
 	header("location: employees.php?msg=0");
 } 

?>