<?php

include "dbconnect.php";
session_start();

$d_id = $_GET['date'];
$ag_no = [];
$ag = [];
$la_st = [];
$la_dt = [];
$cgi = 0;
$sql = "SELECT * FROM `reports` WHERE `D_id` = '$d_id'";
$res = mysqli_query($connection, $sql);

$c_date = strtotime(date('Y-m-d'));
// echo $c_date;
while($row = mysqli_fetch_assoc($res))
{  
	$n_date = strtotime($row['Target_Date']); 
	// echo $n_date; 
	if($n_date != "")
	{
		$no_of_days = ($n_date - $c_date)/3600/24;
		if($no_of_days>=0 && $no_of_days<=7)
		{
			$ag_no[$cgi] = $row['Agenda_no'];
			$ag[$cgi] = $row['Agenda'];
			$la_st[$cgi] = $row['Latest_Status'];
			$la_dt[$cgi] = date('Y-m-d',$n_date);
			$cgi++;
		}
	}
}


$nam = [];
$mail = [];
$msg = [];
$ggi = 0;

for($i =0;$i < $cgi; $i++)
{
	$aga_num = $ag_no[$i];
	// echo $aga_num." ";
	$query = "SELECT * FROM `responsiblities` WHERE `D_id` = '$d_id' AND `Agenda_no` = '$aga_num'";
	$hyt = mysqli_query($connection, $query);
	
		while($row = mysqli_fetch_assoc($hyt))
		{
			$staf_i = $row['Staff_Id'];
			// echo $staf_i."\n";
			$new_ryt = "SELECT * FROM `employees` WHERE `Staff_No` = '$staf_i'";
			$new_hyt = mysqli_query($connection, $new_ryt);
			
				$row = mysqli_fetch_assoc($new_hyt);
				$h = $row['Emp_Name'];
				$z = $row['Email_Id'];
				
				if($ggi>0)
				{
					$rep =0;
					for($j = 0; $j<$ggi;$j++)
					{
						if($nam[$j] == $h && $mail[$j] == $z)
						{
							$rep =1;
							$msg[$j] = $msg[$j]."<br>Agenda : ".$ag[$i]."<br>Status : ".$la_st[$i]."<br>Deadline: ".$la_dt[$i]."<br>";
						}
					}
					if($rep == 0)
					{
						$nam[$ggi] = $h;
						$mail[$ggi] = $z;
						$msg[$ggi] = "<br>Agenda : ".$ag[$i]."<br>Status : ".$la_st[$i]."<br>Deadline: ".$la_dt[$i]."<br>";
						$ggi+=1;
					}
					// echo $rep." ";
				}
				else
				{
					$nam[$ggi] = $h;
						$mail[$ggi] = $z;
						$msg[$ggi] = '<br>Agenda : '.$ag[$i].'<br>Status : '.$la_st[$i].'<br>Deadline: '.$la_dt[$i].'<br><br>';
						$ggi+=1;
				}


			
		}
	
}

$mailbod = [];
for($i = 0; $i <$ggi; $i++)
	{
		$mailbod[$i] = 'Dear '.$nam[$i].',<br>
			This is a reminder to update the status of the following agendas before the approaching deadline. 
			'.$msg[$i];
		// $mailbod[$i] = str_ireplace("<br>","\n",$mailbod[$i]);
	}
?>

<?php

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
<link href="font_layout.css" rel="stylesheet">
<title>Bhel Review Meeting System - Pending E-mails</title>

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
  <div style="width:35%;padding-left: 230px">

    <div style="float: left;"><a href="home.php"><button type="submit" style="width:150px; padding-left: 30px; background-color:#0be9ed; border-radius:5px; height: 30px; margin: 3px ">Home</button></a></div>
	<?php echo '<div style="float: left;"><button type="submit" form="myform" class="smallscreen" formaction="mailing.php?date='.$d_id.'" style="width:150px; padding-left: 30px; background-color:#0be9ed; border-radius:5px; height: 30px; margin: 3px ">Send mail</button></div>'; ?>
   </div>
</center>
<br>
<div style="min-height:400px; ">
  <br>
<center>
<br>
<br>
</center>
<center>
	<form id="myform" method="POST">
<table style="width:100%;padding-top: -10px;">
	<col width="20%">
	<col width="80%">
	
	
<?php


	for($i = 0; $i <$ggi; $i++)
	{
		
		$mailbod[$i] = str_ireplace("<br>","\n",$mailbod[$i]);

		echo '<tr>
		<td>
		Name
		</td>
		<td>
			<textarea cols="100" readonly name="emp_name['.$i.']" style="text-align: center;">'.$nam[$i].'</textarea>
		</td>
		</tr>
		<tr>
		<td>
		Mail
		</td>
		<td>
			<textarea cols="100" readonly name="emp_mail['.$i.']" style="text-align: center;">'.$mail[$i].'</textarea>
		</td>
		</tr>
		<tr>
		<td>Message</td>';

		echo '<td><textarea cols="100" readonly name="msg_to_emp['.$i.']">'.$mailbod[$i].'</textarea>';
		?>

		<script src='autosize.min.js'></script>
                    <script>
                      autosize(document.querySelectorAll('textarea'));
                    </script>

<?php
        echo '</td>
	</tr>';
	}

?>
	
	
</table>
</form>
</center>
<!-- Start of footer -->
<div style=" padding-top: 25px;">
<footer style="text-align: center; background: #0be9ed; background: linear-gradient(rgba(255,255,255,1),rgba(11, 233, 237,1),rgba(255,255,255,1));clear: both;position: relative;margin-top:auto;">
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
</div></footer></div>

<!-- End of Footer -->
</body>
</html>