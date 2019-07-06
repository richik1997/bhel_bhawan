<?php

    //Database connection
    include "dbconnect.php";
    session_start();

    //Login User Name
    if(!(isset($_SESSION['Emp_Name'])))
    {
      header('location: index.php?msg=2');
    }

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

      if($num_rows == 0) 
      {
        $q = "INSERT INTO `dates` VALUES (NULL,CURDATE())";
        if(mysqli_query($connection,$q))
        {
          $sqli = "SELECT * FROM `dates` ORDER BY `Date` DESC LIMIT 1";
          $resi = mysqli_query($connection, $sqli);

          $mun_rows = mysqli_num_rows($resi);
          $row = mysqli_fetch_assoc($resi);
          $d_id = $row['D_id'];
          $curr = $row['Date'];
        }
      }
      else if($num_rows == 1)
      {
        $row = mysqli_fetch_assoc($res);
        $d_id = $row['D_id'];
        $curr = $row['Date'];
      }
    }
  
    
      $bush = [];
      $naes = [];
      $hush = "SELECT * FROM `employees`";
      $rehush = mysqli_query($connection, $hush);

        while ($row = mysqli_fetch_assoc($rehush)) {
          array_push($naes, $row['Emp_Name']);

      }

      // print_r($naes);
    
    ?>

<?php
          if(isset($_GET['msg']))
          {
            if($_GET['msg'] == 0)
            {
              echo "<script language='javascript' type='text/javascript'>";
              echo "alert('New Topic Added.');";
              echo "</script>";
              
            }
            else if($_GET['msg']==1)
            {
              
            echo "<script language='javascript' type='text/javascript'>";
            echo "alert('Same Date already created.');";
            echo "</script>";
            }
            else if($_GET['msg']==2)
            {
              echo "<script language='javascript' type='text/javascript'>";
            echo "alert('New Date Created');";
            echo "</script>";
            }
            else if($_GET['msg'] == 3)
            {
              echo "<script language='javascript' type='text/javascript'>";
              echo "alert('Topic removed succesfully.');";
              echo "</script>";
            }
            else if($_GET['msg'] == 4)
            {
              echo "<script language='javascript' type='text/javascript'>";
              echo "alert('Some error occurred.');";
              echo "</script>";
            }
            // else if($_GET['msg'] == 5)
            // {
            //   echo "<script language='javascript' type='text/javascript'>";
            //   echo "alert('Employee Removed Successfully.');";
            //   echo "</script>";
            // }
            // else if($_GET['msg'] == 6)
            // {
            //   echo "<script language='javascript' type='text/javascript'>";
            //   echo "alert('Employee Already Added.');";
            //   echo "</script>";
            // } 
            
          }

?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge;IE=9;chrome=1">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<title>Bhel Review Meeting</title>

<link rel="stylesheet" href="mainlayout_new.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<style type="text/css">

  .smallscreen
  {
    width:120px;  background-color:#0be9ed; border-radius:5px; height: 30px; margin: 3px ;
  }
  @media only screen and (max-width: 1100px){
    .smallscreen
    {
      width: 85px; font-size: 10px;
    }
  }

  #result {
   position: absolute;
   width: 180px;
   cursor: pointer;
   overflow-y: auto;
   max-height: 400px;
   box-sizing: border-box;
   z-index: 1001;
   background-color: #cfd1d3;
  }
  .link-class:hover{
   background-color:#f1f1f1;
  }
</style>

<script type="text/javascript">

function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds()1
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('txt').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}


window.onload = function selbox(){
        location.href=document.getElementById("selectbox").value;
    }    
</script>
</head>
<body onload="startTime()" > 
<!-- BANNER !-->
<div id="main-wrapper" style="min-height: 600px;">
<div class="banner">
  <div class="banner_logo">

    <img src="bhel.png" alt="BHEL Logo" class="logos" width="67" height="56">
    <img src="gandhi-logo.png" alt="Mahatma Gandhi" class="logos" width="78" height="56">
    </a>
  </div>

  <div class="banner_name">
    <span class="banner_name_company txx" >Bharat Heavy Electricals Limited </span>
    <br>
    <span class="banner_name_region txx" >
    <center>Power Sector Eastern Region Intranet</center>
    </span>
    </div>

  <div class="banner_edge">
    <a href="#"><?php echo $_SESSION['Emp_Name']; ?></a>
    <div id="txt" class="banner_edge_clock" ></div>
    <a href="logout.php"><span class="banner_edge_mail txt" >Logout</span></a>
  </div>
