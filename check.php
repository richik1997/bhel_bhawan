<?php

    //Database connection
    include "dbconnect.php";
    session_start();

    //Fetch the date on which the agendas needs to be displayed 
    if(isset($_GET['d_id']))
    {
      $d_id = $_GET['d_id'];
      $sql = "SELECT * FROM `dates` WHERE `D_id` = '$d_id'";
      $res = mysqli_query($connection, $sql);

      $num_rows = mysqli_num_rows($res); 

      if($num_rows == 1)
      {
        $row = mysqli_fetch_assoc($res);
        $curr = $row['Date'];
      }
      
    }
    else
    {
      $sql = "SELECT * FROM `dates` ORDER BY `Date` DESC LIMIT 1";
      $res = mysqli_query($connection, $sql);

      $num_rows = mysqli_num_rows($res); 

      if($num_rows == 1)
      {
        $row = mysqli_fetch_assoc($res);
        $d_id = $row['D_id'];
        $curr = $row['Date'];
      }
    }
  
    echo $d_id;

  

?>