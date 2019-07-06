<?php
    include "dbconnect.php";
    session_start();

    if(!(isset($_SESSION['Emp_Name'])))
  {
    header('location: index.php?msg=2');
  }

  if(isset($_GET['msg']))
  {
    if($_GET['msg'] == 0)
    {
      echo "<script language='javascript' type='text/javascript'>";
      echo "alert('Some Error Occurred.');";
      echo "</script>";
      
    }
            // else if($_GET['msg']==1)
            // {
              
            // echo "<script language='javascript' type='text/javascript'>";
            // echo "alert('Employee Status Updated.');";
            // echo "</script>";
            // }
  }



?>

<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge;IE=9;chrome=1">

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<title>Bhel Review Meeting System - List of Employees</title>
<link href="font_layout.css" rel="stylesheet">
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
<center>
  <div style="width:50%;padding-left: 230px">

    <div style="float: left;"><a href="home.php"><button type="submit" style="width:150px; padding-left: 30px; background-color:#0be9ed; border-radius:5px; height: 30px; margin: 3px ">Home</button></a></div>
      <div style="float:left;"><a href="report.php"><button type="submit" style="width:150px; padding-left: 30px; background-color:#0be9ed; border-radius:5px; height: 30px; margin: 3px ">Report</button></a></div>
      </div>
    </div>
</center>
<br>
<div style="min-height:400px; ">
  <br>
<center>
  <?php

    if($_SESSION['RW'] == 1)
      {

  ?>
  <table id="tblData" class="rp">
    <col width="15%">
    <col width="35%">
    <col width="20%">
    <col width="20%">
    <col width="10%">
    <tr><th>Staff No</th><th>Name</th><th>Email</th><th>Contact No</th><th>Status</th></tr>

<?php

  $sql = "SELECT * FROM `employees`";
  $res_fetch = mysqli_query($connection, $sql);
  while($row = mysqli_fetch_assoc($res_fetch))
  {
      $staff_no = $row['Staff_No'];
      $emp_name = $row['Emp_Name'];
      $email = $row['Email_Id'];
      $psw = $row['Password'];
      $ph_no = $row['Phone_No'];
      $status = $row['RW'];

      echo '<tr><td>'.$staff_no.'</td><td>'.$emp_name.'</td><td>'.$email.'</td><td>'.$ph_no.'</td>';
      
        echo '<td>
        <select id="selectbox" name="status_selector" onchange="javascript:location.href = this.value;" style="width:150px; padding-left: 30px; background-color:#0be9ed; border-radius:5px; height: 30px; margin: 3px ">';

          if($status == 0)
          {
            echo '<option value="change_status.php?staff_no='.$staff_no.'&status=0" selected>Read Only</option>';
            echo '<option value="change_status.php?staff_no='.$staff_no.'&status=1">Read Write</option>';
          }
          else
          {
            echo '<option value="change_status.php?staff_no='.$staff_no.'&status=1" selected>Read Write</option>';
            echo '<option value="change_status.php?staff_no='.$staff_no.'&status=0">Read Only</option>';
          }

          echo '</td></tr>';
      }
      // else
      // {
      //   if($status == 0)
      //   {
      //     echo '<td>Read Only</td></tr>';
      //   }
      //   else
      //   {

      //     echo '<td>Read Write</td></tr>';
        
      //   }
      // }
  }


  
  

?>

</table>
<br>
<!-- <button onclick="exportTableToExcel('tblData')" style="background-color: #0be9ed;  border-radius: 5px; height: 50px;width: 200px;">Export Table Data To Excel File</button></div> -->
<br>
<br>
</center>
<!-- Start of footer -->
<footer style="text-align: center; background: #0be9ed; background: linear-gradient(rgba(255,255,255,1),rgba(11, 233, 237,1),rgba(255,255,255,1));clear: both;position: relative;height: 80px;margin-top:auto;">
<b>

<span class="txx" >
PSER Headquarter:
</span>
</b>
<span class="txx" >
BHEL Bhawan, Plot No DJ - 9/1, Sector II, Salt Lake City, Kolkata - 700091 India
</span>
<b>
  <br>
<span class="txx" >
Registered Office:
</span>
</b>
<div>
<span class="txx" >
BHEL House, Siri Fort, New Delhi - 110049, India  
</span>
</div>

<div >
&nbsp;Copyright © 2019 BHEL PSER
</div></footer>

<!-- End of Footer -->
</body></html>

