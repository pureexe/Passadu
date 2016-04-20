<?php
if(!isset($_SESSION)){
    session_start();
}

include 'html_head.php';

?>
<html>
<head>
<title>ThaiCreate.Com</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
mysql_connect("localhost","pure_passadu","12345678");
mysql_select_db("pure_passadu");

?>
<table width="536"  border="1">
  <tr>
    <td width="37" align="center">ลำดับ</td>
    <td width="156" align="center">ชื่อวัสดุ</td>
    <td width="78" align="center">ราคาวัสดุ</td>
    <td width="53" align="center">จำนวน</td>
    <td width="102" align="center">ราคารวม</td>
    <td width="70" align="center">ลบรายการ</td>
  </tr>
  <?php
  $Total = 0;
  $SumTotal = 0;

  for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
  {
	  if($_SESSION["strID"][$i] != "")
	  {
		$strSQL = "SELECT * FROM item WHERE id = '".$_SESSION["strID"][$i]."' ";
		$objQuery = mysql_query($strSQL)  or die(mysql_error());
		$objResult = mysql_fetch_array($objQuery);
		$Total = $_SESSION["strQty"][$i] * $objResult["price"];
		$SumTotal = $SumTotal + $Total;
	  ?>
	  <tr>
		<td height="23" align="center"><?=$_SESSION["strID"][$i];?></td>
		<td align="center"><?=$objResult["name"];?></td>
		<td align="center"><?=$objResult["price"];?></td>
		<td align="center"><?=$_SESSION["strQty"][$i];?></td>
		<td align="center"><?=number_format($Total,2);?></td>
		<td align="center"><a href="delete.php?Line=<?=$i;?>">ลบ</a></td>
	  </tr>
	  <?php
	  }
  }
  ?>
</table>
<p>&nbsp;</p>
<p>ราคารวมทั้งหมด :
  <?=number_format($SumTotal,2);?>
  <br><br>
  <a href="user_widen.php">ไปยังหน้าเลือกรายการ </a>
  <?php
	if($SumTotal > 0)
	{
?>
  | <a href="checkout.php">ทำรายการที่เลือก</a>
  <?php
	}
?>
  <?php
mysql_close();
?>
  </body>
  </html>
</p>
<?php
include 'html_foot.php';
?>
