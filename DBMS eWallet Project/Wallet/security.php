<?php
  session_start();
  $db = mysqli_connect('localhost', 'root', '', 'wallet');
  if($db==false)
    die('Sorry, server is not available at this moment. Please Try again later.');
  $mob = $_SESSION['pass_mob'];
  $result = mysqli_query($db, "SELECT question, answer FROM user_info WHERE mob=$mob");
  $row = mysqli_fetch_assoc($result);
  $que = $row['question'];

  if(isset($_POST['submit']))
  {
    if($row['answer'] == $_POST['answer'])
      header('Location: new_pass.php');
    else
      echo 'Answer doesnt match!';
  }
 ?>
<html>
<title> Change Password | E-Wallet </title>
<link rel="stylesheet" href="css/security.css" TYPE="text/css"/>
<body>
<div id="security_form">
  <h1> Security Question </h1> <br> <br>
  <form method="POST">
    <input type = "text" name="question" value="<?php echo $que ?>" readonly> <br><br>
    <input type = "text" name = "answer" placeholder="Answer" required> <br><br>
    <input type = "submit" value="SUBMIT" name="submit">
  </form>
</div>
</body>
</html>
