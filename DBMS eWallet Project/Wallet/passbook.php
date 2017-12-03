<html>
<title>  Passbook | E-Wallet </title>
<head><link rel="stylesheet" href="css/welcome.css" TYPE="text/css"/></head><h1> </h1>
<div id="logout">
<br> <h1> PASSBOOK </h1> <br>

<?php
error_reporting(0);
session_start();
$db = mysqli_connect('localhost', 'root', '', 'wallet');
if($db==false)
  die('Sorry, server is not available at this moment. Please Try again later.');

$mob = $_SESSION['curr_mob'];
$pb = $_SESSION['pb'];
$result = mysqli_query($db,"SELECT * FROM `$pb`");

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
echo "<tr><th>TIME</th><th>TRANSACTION</th><th>AMOUNT(&#8377)</th></tr>";
while($row = mysqli_fetch_array($result))
{
  echo "<tr>";

  echo "<td>";
  echo $row['date_time'];
  echo "</td>";

  echo "<td>";
  echo $row['trans_type']." ".$row['user_type'];
  echo "</td>";

  echo "<td>";
  echo $row['amt'];
  echo "</td>";

  echo "</tr>";

}
echo"</table>";
echo "</center>";

 ?>

<br><br>
<form action="welcome.php" method="POST" name="back_form">
  <input type="submit" name="back_button" value="BACK">
</form> <br><br>
</div>
</html>