</div>
<center>
  <div style="width: 85%; padding-left: 100px;">
  <div style="float:left">
    <select id="selectbox" name="date_selector" onchange="javascript:location.href = this.value;" class="smallscreen">

      <?php

    echo '<option value="select_date.php?d_id='.$d_id.'" selected>'.date('d/m/Y', strtotime($curr)).'</option>';
    

    $qry = "SELECT * FROM `dates` ORDER BY `Date` DESC";
    $check = mysqli_query($connection, $qry);

    while($row = mysqli_fetch_assoc($check))
    {
      $date_id = $row['D_id'];
      $date = $row['Date'];
      if($date_id != $d_id)
        echo '<option  value="select_date.php?d_id='.$date_id.'">'.date('d/m/Y', strtotime($date)).'</option>';
    }


    ?>
    
  </select>

  </div> 

    <div style="float: left;">
    <a href="report.php"><button type="submit" class="smallscreen">Report</button></a>

  
  <?php

  if($_SESSION['RW'] == 1)
  {
    echo '<a href="new_date.php?d_id='.$d_id.'"><button class="smallscreen" type="submit"  >New Date</button></a>
  
  <button id="newMod" class="smallscreen">New Topic</button>

  <a href="employees.php"><button type="submit" class="smallscreen" >Employees</button></a>';

  echo '<a href="reminder.php?date='.$d_id.'"><button type="submit" class="smallscreen">Reminder</button></a>';
 
  }

    

  ?>

 <?php

 if(isset($_GET['topic_no']) && $_SESSION['RW'] == 1)
 {
    $topic_no = $_GET['topic_no'];
    echo '<a href="add_agenda.php?topic_no='.$_GET['topic_no'].'&date='.$d_id.'"><button type="submit" class="smallscreen">Add Agenda</button></a>';

      echo ' <button type="submit" form="myform" class="smallscreen" formaction="store.php?topic_no='.$topic_no.'&d_id='.$d_id.'" >Save</button>
';
}

if(isset($_GET['topic_no']) && $_SESSION['RW'] == 0)
{
                $how_many =0;
                $topic_no = $_GET['topic_no'];
                $fetch = "SELECT * FROM `agendas` a JOIN `reports` r ON a.`Agenda_no` = r.`Agenda_no` WHERE a.`Topic_No` = '$topic_no'";

                  $fetch_result = mysqli_query($connection, $fetch);


                  while($row = mysqli_fetch_assoc($fetch_result))
                  {
                    $agenda_no = $row['Agenda_no'];
                    $em_id = $_SESSION['Staff_No'];
                      $chc = "SELECT * FROM `responsiblities` WHERE `Staff_Id` = '$em_id' AND `D_id` = '$d_id' AND `Agenda_no` = '$agenda_no'";
                      $rsly = mysqli_query($connection, $chc);
                      
                      $ct_rows = mysqli_num_rows($rsly);
                      {
                        $how_many +=1;
                      }
                    }

                    if($how_many >0)
                    {

                      echo ' <button type="submit" class="smallscreen" form="myform2" formaction="store_new.php?topic_no='.$topic_no.'&d_id='.$d_id.'" style="width:150px; padding-left: 30px; background-color:#0be9ed; border-radius:5px; height: 30px; margin: 3px ">Save</button>
                    ';
                    }

}
 
  ?>
  
</div>
  
    </div>
</center>


<!-- Start display of the Topics -->
<div class="main_menu_bar">

<div class="main_menu_top">
Topics : 

<?php

        $query = "SELECT * FROM `topics`";
        $result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($result))
          {
            $topic_name = $row['Topic_Name'];
            $topic_no = $row['Topic_No'];
            if($row['curr_status'] == '1')
            {
              echo '  <div class="main_menu_l1">
                    <a href="#" class="txt" >'.$topic_no.'</a>
                    <div class="main_menu_l2">

                    <a href="select_topic.php?topic_no='.$topic_no.'&d_id='.$d_id.'" class="txt">'.$topic_name.'</a>
                    </div>
                    </div>

                  ';
            }

            
          }


