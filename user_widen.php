<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_login();
include 'html_head.php';
include 'dbcon.php';
date_default_timezone_set('Asia/Bangkok');
?>


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
mysql_set_charset('utf8');

$strSQL = "SELECT * FROM item WHERE major_id=".$_SESSION["user"]["major_id"];
$objQuery = mysql_query($strSQL)  or die(mysql_error());
?>
<table width="483"  border="1">
  <tr>
    <td width="37" align="center">ลำดับ</td>
    <td width="177" align="center">ชื่อวัสดุ</td>
    <td width="101" align="center">ราคาวัสดุ</td>
    <td width="140" align="center">รายการ</td>
  </tr>
  <?php
  while($objResult = mysql_fetch_array($objQuery))
  {
  ?>
  <tr>
	<td align="center"><?=$objResult["id"];?></td>
    <td align="center"><?=$objResult["name"];?></td>
    <td align="center"><?=$objResult["price"];?></td>
    <td align="center"><a href="order.php?ID=<?=$objResult["id"];?>">เลือก</a></td>
  </tr>
  <?php
  }
  ?>
</table>
<p><br>
  <br>
  <a href="show.php">ดูรายการวัสดุที่เลือก</a> | <a href="clear.php">ออกจากระบบ</a>
  <?php
mysql_close();
?>
</p>
<p>&nbsp;</p>
</body>
</html>
