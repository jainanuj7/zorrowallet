<html>
<title> Forgot Password | E-Wallet </title>
<link rel="stylesheet" href="css/forgot.css" TYPE="text/css"/>

<body>
<div id="forgot_form">
  <h1> Forgot Password? </h1> <br> <br>
  <form method="POST">
  <input type = "text" name = "mob" placeholder="Mobile No" minlength=10 maxlength=10 required> <br><br>
  <input type = "submit" value="SUBMIT" name="submit"> <br> <br>
</div>
</body>
</html>

<?php
  $db = mysqli_connect('localhost', 'root', '', 'wallet');
  if($db==false)
    die('Sorry, server is not available at this moment. Please Try again later.');

  session_start();
  if(isset($_POST['mob']))
  {
    $result = mysqli_query($db, "SELECT * FROM user_credentials");
    if(mysqli_num_rows($result) < 1)
      echo 'Looks like you havent signed up yet, click <html> <a href = "signup.php">  here </a> to Sign Up for free!</html>';
    else
    {
      session_regenerate_id();
	    $_SESSION['pass_mob'] = $_POST['mob'];
      header("Location: security.php");
    }
  }
?>
