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
      <td width="71">ลำดับออเดอร์</td>
      <td width="217">
	  <?=$objResult["OrderID"];?></td>
    </tr>
    <tr>
      <td width="71">ชื่อออเดอร์</td>
      <td width="217">
	  <?=$objResult["OrderName"];?></td>
    </tr>
    <tr>
      <td>ชื่อสาขา</td>
      <td><?=$objResult["Major"];?></td>
    </tr>
    <tr>
      <td>เบอร์โทร</td>
      <td><?=$objResult["Tel"];?></td>
    </tr>
    <tr>
      <td>อีเมล์</td>
      <td><?=$objResult["Email"];?></td>
    </tr>
  </table>

  <br>

<table width="400"  border="1">
  <tr>
    <td width="101">ลำดับ</td>
    <td width="82">ชื่อวัสดุ</td>
    <td width="82">ราคา</td>
    <td width="79">จำนวน</td>
    <td width="79">ราคารวม</td>
  </tr>
<?php

$Total = 0;
$SumTotal = 0;

$strSQL2 = "SELECT * FROM orders_detail WHERE OrderID = '".$_GET["OrderID"]."' ";
$objQuery2 = mysql_query($strSQL2)  or die(mysql_error());

while($objResult2 = mysql_fetch_array($objQuery2))
{
		$strSQL3 = "SELECT * FROM item WHERE id = '".$objResult2["ID"]."' ";
		$objQuery3 = mysql_query($strSQL3)  or die(mysql_error());
		$objResult3 = mysql_fetch_array($objQuery3);
		$Total = $objResult2["Qty"] * $objResult3["price"];
		$SumTotal = $SumTotal + $Total;
	  ?>
	  <tr>
		<td><?=$objResult2["ID"];?></td>
		<td><?=$objResult3["name"];?></td>
		<td><?=$objResult3["price"];?></td>
		<td><?=$objResult2["Qty"];?></td>
		<td><?=number_format($Total,2);?></td>
	  </tr>
	  <?php
 }
  ?>
</table>

ราคารวมทั้งหมด : <?=number_format($SumTotal,2);?>

<?php
mysql_close();
?>

<body onLoad="window.print()">

</body>
</html>
