<?php
if(!isset($_SESSION)){
    session_start();
}

include 'html_head.php';

?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
mysql_connect("localhost","pure_passadu","12345678");
mysql_select_db("pure_passadu");
?>
<!-- ############### การแจ้งเตือน ############# -->
<?php if(isset($_SESSION['flash'])){ ?>
<div class="alert alert-<?php echo $_SESSION['flash']['type'];?>">
    <?php echo ucfirst($_SESSION['flash']['type']).' '.$_SESSION['flash']['msg'];?>
</div>
<?php
unset($_SESSION['flash']);
}?>
<table width="430"  border="1">
  <tr>
    <td width="47" align="center">ลำดับ</td>
    <td width="152" align="center">ชื่อวัสดุ</td>
    <td width="57" align="center">ราคา</td>
    <td width="76" align="center">จำนวน</td>
    <td width="64" align="center">ราคารวม</td>
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
		<td align="center"><?=$_SESSION["strID"][$i];?></td>
		<td align="center"><?=$objResult["name"];?></td>
		<td align="center"><?=$objResult["price"];?></td>
		<td align="center"><?=$_SESSION["strQty"][$i];?></td>
		<td align="center"><?=number_format($Total,2);?></td>
	  </tr>
	  <?php
	  }
  }
  ?>
</table>
<p>&nbsp;</p>
<p>ราคารวมทั้งหมด :
  <?=number_format($SumTotal,2);?>
  <br>
</p>
<form name="form1" method="post" action="save_checkout.php">
  <table width="343" border="1">
    <tr>
      <td width="95">ชื่อรายการ :</td>
      <td width="277"><input type="text" name="txtOrderName"></td>
    </tr>
    <tr>
      <td>สาขา :</td>
      <td><input type="text" name="txtMajor" id="txtMajor" value="<?php echo $_SESSION["user"]["major"]; ?>"></td>
    </tr>
    <tr>
      <td>เบอร์โทร :</td>
      <td><input type="text" name="txtTel" value="<?php echo $_SESSION["user"]["tel"]; ?>"></td>
    </tr>
    <tr>
      <td>อีเมล์ :</td>
      <td><input type="text" name="txtEmail"></td>
    </tr>
  </table>
    <input type="submit" name="Submit" value="Submit">
</form>
<?php
mysql_close();
?>
</body>
</html>
