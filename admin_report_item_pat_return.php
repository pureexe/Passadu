<?php
if(!isset($_SESSION)){
	session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'dbcon.php';

$sql = "SELECT SUM(wd.widen_amount) AS wa, wd.return_date,wd.is_return,
i.*,
us.firstname,us.lastname,
w.widen_date
FROM widen_detail wd 
LEFT JOIN item i ON i.id = wd.item_id
LEFT JOIN widen w ON w.id = wd.widen_id
LEFT JOIN user us ON us.id = w.user_id
WHERE i.item_type='พัสดุ' AND wd.is_return='คืนแล้ว'

GROUP BY wd.item_id
ORDER BY wd.is_return ASC
";
$result = $con->prepare($sql);
$result->execute();
?>
<script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title>รายงานการคืนพัสดุ</title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
    </script>
    <div class="text-right">
    	<a href="#" id="click_to_print" class="btn btn-success" onclick="javascript:printDiv('print')">พิมพ์</a>
    </div>
<div id="print">
<h2>รายงานการคืนพัสดุ</h2>

<div class="table-responsive">
<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>ลำดับ</th>
			<th>รายการ</th>
			<th>ผู้ยืม</th>
			<th>วันที่ยืม</th>
			<th>วันที่คืน</th>
			<th>สถานะ</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$i=1;
	while($rs = $result->fetch()){ ?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $rs['name'];?></td>
			<td><?php echo $rs['firstname'];?> <?php echo $rs['lastname'];?></td>
			<td><?php echo $rs['widen_date'];?></td>
			<td><?php echo $rs['return_date'];?></td>
			<td><?php echo $rs['is_return'];?></td>
		</tr>
	<?php }?>
	</tbody>
</table>
</div>
<br><br><br><br><br>
<p style="text-align:right">
ลงชื่อ.........................................<br><br>
(...............................................)<br>
ผู้รายงาน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>
</div>
<?php
include 'html_foot.php';
?>