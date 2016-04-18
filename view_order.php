<html>
<head>
<title>เบิกวัสดุ</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
mysql_connect("localhost","pure_passadu","12345678");
mysql_select_db("pure_passadu");

$strSQL = "SELECT * FROM orders WHERE OrderID = '".$_GET["OrderID"]."' ";
$objQuery = mysql_query($strSQL)  or die(mysql_error());
$objResult = mysql_fetch_array($objQuery);
?>




 <table width="304" border="1">
    <tr>
      <td width="71">OrderID</td>
      <td width="217">
	  <?=$objResult["OrderID"];?></td>
    </tr>
    <tr>
      <td width="71">OrderName</td>
      <td width="217">
	  <?=$objResult["OrderName"];?></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><?=$objResult["Address"];?></td>
    </tr>
    <tr>
      <td>Tel</td>
      <td><?=$objResult["Tel"];?></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><?=$objResult["Email"];?></td>
    </tr>
  </table>

  <br>

<table width="400"  border="1">
  <tr>
    <td width="101">ID</td>
    <td width="82">Name</td>
    <td width="82">Price</td>
    <td width="79">Qty</td>
    <td width="79">Total</td>
  </tr>
<?php

$Total = 0;
$SumTotal = 0;

$strSQL2 = "SELECT * FROM orders_detail WHERE OrderID = '".$_GET["OrderID"]."' ";
$objQuery2 = mysql_query($strSQL2)  or die(mysql_error());

while($objResult2 = mysql_fetch_array($objQuery2))
{
		$strSQL3 = "SELECT * FROM item WHERE ID = '".$objResult2["ID"]."' ";
		$objQuery3 = mysql_query($strSQL3)  or die(mysql_error());
		$objResult3 = mysql_fetch_array($objQuery3);
		$Total = $objResult2["Qty"] * $objResult3["Price"];
		$SumTotal = $SumTotal + $Total;
	  ?>
	  <tr>
		<td><?=$objResult2["ID"];?></td>
		<td><?=$objResult3["Name"];?></td>
		<td><?=$objResult3["Price"];?></td>
		<td><?=$objResult2["Qty"];?></td>
		<td><?=number_format($Total,2);?></td>
	  </tr>
	  <?php
 }
  ?>
</table>
Sum Total <?=number_format($SumTotal,2);?>

<?php
mysql_close();
?>

<body onLoad="window.print()">

</body>
</html>

