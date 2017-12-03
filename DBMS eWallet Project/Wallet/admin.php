<?php
	error_reporting(0);
	session_start();
	if(empty($_SESSION['curr_mob']=="admin"))
		die('Unauthorized Access');
?>
<html>
<title> Admin Panel | E-Wallet </title>
<link rel="stylesheet" href="css/admin.css" TYPE="text/css"/>
<body>
<div id="admin_form">
	<br><br> <h1> Welcome Admin! </h1> <br>
	<form method="POST">
	<br><input type = "text" name = "mob" placeholder="Enter mob. no. to delete" minlength="10" maxlength="10" required>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type = "submit" value="DELETE" name = "submit">
	</form>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<form action="login.php" method="POST" name="logout_form">
		<input type="submit" name="logout_button" value="Log Out">
	</form> <br>
</div>
</body>
</html>

<?php
	$db = mysqli_connect('localhost', 'root', '', 'wallet');
	if($db==false)
	  die('Sorry, server is not available at this moment. Please Try again later.');
	session_start();
	if($_SESSION['curr_mob']=="admin")
	{
		if(isset($_POST['mob']))
		{
			$del = $_POST['mob'];
			$result = mysqli_query($db,"SELECT mob FROM user_info WHERE mob='$del'");
			if(mysqli_num_rows($result) > 0)
			{
				$pb = 'passbook_'.$del;
				mysqli_query($db,"DELETE FROM user_info WHERE mob='$del'");
				mysqli_query($db,"DELETE FROM user_credentials WHERE mob='$del'");
				mysqli_query($db,"DELETE FROM balance WHERE mob='$del'");
				mysqli_query($db,"DROP TABLE `$pb`");
				echo "User deleted successfully!"."<br><br>";
				
			}
			
			else
				echo "User does not exist! Try Again!"."<br><br>";
		}
		
		$result = mysqli_query($db,"SELECT fname, lname, mob FROM user_info");
		echo "<center>";
		echo "<style>
		table {
			border-collapse: collapse;
		}

		th, td {
			padding: 10px;
			padding-left: 50px;
			padding-right: 50px;
			text-align: left;
			border-bottom: 1px solid #ddd;
			font-size: 20px;
			font-family: Arial, Helvetica, sans-serif;
		}

		tr:hover{background-color:#f5f5f5}
		</style>";
		echo "<table>";
		echo "<tr><th>NAME</th><th>MOBILE NO.</th></tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		  echo "<tr>";

		  echo "<td>";
		  echo $row['fname']." ".$row['lname'];
		  echo "</td>";

		  echo "<td>";
		  echo $row['mob'];
		  echo "</td>";

		  echo "</tr>";
		}
		echo"</table>";
		echo "</center>";
		
	}
	
?>

