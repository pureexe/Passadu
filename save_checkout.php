<?php
session_start();
require_once("db.inc.php");
//TODO: Change minus catch to friendly message
//Check is not minus
for($i=0;$i<=(int)$_SESSION["intLine"];$i++){
  if($_SESSION["strID"][$i] != ""){
    $strSQL = "SELECT in_stock FROM item WHERE ID='".$_SESSION["strID"][$i]."'";
    $result = mysql_query($strSQL) or die(mysql_error());
    $row = mysql_fetch_assoc($result);
    if($row["in_stock"]<$_SESSION["strQty"][$i]){
      header("location:checkout.php?error=minus&id=".$_SESSION["strID"][$i]);
      exit();
    }
  }
}
// Decrease in_stock
for($i=0;$i<=(int)$_SESSION["intLine"];$i++){
  if($_SESSION["strID"][$i] != ""){
    $strSQL = "UPDATE item SET `in_stock`=(`in_stock`-".$_SESSION["strQty"][$i].") WHERE `id` = '".$_SESSION["strID"][$i]."'";
    mysql_query($strSQL) or die(mysql_error());
  }
}

// Insert Order
$Total = 0;
$SumTotal = 0;

$strSQL = "
INSERT INTO orders (OrderDate,OrderName,Address,Tel,Email)
VALUES
('".date("Y-m-d H:i:s")."','".$_POST["txtOrderName"]."','".$_POST["txtAddress"]."','".$_POST["txtTel"]."','".$_POST["txtEmail"]."')
";
mysql_query($strSQL) or die(mysql_error());

$strOrderID = mysql_insert_id();
for($i=0;$i<=(int)$_SESSION["intLine"];$i++){
  if($_SESSION["strID"][$i] != ""){
		  $strSQL = "
			INSERT INTO orders_detail (OrderID,ID,Qty)
			VALUES
			('".$strOrderID."','".$_SESSION["strID"][$i]."','".$_SESSION["strQty"][$i]."')
		  ";
		  mysql_query($strSQL) or die(mysql_error());
	}
}

mysql_close();
session_destroy();
header("location:finish_order.php?OrderID=".$strOrderID);
?>
