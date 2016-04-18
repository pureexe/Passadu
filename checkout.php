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
<?php
  if($_GET["error"]=="minus"){
    ?>
    <div class="alert alert-danger" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">ผิดพลาด:</span>
      จำนวนของที่เบิกมีมากกว่าจำนวนของที่มีอยู่ในคลัง
    </div>
    <?php
  }
?>
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

  for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
  {
	  if($_SESSION["strID"][$i] != "")
	  {
		$strSQL = "SELECT * FROM item WHERE ID = '".$_SESSION["strID"][$i]."' ";
		$objQuery = mysql_query($strSQL)  or die(mysql_error());
		$objResult = mysql_fetch_array($objQuery);
		$Total = $_SESSION["strQty"][$i] * $objResult["Price"];
		$SumTotal = $SumTotal + $Total;
	  ?>
	  <tr>
		<td><?=$_SESSION["strID"][$i];?></td>
		<td><?=$objResult["Name"];?></td>
		<td><?=$objResult["Price"];?></td>
		<td><?=$_SESSION["strQty"][$i];?></td>
		<td><?=number_format($Total,2);?></td>
	  </tr>
	  <?php
	  }
  }
  ?>
</table>
Sum Total <?=number_format($SumTotal,2);?>
<br><br>
<form name="form1" method="post" action="save_checkout.php">
  <table width="304" border="1">
    <tr>
      <td width="71">OrderName</td>
      <td width="217"><input type="text" name="txtOrderName"></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><textarea name="txtAddress"></textarea></td>
    </tr>
    <tr>
      <td>Tel</td>
      <td><input type="text" name="txtTel"></td>
    </tr>
    <tr>
      <td>Email</td>
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
