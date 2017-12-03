<html>
<title> Sign Up | E-Wallet </title>
<head> <link rel="stylesheet" href="css/signup.css" type="text/css"/> </head>

<body>
<div id="signup_form">
  <h1> Create a New Account </h1>
  <h4> It's free and always will be. </h4>
  <form action="signup.php" method="POST">
	<input type = "text" name = "fname" placeholder="First Name" required>
	<br><br><input type = "text" name = "lname" placeholder="Last Name" required> <br>
	<br><input type = "text" name = "mob" placeholder="Mobile No" minlength="10" maxlength="10" required> <br>
	<br><input type="password" name="pass" placeholder="Password" maxlength="20" required>
	<br><br><input type="password" name="pass2" placeholder="Confirm Password" maxlength="20" required> <br>
	<br>Date of Birth &nbsp;<input type="date" name="dob" required> <br> <br>
	<input type = "radio" name="gender" value="Male" required> Male&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;<input type = "radio" name="gender" value="Female" required> Female
  <br><br>
  	<select name="question">
  	<option value="What is your favorite teachers name?">What is your favorite teachers name?</option>
  	<option value="What is your pet name?">What is your pet name?</option>
  	<option value="Which is your favorite book?">Which is your favorite book?</option>
  	<option value="Who is your favorite cricketer?">Who is your favorite cricketer?</option>
		</select> <br><br>
	<input type = "text" name = "answer" placeholder="Answer" required>
  <br> <br>
  <input type = "checkbox" value = "agree" required> I agree to all terms & conditions. <br>
  <br>
  <input type = "submit" value="SIGN UP">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="reset" value="RESET">
  <br>
</div>

<?php
  $db = mysqli_connect('localhost', 'root', '', 'wallet');
  if($db==false)
    die('Sorry, server is not available at this moment. Please Try again later.');
  if(isset($_POST['fname']))
  {
    $mob = $_POST['mob'];
    $pass = md5($_POST['pass']);
    $confpass = md5($_POST['pass2']);
    if($pass == $confpass)
    {
      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $dob = $_POST['dob'];
      $gender = $_POST['gender'];
      $question = $_POST['question'];
      $answer = $_POST['answer'];
      $result = mysqli_query($db, "SELECT mob FROM user_info WHERE mob=$mob");
      if(mysqli_num_rows($result) > 0)
        echo 'Account already exists! Login <a href="login.php"> here </a>';
      else
      {
		$from = new DateTime($dob);
		$to   = new DateTime('today');
		$age = $from->diff($to)->y;
        mysqli_query($db,"INSERT INTO user_info (fname, lname, dob, gender, mob, question, answer, age) VALUES ('$fname', '$lname', '$dob', '$gender', $mob, '$question', '$answer', '$age')");
        mysqli_query($db,"INSERT INTO user_credentials (mob, pass) VALUES ($mob, '$pass')");
        mysqli_query($db,"INSERT INTO balance (mob, bal) VALUES ($mob, '0')");
        $pb="passbook_"."$mob";
        mysqli_query($db,"CREATE TABLE `$pb` (trans_id int primary key auto_increment, date_time datetime, trans_type char(20), user_type char(20), amt float) ");
        echo 'Account created successfully! Login <a href="login.php"> here </a><br><br>';
      }
    }
    else
      echo 'Password doesnt match! Try again';
  }
?>
</body>
</html>