?>


</div>

</div>

<!-- End of display of Topics -->

<!-- Start of Agenda Table -->
<div class="container" style="padding-top: 10px; padding-bottom: 20px; f-height: 400px;overflow:hidden;">
<center>


<?php
 
      if(!(isset($_GET['topic_no'])))
      {
          echo '<h3>Please Select a Topic</h3>';
      }
      else
      {


        $sql = "SELECT * FROM `dates` ORDER BY `Date` DESC LIMIT 1";
        $res = mysqli_query($connection, $sql);

        $num_rows = mysqli_num_rows($res); 

        if($num_rows == 1)
        {
          $row = mysqli_fetch_assoc($res);
          $da_id = $row['D_id'];
          $dat = $row['Date'];
        }
        $fl =0;
        if($d_id != $da_id)
        {
          $fl = 1; // current date is not passed
        }
  
        if($_SESSION['RW'] == 1) // check for admin
        {

          if($fl == 0)
          {

                    $topic_no = $_GET['topic_no'];
                    $get_topic_name = "SELECT * FROM `topics` WHERE `Topic_No` = '$topic_no'";
                    $result = mysqli_query($connection, $get_topic_name);

                      $num_rows=mysqli_num_rows($result);

                      if($num_rows==1)
                      {
                        $row=mysqli_fetch_assoc($result);
                      
                        $t_name=$row['Topic_Name'];

                      }

                      echo'<label class="control-label" style="margin-top: -7px;margin-bottom: 6px;"><b>'.$topic_no.'.'.$t_name.'</b></label>
                        <label class="control-label" style="float: right; margin-top: -7px;margin-bottom: 6px;"><b>Date : '.date('d/m/Y', strtotime($curr)).'</b></label>
                          
                      <form id="myform" method="POST">
                      <table width="100%" class="mytable" >
                        <col width="26%">
                        <col width="10%">
                        <col width="15%">
                        <col width="10%">
                        <col width="26%">
                        <col width="3%">
                        <tr>
                          <th>Agenda</th>
                          <th>Creation date</th>
                          <th>Responsiblity</th>
                          <th>Target Date</th>
                          <th>Status</th>
                          <th>Delete</th>
                        </tr>';
                            

                      $fetch = "SELECT * FROM `agendas` a JOIN `reports` r ON a.`Agenda_no` = r.`Agenda_no` WHERE a.`Topic_No` = '$topic_no'";

                        $fetch_result = mysqli_query($connection, $fetch);


                        while($row = mysqli_fetch_assoc($fetch_result))
                        {
                          $agenda_no = $row['Agenda_no'];
                          $agenda = $row['Agenda'];
                          $doc = $row['Date_of_Creation'];
                          $target_date = $row['Target_Date'];
                          $latest_status = $row['Latest_Status'];
                          $agenda_colour = $row['Agenda_color'];
                          $dat_id = $row['D_id']; 

                          if($dat_id == $d_id) 
                          {         
                            ?>
                              <tr>
                                <td>
                                  <?php echo '<textarea name="agenda['.$agenda_no.']" cols="50" rows="2">'.$agenda.'</textarea>'; ?>
                                  <script src='https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.15/autosize.min.js'></script>
                                  <script>
                                  autosize(document.querySelectorAll('textarea'));
                                  </script>
                                </td>
                                <td><?php echo '<input type="Date" value="'.$doc.'" name="creation_date['.$agenda_no.']" required>'; ?></td>
                                 <td>
                                  <center>
                                    <table style="padding-top: 6px; padding-bottom: 6px;">
                                      <col width="200px; height: auto;">
                                      
                                   <?php 

                                                $query2 = "SELECT * FROM `responsiblities` WHERE `Agenda_no` = '$agenda_no' AND `D_id` = '$d_id'";
                                                $result2 = mysqli_query($connection, $query2);


                                                while($row = mysqli_fetch_assoc($result2))
                                                {
                                                  $emp_no = $row['Staff_Id'];

                                                  $new_fetch = "SELECT `Emp_Name` FROM `employees` WHERE `Staff_No` = '$emp_no'";
                                                  $res_fetch = mysqli_query($connection, $new_fetch);

                                                    $num_of_rows=mysqli_num_rows($res_fetch);

                                                    if($num_of_rows==1)
                                                    {
                                                      $row=mysqli_fetch_assoc($res_fetch);
                                                      $emp_name = $row['Emp_Name'];

                                                      echo '<tr style="background: #cfd1d3;" ><td style="text-align: center;">'.$emp_name.'<a href="remove_responsiblity.php?agenda_no='.$agenda_no.'&emp_id='.$emp_no.'&d_id='.$d_id.'&topic_no='.$topic_no.'"><button type="button" style="background-color: red;color: white; float:right; padding-right: 10px;padding-left: 10px;">X</button></a></td></tr>';

                                                      
                                                        }
                                                }


                                         echo '</table>
                                         <br>';
                                         echo 
                                          '<form autocomplete="off" method="POST">
                                          <div class="autocomplete" style="width:147px; float:left; height:30px">
                                          <input id="myInput'.$agenda_no.'" type="text" name="myCountry" placeholder="Employees">
                                          </div>
                                          <div style="float:left;">
                                          <button type="submit" formaction="add_responsiblity.php?agenda_no='.$agenda_no.'&topic_no='.$topic_no.'&d_id='.$d_id.'" style="width:60px; height:30px; background-color: Dodgerblue;color:white; ">Submit</button>
                                          </div>
                                          </form>' ;

                                          array_push($bush,$agenda_no);
                                         
                                        ?> 
                                      
                                      </center>
                              </td>
                              <td><?php 
                                  echo '<input type="Date" value="'.$target_date.'" name="target_date['.$agenda_no.']" required>';
                              ?></td>
                              <td><?php echo '<textarea name="latest_status['.$agenda_no.']" cols="46" rows="2">'.$latest_status.'</textarea>'; ?>
                            <script src='https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.15/autosize.min.js'></script>
                            <script>
                              autosize(document.querySelectorAll('textarea'));
                            </script></td>
                            <?php
                                echo '<td><a href="del_agenda.php?agenda_no='.$agenda_no.'&topic_no='.$topic_no.'&d_id='.$d_id.'"><button type="button" style="background-color: red;color: white;">X</button></a></td>';
                                echo '</tr>';
                  }

                }
                  echo '</table>';



            }
            else // table with no edit field
            {
                $topic_no = $_GET['topic_no'];
                $get_topic_name = "SELECT * FROM `topics` WHERE `Topic_No` = '$topic_no'";
                $result = mysqli_query($connection, $get_topic_name);

                  $num_rows=mysqli_num_rows($result);

                  if($num_rows==1)
                  {
                    $row=mysqli_fetch_assoc($result);
                  
                    $t_name=$row['Topic_Name'];

                  }

                 // For admin
                  echo '<label class="control-label" style="margin-top: -7px;margin-bottom: 6px;"><b>'.$topic_no.'.'.$t_name.'</b></label>
                        <label class="control-label" style="float: right; margin-top: -7px;margin-bottom: 6px;"><b>Date : '.date('d/m/Y', strtotime($curr)).'</b></label>
                          
                          
                          <!-- for general employees -->
                          <table width="100%" class="mytable" >
                            <col width="30%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="30%">
                            <tr>
                              <th>Agenda</th>
                              <th>Creation date</th>
                              <th>Responsiblity</th>
                              <th>Target Date</th>
                              <th>Status</th>
                            </tr>';

                  $fetch = "SELECT * FROM `agendas` a JOIN `reports` r ON a.`Agenda_no` = r.`Agenda_no` WHERE a.`Topic_No` = '$topic_no'";

                  $fetch_result = mysqli_query($connection, $fetch);


                  while($row = mysqli_fetch_assoc($fetch_result))
                  {
                    $agenda_no = $row['Agenda_no'];
                    $agenda = $row['Agenda'];
                    $doc = $row['Date_of_Creation'];
                    $target_date = $row['Target_Date'];
                    $latest_status = $row['Latest_Status'];
                    $agenda_colour = $row['Agenda_color'];
                    $dat_id = $row['D_id']; 

                    $dat_id = $row['D_id']; 

                    if($dat_id == $d_id) 
                    {      

  ?>

                    <tr>
                    <td><textarea cols="50" rows="2" readonly><?php echo $agenda; ?></textarea>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.15/autosize.min.js'></script>
                    <script>
                      autosize(document.querySelectorAll('textarea'));
                    </script></td>
                    <td><?php echo $doc; ?></td>
                    <td>
                      <table style="padding-top: 6px; padding-bottom: 6px;">
                                      <col width="200px; height: auto;">

                        <?php 

                                                $query2 = "SELECT * FROM `responsiblities` WHERE `Agenda_no` = '$agenda_no' AND `D_id` = '$d_id'";
                                                $result2 = mysqli_query($connection, $query2);


                                                while($row = mysqli_fetch_assoc($result2))
                                                {
                                                  $emp_no = $row['Staff_Id'];

                                                  $new_fetch = "SELECT `Emp_Name` FROM `employees` WHERE `Staff_No` = '$emp_no'";
                                                  $res_fetch = mysqli_query($connection, $new_fetch);

                                                    $num_of_rows=mysqli_num_rows($res_fetch);

                                                    if($num_of_rows==1)
                                                    {
                                                      $row=mysqli_fetch_assoc($res_fetch);
                                                      $emp_name = $row['Emp_Name'];

                                                      echo '<tr style="background: #cfd1d3;" ><td style="text-align: center;">'.$emp_name.'</td></tr>';

                                                      
                                                        }
                                                }


                              ?>
                      </table>
                    </td>
                    <td><?php echo $target_date ;?></td>
                    <td><textarea cols="46" rows="2" readonly><?php echo $latest_status; ?></textarea>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.15/autosize.min.js'></script>
                    <script>

                    autosize(document.querySelectorAll('textarea'));
                    </script>
                    </td>
                    </tr>
                    <?php
                            }
                        }

                    ?>
                    </table>
                    </center>

          <?php
              } // end of else


        } // end of admin check
        else if($_SESSION['RW'] == 0)
        {
                $topic_no = $_GET['topic_no'];
                $get_topic_name = "SELECT * FROM `topics` WHERE `Topic_No` = '$topic_no'";
                $result = mysqli_query($connection, $get_topic_name);

                  $num_rows=mysqli_num_rows($result);

                  if($num_rows==1)
                  {
                    $row=mysqli_fetch_assoc($result);
                  
                    $t_name=$row['Topic_Name'];

                  }


                  echo '<label class="control-label" style="margin-top: -7px;margin-bottom: 6px;"><b>'.$topic_no.'.'.$t_name.'</b></label>
                        <label class="control-label" style="float: right; margin-top: -7px;margin-bottom: 6px;"><b>Date : '.date('d/m/Y', strtotime($curr)).'</b></label>';

                        if($how_many > 0)
                        {
                          echo '<form id="myform2" method="POST">';
                        }
                          
                         echo ' <!-- for general employees -->
                          <table width="100%" class="mytable" >
                            <col width="30%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="30%">
                            <tr>
                              <th>Agenda</th>
                              <th>Creation date</th>
                              <th>Responsiblity</th>
                              <th>Target Date</th>
                              <th>Status</th>
                            </tr>';

                  $fetch = "SELECT * FROM `agendas` a JOIN `reports` r ON a.`Agenda_no` = r.`Agenda_no` WHERE a.`Topic_No` = '$topic_no'";

                  $fetch_result = mysqli_query($connection, $fetch);


                  while($row = mysqli_fetch_assoc($fetch_result))
                  {
                    $agenda_no = $row['Agenda_no'];
                    $agenda = $row['Agenda'];
                    $doc = $row['Date_of_Creation'];
                    $target_date = $row['Target_Date'];
                    $latest_status = $row['Latest_Status'];
                    $agenda_colour = $row['Agenda_color'];
                    $dat_id = $row['D_id']; 

                    $dat_id = $row['D_id']; 

                    if($dat_id == $d_id) 
                    {     

  ?>

                    <tr>
                    <td><textarea cols="50" rows="2" readonly><?php echo $agenda; ?></textarea>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.15/autosize.min.js'></script>
                    <script>
                      autosize(document.querySelectorAll('textarea'));
                    </script></td>
                    <td><?php echo date('d/m/Y',strtotime($doc)); ?></td>
                    <td>
                      <table style="padding-top: 6px; padding-bottom: 6px;">
                                      <col width="200px; height: auto;">

                        <?php 

                                                $query2 = "SELECT * FROM `responsiblities` WHERE `Agenda_no` = '$agenda_no' AND `D_id` = '$d_id'";
                                                $result2 = mysqli_query($connection, $query2);


                                                while($row = mysqli_fetch_assoc($result2))
                                                {
                                                  $emp_no = $row['Staff_Id'];

                                                  $new_fetch = "SELECT `Emp_Name` FROM `employees` WHERE `Staff_No` = '$emp_no'";
                                                  $res_fetch = mysqli_query($connection, $new_fetch);

                                                    $num_of_rows=mysqli_num_rows($res_fetch);

                                                    if($num_of_rows==1)
                                                    {
                                                      $row=mysqli_fetch_assoc($res_fetch);
                                                      $emp_name = $row['Emp_Name'];

                                                      echo '<tr style="background: #cfd1d3;" ><td style="text-align: center;">'.$emp_name.'</td></tr>';
                                                      
                                                        }
                                                }


                              ?>
                      </table>
                    </td>
                    <td><?php echo date('d/m/Y',strtotime($target_date));?></td>
                    <?php 

                    if(($fl == 0))
                    {
                      $em_id = $_SESSION['Staff_No'];
                      $chc = "SELECT * FROM `responsiblities` WHERE `Staff_Id` = '$em_id' AND `D_id` = '$d_id' AND `Agenda_no` = '$agenda_no'";
                      $rsly = mysqli_query($connection, $chc);
                      
                      $ct_rows = mysqli_num_rows($rsly);

                      if($ct_rows == 1)
                      {
                        echo '<td><textarea cols="50" rows="2" name="latest_status['.$agenda_no.']">'.$latest_status.'</textarea>';
                      }
                      else
                      {
                        echo '<td><textarea cols="50" rows="2" readonly>'.$latest_status.'</textarea>';
                      }
                      
                    }
                    else
                    {
                      echo '<td><textarea cols="50" rows="2" readonly>'.$latest_status.'</textarea>';
                    }
                    
                    ?><script src='https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.15/autosize.min.js'></script>
                    <script>
                      autosize(document.querySelectorAll('textarea'));
                    </script></td>
                    </tr>
                    <?php
                            }
                        }

                    ?>
                    </table>
                  </form>
                    </center>
    <?php

        }

      } // end of checking topic no
    ?>
