<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'dbcon.php';

$sql = "SELECT o.*,u.firstname,u.lastname FROM order_item o 
	LEFT JOIN user u ON u.id = o.user_id
	WHERE o.id=:id";
$result = $con->prepare($sql);
$result->execute(array('id'=>$_GET['id']));
$rs = $result->fetch();

$sqld = "SELECT * FROM order_detail od 
	LEFT JOIN item i ON i.id = od.item_id
	WHERE od.order_id=:order_id";
$resultd = $con->prepare($sqld);
$resultd->execute(array('order_id'=>$_GET['id']));
?>
<h3>ข้อมูลการสั่งซื้อ</h3>
<table class="table table-bordered">
	<tr>
		<td>รหัสการสั่งซื้อ</td>
		<td><?php echo $rs['id'];?></td>
	</tr>
	<tr>
		<td>ผู้สั่งซื้อ</td>
		<td><?php echo $rs['firstname'];?> <?php echo $rs['lastname'];?></td>
	</tr>
	<tr>
		<td>วันที่สั่งซื้อ</td>
		<td><?php echo $rs['order_date'];?></td>
	</tr>
</table>

<h3>รายการสั่งซื้อ</h3>
<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>รายการ</th>
			<th>รหัสพัสดุ</th>
			<th>เลข Serial</th>
			<th>รหัสพัสดุ</th>
			<th>จำนวน</th>
			<th>สถานะ</th>
		</tr>
	</thead>
	<tbody>
	<?php while($rsd = $resultd->fetch()){?>
		<tr>
			<td><?php echo $rsd['name'];?></td>
			<td><?php echo $rsd['item_code'];?></td>
			<td><?php echo $rsd['serial_no'];?></td>
			<td><?php echo $rsd['item_code'];?></td>
			<td><?php echo $rsd['order_amount'];?></td>
			<td><?php echo $rsd['item_status'];?></td>
		</tr>
	<?php }?>
	</tbody>
</table>
<?php
include 'html_foot.php';
?>