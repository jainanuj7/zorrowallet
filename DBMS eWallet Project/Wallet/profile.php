<?php
$db=mysqli_connect("localhost","root","","wallet");

if($db==false)
	die("Database connection cannot be established");


session_start();
$mob = $_SESSION['curr_mob'];
$result=mysqli_query($db,"select * from user_info where mob=$mob");
$row=mysqli_fetch_assoc($result);

if(isset($_POST['submit_button']))
{
	$flag="0";
	if($_POST['fname']!=$row['fname'])
	{
		$flag="1";
		$temp=$_POST['fname'];
		mysqli_query($db,"update user_info set fname = '$temp' where mob=$mob");
	}

	if($_POST['lname']!=$row['lname'])
	{
		$flag="1";
		$temp=$_POST['lname'];
		mysqli_query($db,"update user_info set lname = '$temp' where mob=$mob");
	}

	if($_POST['dob']!=$row['dob'])
	{
		$flag="1";
		$temp=$_POST['dob'];
		mysqli_query($db,"update user_info set dob = '$temp' where mob=$mob");
	}

	if($_POST['mob']!=$row['mob'])
	{
		$flag="1";
		$temp=$_POST['mob'];
		$old="passbook_".$row['mob'];
		$new="passbook_".$temp;
		$result = mysqli_query($db, "SELECT mob FROM user_info WHERE mob=$temp");
		if(mysqli_num_rows($result) > 0)
			echo "Mobile no. already exists. Try another number!";
		else
		{
			mysqli_query($db,"update user_info set mob = '$temp' where mob=$mob");
			mysqli_query($db,"update user_credentials set mob = '$temp' where mob=$mob");
			mysqli_query($db,"update balance set mob = '$temp' where mob=$mob");
			mysqli_query($db,"alter table $old rename to $new ");
			$_SESSION['curr_mob']=$temp;
			$mob = $_SESSION['curr_mob'];
		}
	}

	if($_POST['question']!=$row['question'])
	{
		$flag="1";
		$temp=$_POST['question'];
		mysqli_query($db,"update user_info set question = '$temp' where mob=$mob");
	}

	if($_POST['answer']!=$row['answer'])
	{
		$flag="1";
		$temp=$_POST['answer'];
		mysqli_query($db,"update user_info set answer = '$temp' where mob=$mob");
	}

	if(!(empty($_POST['new_pass']) || empty($_POST['new_pass2'])))
	{
		if($_POST['new_pass']==$_POST['new_pass2'])
		{
			$flag="1";
			$temp=md5($_POST['new_pass']);
			mysqli_query($db, "UPDATE user_credentials set pass='$temp' WHERE mob=$mob");
		}
	}

}

$result=mysqli_query($db,"select * from user_info where mob=$mob");
$row=mysqli_fetch_assoc($result);
?>

<html>
<title> Edit Profile | E-Wallet </title>
<head> <link rel="stylesheet" href="css/profile.css" type="text/css" ><title>Profile</title></head>
<body>
<br><br>
<div id="d1">

<form action=profile.php method=post>
<h1> Edit Profile </h1> <br>
First name:
<br>
<input type="text" value="<?php echo $row['fname']?>" name=fname required>
<br>
<br>
Last name:
<br>
<input type="text" value="<?php echo $row['lname'] ?>" name=lname required>

<br>

<br>
Date of Birth:<br><input type=date value="<?php echo $row['dob'] ?>" name=dob required>
<br><br>
Mobile Number:<br>
<input type=`text` value="<?php echo $row['mob']?>" name=mob minlength=10 maxlength=10 required>
<br>
<br>

Question:<br>
<select name=question  required>
	<option value="<?php echo $row['question'] ?>"><?php echo $row['question']?></option>
	<option value="What is your favorite teacher name?">What is your favorite teacher's name?</option>
	<option value="What is your pet name?">What is your pet name?</option>
	<option value="Which is your favorite book?">Which is your favorite book?</option>
	<option value="Who is your favorite cricketer?">Who is your favorite cricketer?</option>
</select>
<br><br>
Answer:<br>
<input type=text value="<?php echo $row['answer']?>" name=answer required>
<br><br>

Change Password:<br>

<input type=password name=new_pass placeholder='New Password'>
<br><br>
<input type=password name=new_pass2 placeholder='Confirm New Password'>
<br><br>

<input type=submit name=submit_button value="Submit">
</form>
<form action="welcome.php">
<input type=submit name=submit_button2 value="Back">
</form>
</div>
<?php
if(isset($_POST['submit_button']))
{
	if($flag=="1")
		echo "Successfully Changed";
}
?>

</body>
</html>