<!-- End of Agenda Table --> 

</div>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <center>Enter Name of the Topic</center>
    <br>
    
      <form action="add_topic.php" method="POST">
      <center>
      <textarea name="new_topic" cols="46" rows="4">Enter name of the topic</textarea>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.15/autosize.min.js'></script>
      <script>
        autosize(document.querySelectorAll('textarea'));
      </script>
    </center>
    <br>
    <center>
      <button type="Submit" formaction="add_topic.php" style="width:150px; padding-left: 30px; background-color:#0be9ed; border-radius:5px; height: 30px; margin: 3px ">Add Topic</button>
    </center>
  </form>
  </div>

</div>

<!-- Start of footer -->
<?php

if(isset($_GET['topic_no']))
{
  echo '<footer style="text-align: center; background: #0be9ed; background: linear-gradient(rgba(255,255,255,1),rgba(11, 233, 237,1),rgba(255,255,255,1));clear: both;position: relative;height: 80px;">';
}
else
{
  echo '
<footer style="text-align: center; background: #0be9ed; background: linear-gradient(rgba(255,255,255,1),rgba(11, 233, 237,1),rgba(255,255,255,1));clear: both;position: relative;height: 80px;">
';
}
?>
<b><span class="txx" >PSER Headquarter:</span></b>
<span class="txx" >BHEL Bhawan, Plot No DJ - 9/1, Sector II, Salt Lake City, Kolkata - 700091 India</span>
<br><b><span class="txx" >Registered Office:</span></b>
<span class="txx" >BHEL House, Siri Fort, New Delhi - 110049, India  </span>
<div>&nbsp;Copyright © 2019 BHEL PSER</div>
<!-- End of Footer -->
</footer>

<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

 var countries = <?php echo json_encode($naes); ?>;
 var tums = <?php echo json_encode($bush) ; ?>;


/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
for(var i=0;i<tums.length;i++)
autocomplete(document.getElementById("myInput".concat(tums[i])), countries);

//=========================Modal=====================================//

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("newMod");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>


</body>
</html>