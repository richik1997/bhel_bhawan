<?php
	
	include "dbconnect.php";
	session_start();

	$staff_no = $_POST['staff_id'];
	$password = $_POST['psw'];

	echo $staff_no." ".$password;

	$query = "SELECT * FROM `employees` WHERE `Staff_No` = '$staff_no' ";
	$result = mysqli_query($connection, $query);

	$num_rows=mysqli_num_rows($result);

	if($num_rows==1)
	{
		$row=mysqli_fetch_assoc($result);
	
		$_SESSION['Staff_No']=$row['Staff_No'];
		$_SESSION['Email_Id']=$row['Email_Id'];
		$_SESSION['Emp_Name']=$row['Emp_Name'];
		$_SESSION['RW']=$row['RW'];

		
		
		if($row['Password'] == $password)
			header('location: home.php');
		else
			header('location: index.php?msg=1');
		
	}
	else
	{
		header('location: index.php?msg=1');
	}

?>