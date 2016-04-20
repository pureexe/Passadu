<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'dbcon.php';

$sql = "SELECT w.*,u.firstname,u.lastname FROM widen w 
	LEFT JOIN user u ON u.id = w.user_id
	WHERE w.id=:id";
$result = $con->prepare($sql);
$result->execute(array('id'=>$_GET['id']));
$rs = $result->fetch();

$sqld = "SELECT * FROM widen_detail wd 
	LEFT JOIN item i ON i.id = wd.item_id
	WHERE wd.widen_id=:widen_id";
$resultd = $con->prepare($sqld);
$resultd->execute(array('widen_id'=>$_GET['id']));
?>
<h3>ข้อมูลการเบิก</h3>
<table class="table table-bordered">
	<tr>
		<td>รหัสการเบิก</td>
		<td><?php echo $rs['id'];?></td>
	</tr>
	<tr>
		<td>ผู้เบิก</td>
		<td><?php echo $rs['firstname'];?> <?php echo $rs['lastname'];?></td>
	</tr>
	<tr>
		<td>วันที่เบิก</td>
		<td><?php echo $rs['widen_date'];?></td>
	</tr>
</table>

<h3>รายการเบิก</h3>
<table width="367" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>รายการ</th>
			<th>รหัสวัสดุ</th>
			<th>เลข Serial</th>
			<th>จำนวน</th>
			</tr>
	</thead>
	<tbody>
	<?php while($rsd = $resultd->fetch()){?>
		<tr>
			<td><?php echo $rsd['name'];?></td>
			<td><?php echo $rsd['item_code'];?></td>
			<td><?php echo $rsd['serial_no'];?></td>
			<td colspan="2"><?php echo $rsd['widen_amount'];?></td>
		</tr>
	<?php }?>
	</tbody>
</table>
<?php
include 'html_foot.php';
?>