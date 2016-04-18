<?php
if(!isset($_SESSION)){
	session_start();
}
include 'function.php';
is_login();
include 'html_head.php';
include 'dbcon.php';

//print_r($_SESSION['user']);
$sql = "SELECT * FROM item i 
LEFT JOIN unit u ON u.id = i.unit_id
WHERE i.item_type='วัสดุ'";
$result = $con->prepare($sql);
$result->execute();
?>
<h1>ตรวจสอบวัสดุคงเหลือ</h1>

<table class="table table-bordered table-hover table-striped">
	<thead>
		<tr>
			<th>ลำดับ</th>
			<th>รายการ</th>
			<th>คงเหลือ</th>
			<th>หน่วย</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$i=1;
	while($rs=$result->fetch()){?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $rs['name'];?></td>
			<td><?php echo $rs['in_stock'];?></td>
			<td><?php echo $rs['unit'];?></td>
		</tr>
	<?php }?>
	</tbody>
</table>

<?php
include 'html_foot.php';
?>