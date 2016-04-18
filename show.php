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
<table width="400"  border="1">
  <tr>
    <td width="101">ID</td>
    <td width="82">Name</td>
    <td width="82">Price</td>
    <td width="79">Qty</td>
    <td width="79">Total</td>
    <td width="10">Del</td>
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
		<td><a href="delete.php?Line=<?=$i;?>">x</a></td>
	  </tr>
	  <?php
	  }
  }
  ?>
</table>
Sum Total <?=number_format($SumTotal,2);?>
<br><br><a href="user_widen.php">Go to item </a>
<?php
	if($SumTotal > 0)
	{
?>
	| <a href="checkout.php">CheckOut</a>
<?php
	}
?>
<?php
mysql_close();
?>
</body>
</html>

<?php
include 'html_foot.php';
?>