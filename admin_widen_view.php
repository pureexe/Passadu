<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'dbcon.php';

$sql = "SELECT w.*,u.firstname,u.lastname,m.major FROM widen w
	JOIN user u ON u.id = w.user_id
  JOIN major m ON m.major_id = u.major_id
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
    <td>สาขา</td>
    <td><?php echo $rs['major'];?></td>
	<tr>
		<td>วันที่เบิก</td>
		<td><?php echo $rs['widen_date'];?></td>
	</tr>
</table>

<h3>รายการเบิก</h3>
<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>ประเภท</th>
			<th>รายการ</th>
			<th>รหัสวัสดุ</th>
			<th>เลข Serial</th>
			<th>จำนวน</th>
			<th>วันที่คืน</th>
				</tr>
	</thead>
	<tbody>
	<?php while($rsd = $resultd->fetch()){?>
		<tr>
			<td><?php echo $rsd['item_type'];?></td>
			<td><?php echo $rsd['name'];?></td>
			<td><?php echo $rsd['item_code'];?></td>
			<td><?php echo $rsd['serial_no'];?></td>
			<td><?php echo $rsd['widen_amount'];?></td>
			<td><?php echo $rsd['return_date'];?></td>
			<td><?php echo $rsd['is_return'];?></td>
		</tr>
	<?php }?>
	</tbody>
</table>
<?php
include 'html_foot.php';
?>
