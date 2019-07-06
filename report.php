<?php
    include "dbconnect.php";
    session_start();

    if(!(isset($_SESSION['Emp_Name'])))
  {
    header('location: index.php?msg=2');
  }

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

?>

<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge;IE=9;chrome=1">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<link href="font_layout.css" rel="stylesheet">
<title>Bhel Review Meeting System - Report Page</title>

<link rel="stylesheet" href="report_style.css">

<script type="text/javascript">
	
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
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
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

window.onload = function selbox(){
        location.href=document.getElementById("selectbox").value;
    }    
</script>
</head>
<body onload="startTime()" style="font: 16px ;font-family: 'Nunito', sans-serif;  ">
<!-- BANNER !-->
<div class="banner">
<div class="banner_logo">
<img src="bhel.png" alt="BHEL Logo" class="logos" width="67" height="56">
<img src="gandhi-logo.png" alt="Mahatma Gandhi" class="logos" width="78" height="56">
</div>

<div class="banner_name">
<span class="banner_name_company txx" >
Bharat Heavy Electricals Limited 
</span>
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
<br>
<center><div style="width:50%;padding-left: 230px">

  <?php 
      echo'
        <div style="float: left;"><a href="home.php?d_id='.$d_id.'"><button type="submit" style="width:150px; padding-left: 30px; background-color:#0be9ed; border-radius:5px; height: 30px; margin: 3px ">Home</button></a></div>
        <div style="float:left;">';

  ?>
  <select id="selectbox" name="date_selector" onchange="javascript:location.href = this.value;" style="width:150px; padding-left: 30px; background-color:#0be9ed; border-radius:5px; height: 30px; margin: 3px ">

      <?php

    echo '<option value="select_a_date.php?d_id='.$d_id.'" selected>'.date('d/m/Y', strtotime($curr)).'</option>';
    

    $qry = "SELECT * FROM `dates` ORDER BY `Date` DESC";
    $check = mysqli_query($connection, $qry);

    while($row = mysqli_fetch_assoc($check))
    {
      $date_id = $row['D_id'];
      $date = $row['Date'];
      if($date_id != $d_id)
        echo '<option  value="select_a_date.php?d_id='.$date_id.'">'.date('d/m/Y', strtotime($date)).'</option>';
    }


    ?>
    
  </select>
</div>
  
  
</div></center>
<br>
<div style="min-height:450px; ">
  <br>
<center>
  <table id="tblData" class="rp">
    <col width="10%">
    <col width="25%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="35%">
    <tr><th>Topic Name</th><th>Agenda</th><th>Creation Date</th><th>Responsibity</th><th>Target Date</th><th>Status</th></tr>

<?php

        $query = "SELECT * FROM `topics`";
        $result = mysqli_query($connection, $query);

        $ctr=1;

        while($row = mysqli_fetch_assoc($result))
          {
            $topic_name = $row['Topic_Name'];
            $topic_no = $row['Topic_No'];
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

          if($agenda == "")
          {
            $agenda = "Not added till ".date('d/m/Y', strtotime($curr));
          }

          if($dat_id == $d_id) 
          { 

          echo '<tr><td>'.$topic_name.'</td><td>'.$agenda.'</td><td>'.date('d/m/Y', strtotime($doc)).'</td>';
?>

<?php

    $query2 = "SELECT * FROM `responsiblities` WHERE `Agenda_no` = '$agenda_no' AND `D_id` = '$d_id'";
                                                $result2 = mysqli_query($connection, $query2);
                                                $num_row_res2 = mysqli_num_rows($result2);
                                                if($num_row_res2 == 0)
                                                {
                                                  echo "<td>Not added till ".date('d/m/Y', strtotime($curr))."</td>";
                                                }
                                                else
                                                {
                                                  echo '<td><table>';
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
                                                        echo '<tr>'.$emp_name.'</tr><br>';
                                                      }
                                                  }
                                                  echo '</table></td>';
                                                }
                                                
?>

<?php
  
  if($latest_status == "")
          {
            $latest_status = "Not added till ".date('d/m/Y', strtotime($curr));
          }

  echo '<td>'.date('d/m/Y', strtotime($target_date)).'</td><td>'.$latest_status.'</td></tr>';

}

}
}
?>

</table>
<br>
<button onclick="exportTableToExcel('tblData')" style="background-color: #0be9ed;  border-radius: 5px; height: 50px;width: 200px;">Export Table Data To Excel File</button></div>
<br>
<br>
</center>
<!-- Start of footer -->
<footer style="text-align: center; background: #0be9ed; background: linear-gradient(rgba(255,255,255,1),rgba(11, 233, 237,1),rgba(255,255,255,1));clear: both;position: relative;height: auto;">
<b><span class="txx" >PSER Headquarter:</span></b>
<span class="txx" >BHEL Bhawan, Plot No DJ - 9/1, Sector II, Salt Lake City, Kolkata - 700091 India</span>
<br><b><span class="txx" >Registered Office:</span></b>
<span class="txx" >BHEL House, Siri Fort, New Delhi - 110049, India  </span>
<div>&nbsp;Copyright © 2019 BHEL PSER</div>
<!-- End of Footer -->
</footer>
</body>
</html>

