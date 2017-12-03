<html>
<title> Log In | E-Wallet </title>
<link rel="stylesheet" href="css/login.css" TYPE="text/css"/>
<body>
<div id="login_form">
	<br><br> <h1> Log In </h1> <br>
	<img src="img/login_logo.jpg">
	<form method="POST">
	<br><input type = "text" name = "mob" placeholder="Mobile No" maxlength="10" required> <br>
	<br><input type = "password" name = "pass" placeholder="Password" required> <br> <br>
	<input type = "submit" value="LOGIN" name = "submit"> <br> <br>
	<a href="signup.php">Sign up?</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="forgot.php">Forgot Password?</a>
</div>
</body>
</html>

<?php
session_start();
if(isset($_POST['logout_button']))
{
  session_destroy();
  echo "Successfully logged out!";
}
$db = mysqli_connect('localhost', 'root', '', 'wallet');
if($db==false)
  die('Sorry, server is not available at this moment. Please Try again later.');
if(isset($_POST['submit']))
{
  $mob = $_POST["mob"];
  $pass = md5($_POST['pass']);
  if($mob == "admin" && $_POST['pass'] == "admin")
  {
	 session_regenerate_id();
	 $_SESSION['curr_mob'] = $mob;
	 header("Location: admin.php");
  }
	
  $query = "SELECT pass FROM user_credentials where mob = $mob";
  $result = mysqli_query($db, $query);
  if(mysqli_num_rows($result) > 0)
  {
		while($row = mysqli_fetch_assoc($result))
  	{
    	if($pass == $row['pass'])
	    {
				session_regenerate_id();
	     	$_SESSION['curr_mob'] = $mob;
	    	header("Location: welcome.php");
	    }
  	}
		echo 'Invalid username/password';
	}
  else
    echo 'Looks like you havent signed up yet, click <html> <a href = "signup.php">  here </a> to Sign Up for free!</html>';
}
?>
