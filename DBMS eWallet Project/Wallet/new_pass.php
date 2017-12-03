<?php
session_start();
$mob = $_SESSION['pass_mob'];
$db = mysqli_connect('localhost', 'root', '', 'wallet');
if($db==false)
  die('Sorry, server is not available at this moment. Please Try again later.');
if(isset($_POST['submit']))
{
  if($_POST['new_pass'] == $_POST['new_pass2'])
  {
    $new_pass = md5($_POST['new_pass']);
    mysqli_query($db, "UPDATE user_credentials set pass='$new_pass' WHERE mob=$mob");
    echo 'Password changed successfully! Login <a href="login.php"> here </a><br><br>';
  }
  else
    echo 'Password doesnt match. Try again <br><br>';
}
?>
<html>
<title> Change Password | E-Wallet </title>
<link rel="stylesheet" href="css/new_pass.css" TYPE="text/css"/>
<body>
<div id="new_pass_form">
  <h1> Change Password </h1> <br> <br>
  <form method="POST">
    <input type="password" name="new_pass" placeholder="New Password" required> <br> <br>
    <input type="password" name="new_pass2" placeholder="Confirm New Password" required><br><br>
    <input type="submit" name="submit" value="CHANGE PASSWORD">
  </form>
</div>
</body>
</html>
