<?php
//session_start();
//session_destroy();
?>  
<html>
<head>
<title>ThaiCreate.Com</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
mysql_connect("localhost","pure_passadu","12345678");
mysql_select_db("pure_passadu");
$strSQL = "SELECT * FROM item";
$objQuery = mysql_query($strSQL)  or die(mysql_error());
?>
<table width="327"  border="1">
  <tr>
    <td width="101">Picture</td>
    <td width="200">ID</td>
    <td width="200">Name</td>
    <td width="200">Price</td>
    <td width="200">Cart</td>
  </tr>
  <?php
  while($objResult = mysql_fetch_array($objQuery))
  {
  ?>
  <tr>
	<td><img src="img/<?=$objResult["Picture"];?>"></td>
    <td><?=$objResult["ID"];?></td>
    <td><?=$objResult["Name"];?></td>
    <td><?=$objResult["Price"];?></td>
    <td><a href="order.php?ID=<?=$objResult["ID"];?>">Order</a></td>
  </tr>
  <?php
  }
  ?>
</table>
<br><br><a href="show.php">View Cart</a> | <a href="clear.php">Clear Cart</a>
<?php
mysql_close();
?>
</body>
</html>

<?/* This code download from www.ThaiCreate.Com */ ?>