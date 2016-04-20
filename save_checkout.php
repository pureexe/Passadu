<?php
session_start();

date_default_timezone_set('Asia/Bangkok');

mysql_connect("localhost","pure_passadu","12345678");
mysql_select_db("pure_passadu");


  $Total = 0;
  $SumTotal = 0;

  $strSQL = "
	INSERT INTO orders (OrderDate,OrderName,Major,Tel,Email)
	VALUES
	('".date("Y-m-d H:i:s")."','".$_POST["txtOrderName"]."','".$_POST["txtMajor"]."','".$_POST["txtTel"]."','".$_POST["txtEmail"]."')
  ";
  mysql_query($strSQL) or die(mysql_error());

  $strOrderID = mysql_insert_id();

  for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
  {
	  if($_SESSION["strID"][$i] != "")
	  {
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
