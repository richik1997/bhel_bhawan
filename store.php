<?php

include "dbconnect.php";
session_start();

$d_id = $_GET['d_id'];
$topic_no = $_GET['topic_no'];

if(isset($_POST))
{
  $cdarr = $_POST['creation_date'];
	$agendaarr = $_POST['agenda'];
	$latest_status_arr = $_POST['latest_status'];
  $tdarr = $_POST['target_date'];
     $ctr = 0;

	$a_no_arr = [];

	$fetch = "SELECT * FROM `agendas` a JOIN `reports` r ON a.`Agenda_no` = r.`Agenda_no` WHERE a.`Topic_No` = '$topic_no'";

        $fetch_result = mysqli_query($connection, $fetch);


        while($row = mysqli_fetch_assoc($fetch_result))
        {
          
        	if($row['D_id'] == $d_id)
        	{
        		$agenda_no = $row['Agenda_no'];
	          	$a_no_arr[$ctr] = $agenda_no;

	          	$ctr+=1;
        	}
          

      }
      
      $flag =0;

      for($i = 0; $i < $ctr ; $i++)
      {
        $an = trim($a_no_arr[$i]," ");
      	$ls = trim($latest_status_arr[$an]," ");
      	$na = trim($agendaarr[$an]," ");
      	
        $cd = $cdarr[$an];

        $td = $tdarr[$an];

      	$query = "UPDATE `reports` SET `Agenda`='$na', `Latest_Status`='$ls',`Target_Date`='$td' WHERE `D_id` = '$d_id' AND `Agenda_no` = '$an' AND `Topic_no` = '$topic_no'";
      	if(mysqli_query($connection, $query))
    		{

    			
          
          $qur_ = "UPDATE `agendas` SET `Date_of_Creation` = '$cd' WHERE `Agenda_no` = '$an' AND `Topic_No` = '$topic_no' ";
          if(mysqli_query($connection,$qur_))
          {

    				$flag = 1;

          }
    			
    		}


      }

      
      if($flag)
      	header('location: home.php?topic_no='.$topic_no.'&d_id='.$d_id);



		
}


?>