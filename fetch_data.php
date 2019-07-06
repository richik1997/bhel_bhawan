<?php

include "dbconnect.php";
session_start();

if(isset($_POST['query']))
{
	$search = mysqli_real_escape_string($connection, $_POST["query"]);
	if(strlen($search)>2)
	{
		$sql = "SELECT * FROM `employees` WHERE `Emp_Name` LIKE '%".$search."%'";
		$result = mysqli_query($connection, $sql);

		if(mysqli_num_rows($result) > 0)
		{
			echo '<table >';
			while($row = mysqli_fetch_assoc($result))
			{
				echo '<tr bgcolor="grey">'.$row['Emp_Name'].'</tr><br>';
			}
			echo '</table>';
		}
		else
		{
			echo $search;
		}
	}
	
	

}


?>