<?php
if(!isset($_SESSION)){
	session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'dbcon.php';

$sql = "SELECT SUM(wd.widen_amount) AS wa, i.*,u.unit
FROM widen_detail wd 
LEFT JOIN item i ON i.id = wd.item_id
LEFT JOIN unit u ON u.id = i.unit_id
WHERE i.item_type='วัสดุ'
GROUP BY wd.item_id";
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
              "<html><head><title>รายงานการเบิกวัสดุ</title></head><body>" + 
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
<h2>รายงานการเบิกวัสดุ</h2>

<div class="table-responsive">
<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>ลำดับ</th>
			<th>รายการ</th>
			<th>จำนวนเบิก</th>
			<th>จำนวนคงเหลือ</th>
			<th>จำนวนทั้งหมด</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$i=1;
	while($rs = $result->fetch()){ ?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $rs['name'];?></td>
			<td><?php echo $rs['wa'];?></td>
			<td><?php echo $rs['in_stock'];?></td>
			<td><?php echo $rs['all_stock'];?></td>
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