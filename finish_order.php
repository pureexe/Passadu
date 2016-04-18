<html>
<head>
<title>ThaiCreate.Com</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
if(!isset($_SESSION)){
	session_start();
}

include 'html_head.php';

//print_r($_SESSION['user']);
?>

Finish Your Order. <br><br>

<a href="view_order.php?OrderID=<?=$_GET["OrderID"];?>">View Order</a>

</body>
</html>
<?php
include 'html_foot.php';
?>

