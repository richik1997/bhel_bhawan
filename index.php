<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge;IE=9;chrome=1">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<link href="font_layout.css" rel="stylesheet">
<title>Bhel Review Meeting System - Index Page</title>
<link rel="stylesheet" href="login_style.css">
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
  if (i < 10) {i = "0" + i};  
  return i;
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
        <span class="banner_name_company txx" >Bharat Heavy Electricals Limited </span>
        <br>
        <span class="banner_name_region txx" ><center>Power Sector Eastern Region Intranet</center></span>
    </div>

    <div class="banner_edge">
    <br>
    <div id="txt" class="banner_edge_clock" ></div>
    </div>
</div>
<br>

<center>
  <?php
    if(isset($_GET['msg']))
    {
      $msg = $_GET['msg'];

      if($msg == 1)
      {
          echo '<h4 style="color: red;">Invalid Credentials. Enter correct username and password.</h4>';
      }
      else if($msg == 2)
      {
            echo '<h4 style="color: red;">Please login to view.</h4>';
      }
    }
  ?>
</center>
<center><div class="loginbox">
<center><form class="myform" action="login.php" method="POST">
  Staff Id:<br> 
  <input type="text" name="staff_id" class="text1"><br>
  User Password:<br> 
  <input type="password" name="psw" class="text1"><br><br>
  <button type="submit" class="btn">Login</button>
  <br><br>
  <!-- <a href="url" style="padding: -10px;">Forgot Password?</a> -->
</form></center>
</div></center>
<!-- Start of footer -->
<div class="foot">
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
</div></div>

<!-- End of Footer -->

</body></html>

