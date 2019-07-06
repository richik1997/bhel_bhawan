<?php

include "dbconnect.php";
session_start();

$d_id = $_GET['d_id'];


$flag =0;

$fetch = "SELECT `Date` FROM `dates`";
$fetch_res = mysqli_query($connection, $fetch);

while($row = mysqli_fetch_assoc($fetch_res))
{
	$d = $row['Date'];
	
	if($d == date('Y-m-d'))
	{
		$flag=1;
	}
}


if($flag == 0)
{
	$query = "INSERT  INTO `dates` VALUES (NULL,CURDATE()) ";

	if(mysqli_query($connection,$query))
	{

		$sql = "SELECT * FROM `dates` ORDER BY `Date` DESC LIMIT 1";
        $res = mysqli_query($connection, $sql);

        $num_rows = mysqli_num_rows($res); 

        if($num_rows == 1)
        {
          $row = mysqli_fetch_assoc($res);
          $new_d_id = $row['D_id'];
          $curr = $row['Date'];
        }

        // echo $new_d_id;

        $new_quer = "SELECT * FROM `reports` where `D_id` = '$d_id'";
        $new_res = mysqli_query($connection, $new_quer);

        while($row = mysqli_fetch_assoc($new_res))
        {
        	$agenda_no = $row['Agenda_no'];
            $agenda = $row['Agenda'];
        	$topic_no = $row['Topic_no'];
        	$target_date = $row['Target_Date'];
        	$latest_status = $row['Latest_Status'];
        	$agenda_color = $row['Agenda_color'];

        	$req = "INSERT INTO `reports` VALUES ('$new_d_id','$agenda_no','$agenda','$topic_no','$target_date','$latest_status','$agenda_color')";
        	if(mysqli_query($connection, $req))
        	{
        		continue;
        	}
        }

        $new_quer2 = "SELECT * FROM `responsiblities` where `D_id` = '$d_id'";
        $new_res2 = mysqli_query($connection, $new_quer2);

        while($row = mysqli_fetch_assoc($new_res2))
        {
            $agenda_no = $row['Agenda_no'];
            $staff_no = $row['Staff_Id'];

            $req2 = "INSERT INTO `responsiblities` VALUES ('$agenda_no','$staff_no','$new_d_id')";
            if(mysqli_query($connection, $req2))
            {
                continue;
            }
        }

		
		header('location: home.php?d_id='.$d_id.'&msg=2');
	}
}
else
{
	header("location: home.php?msg=1");
}


?>