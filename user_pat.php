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
WHERE i.item_type='พัสดุ'";
$result = $con->prepare($sql);
$result->execute();
?>
<h1>ตรวจสอบพัสดุ</h1>

<table class="table table-bordered table-hover table-striped">
	<thead>
		<tr>
			<th>ลำดับ</th>
			<th>รายการ</th>
			<th>หน่วย</th>
			<th>Serial</th>
			<th>เลขพัสดุ</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$i=1;
	while($rs=$result->fetch()){?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $rs['name'];?></td>
			<td><?php echo $rs['unit'];?></td>
			<td><?php echo $rs['serial_no'];?></td>
			<td><?php echo $rs['item_code'];?></td>
		</tr>
	<?php }?>
	</tbody>
</table>

<?php
include 'html_foot.php';
?>