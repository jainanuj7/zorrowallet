<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'wallet');
if($db==false)
  die('Sorry, server is not available at this moment. Please Try again later.');

$mob = $_SESSION['curr_mob'];
$pb= "passbook_".$mob;
$_SESSION['pb'] = $pb;
$result = mysqli_query($db,"SELECT fname, lname FROM user_info where mob = $mob");
$row = mysqli_fetch_assoc($result);
$fname = $row['fname'];
$lname = $row['lname'];
echo "<p style ='font-size: 30px; text-align: center; font-family: Century Gothic, sans-serif;'> Welcome ".$fname." ".$lname."! </p>";

if(isset($_POST['refresh_button']))
  header("Location: welcome.php");

if(isset($_POST['passbook_button']))
  header("Location: passbook.php");


if(isset($_POST['add_money']))
{
  $amt = $_POST['amount'];
  if($amt<10)
    echo "Minimum amount is Rs. 10";
  else
  {
    $time_now=mktime(date('h')+3,date('i')+30,date('s'));
    $date_time = date("Y-m-d h:i:sa", $time_now);
    $trans_type = "Added Money";
    $user_type = "";
    mysqli_query($db,"UPDATE balance SET bal = bal + $amt where mob=$mob");
    mysqli_query($db,"INSERT into `$pb` (date_time, trans_type, user_type, amt) values (NOW(), '$trans_type', '$user_type', '$amt')");
  }
}

if(isset($_POST['send_money']))
{
  $r_mob = $_POST['receiver'];
  $amt = $_POST['send_amt'];
  if($amt<10)
    echo "Minimum amount is Rs. 10";
  else
  {
    $result = mysqli_query($db,"SELECT * FROM balance where mob = $r_mob");
    if(mysqli_num_rows($result) == 0)
      echo "<p style ='font-size: 20px; text-align: center; font-family: font-family: Century Gothic, sans-serif;'> Receiver mobile no. is invalid! </p> ";
    else
    {
      $bal = mysqli_query($db, "SELECT bal from balance where mob=$mob");
      $bal_row =  mysqli_fetch_assoc($bal);
      if($bal_row['bal'] < $amt)
        echo " <p style ='font-size: 20px; text-align: center; font-family: font-family: Century Gothic, sans-serif;'> Insufficient balance. Cannot send! </p>";
      else
      {
        $pb= "passbook_".$mob;
        $_SESSION['pb'] = $pb;
        $r_pb= "passbook_".$r_mob;
        $r_trans_type = "Received Money";
        $r_user_type = "from ".$mob;
		$s_trans_type = "Sent Money";
        $s_user_type = "to ".$r_mob;
        mysqli_query($db,"UPDATE balance SET bal=bal + $amt WHERE mob=$r_mob");
        mysqli_query($db,"INSERT into `$r_pb` (date_time, trans_type, user_type, amt) values (NOW(), '$r_trans_type', '$r_user_type', '$amt')");
        mysqli_query($db,"UPDATE balance SET bal=bal - $amt WHERE mob=$mob");
        mysqli_query($db,"INSERT into `$pb` (date_time, trans_type, user_type, amt) values (NOW(), '$s_trans_type', '$s_user_type', '$amt')");
      }
    }
  }
}

$result = mysqli_query($db,"SELECT bal FROM balance where mob = $mob");
$row = mysqli_fetch_assoc($result);
?>

<html>
<title>  Welcome | E-Wallet </title>
<link rel="stylesheet" href="css/welcome.css" TYPE="text/css"/>
<body>
<div id="bal">
  <form method="POST" name="refresh">
    <input type="text" name="balance" value= "&#8377; <?php echo $row['bal'];?>" step="0.01" readonly> <br> <br>
    <input type="submit" name="refresh_button" value="Refresh Balance"> <br>
  </form>
</div>

<div id="container">
  <div id="add_money">
    <img src="img/add.jpg" height="115px" width="115px"> <br> <br>
    <form method="POST" name="add_money_form">
    <input type="number" name="amount" placeholder="Add Money (&#8377)" step="0.01"> <br> <br>
    <input type="submit" name="add_money" value="Add">
  </form>
  </div>

  <div id="passbook">
    <img src="img/wallet.jpg" height="115px" width="115px"> <br> <br>
    <form method="POST" name="passbook_form">
    <input type="submit" name="passbook_button" value="Show Passbook">
    </form>
  </div>

  <div id="send_money">
      <img class="id1" src="img/send.jpg"/ height="115px" width="115px"> <br> <br>
      <form method="POST" name="send_money_form">
      <input type="text" name="receiver" placeholder="Mobile Number" minlength=10 maxlength=10 required> <br> <br>
      <input type="text" name="send_amt" placeholder="Amount (&#8377)" required> <br> <br>
      <input type="submit" name="send_money" value="Send">
      </form>

  </div>
</div>

<div id="logout">
<form action="profile.php" method="POST" name="profile_form">
<input type="submit" value='Edit Profile'>
</form>
<form action="login.php" method="POST" name="logout_form">
  <input type="submit" name="logout_button" value="Log Out">
</form> <br><br>
</div>
</body>
</html>
