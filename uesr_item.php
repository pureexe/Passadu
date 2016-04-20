<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_login();
include 'html_head.php';
include 'dbcon.php';

$name	= null; // กำหนดค่าเริ่มต้นของ $name
$unit_id	= null; // กำหนดค่าเริ่มต้นของ $unit_id
$serial_no	= null; // กำหนดค่าเริ่มต้นของ $serial_no
$item_code	= null; // กำหนดค่าเริ่มต้นของ $item_code
$in_stock	= null; // กำหนดค่าเริ่มต้นของ $in_stock
$item_detail	= null; // กำหนดค่าเริ่มต้นของ $item_detail
$price	= null; // กำหนดค่าเริ่มต้นของ $price
$all_stock	= null; // กำหนดค่าเริ่มต้นของ $all_stock
$item_type	= null; // กำหนดค่าเริ่มต้นของ $item_type
$item_status	= null; // กำหนดค่าเริ่มต้นของ $item_status

################### การเพิ่มข้อมูล ###############
if(isset($_POST['i']['action']) && $_POST['i']['action']=='insert'){//หากมีการกำหนด i['action'] และ i['action']=='insert' ให้เพิ่มข้อมูล
    $i = $_POST['i'];
    $sqli = "INSERT INTO item(
                    name,
					unit_id,
					serial_no,
					item_code,
					in_stock,
					item_detail,
					price,
					item_status
					) VALUES(
                    :name,
					:unit_id,
					:serial_no,
					:item_code,
					:in_stock,
					:item_detail,
					:price,
					:item_status
					
                )";//คำสั่งในการเพิ่มข้อมูลลงในตาราง item
    $resulti = $con->prepare($sqli);//เตรียมคำสั่ง SQL
    $resulti->execute(array(
                    'name'=>$i['name'],
					'unit_id'=>$i['unit_id'],
					'serial_no'=>$i['serial_no'],
					'item_code'=>$i['item_code'],
					'in_stock'=>$i['in_stock'],
					'item_detail'=>$i['item_detail'],
					'price'=>$i['price'],
					'item_status'=>$i['item_status']
					
                )); //ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
    if($resulti!==false){
        $_SESSION['flash']['type']='success';
        $_SESSION['flash']['msg']='เพิ่มข้อมูลเรียบร้อย';
    }else{
        $_SESSION['flash']['type']='danger';
        $_SESSION['flash']['msg']='ไม่สามารถเพิ่มข้อมูลได้';
    }

}

################### การแก้ไขข้อมูล #################
if(isset($_GET['action']) && $_GET['action']=='edit'){ //ถ้ามีการคลิกแก้ไข
    $iid = $_GET['id'];

    $sqle = "SELECT * FROM item WHERE id=:iid"; //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
    $resulte = $con->prepare($sqle);//เตรียมคำสั่ง SQL 
    $resulte->execute(array('iid'=>$iid));//ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
    $rse = $resulte->fetch(); //เก็บไว้ในตัวแปร $rse แบบ array()

    $name = $rse['name'];
	$unit_id = $rse['unit_id'];
	$serial_no = $rse['serial_no'];
	$item_code = $rse['item_code'];
	$in_stock = $rse['in_stock'];
	$item_detail = $rse['item_detail'];
	$price = $rse['price'];
	$item_status = $rse['item_status'];
	 // กำหนดค่าให้กับตัวแปรเพื่อส่งให้ฟอร์ม
}

if(isset($_POST['i']['action']) && $_POST['i']['action']=='edit'){// ตรวจสอบว่ามีการส่งค่ามาจากการแก้ไขหรือไม่
    $i = $_POST['i'];
    $sqlu = "UPDATE item SET
            name=:name,
			unit_id=:unit_id,
			serial_no=:serial_no,
			item_code=:item_code,
			in_stock=:in_stock,
			item_detail=:item_detail,
			price=:price,
			item_status=:item_status
			
            WHERE id=:id";//คำสั่งในการแก้ไขข้อมูล
    $resultu = $con->prepare($sqlu);//เตรียมคำสั่ง SQL
    $resultu->execute(array(
                        'id'=>$i['id'],
                        'name'=>$i['name'],
						'unit_id'=>$i['unit_id'],
						'serial_no'=>$i['serial_no'],
						'item_code'=>$i['item_code'],
						'in_stock'=>$i['in_stock'],
						'item_detail'=>$i['item_detail'],
						'price'=>$i['price'],
						'item_status'=>$i['item_status']
						
                    )
                );// ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
    if($resultu!==false){
        $_SESSION['flash']['type']='success';
        $_SESSION['flash']['msg']='แก้ไขข้อมูลเรียบร้อย';
    }else{
        $_SESSION['flash']['type']='danger';
        $_SESSION['flash']['msg']='ไม่สามารถแก้ไขข้อมูลได้';
    }
}

################### การลบข้อมูล ###############
if(isset($_GET['action'])&& $_GET['action']=='delete'){//หากมีการกำหนด action=='delete' ให้ลบข้อมูล
    $sqld = "DELETE FROM item WHERE id=:id";//คำสั่งในการลบข้อมูล
    $resultd = $con->prepare($sqld);//เตรียมคำสั่ง SQL
    $resultd->execute(array('id'=>$_GET['id']));//ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
    if($resultd!==false){
        $_SESSION['flash']['type']='success';
        $_SESSION['flash']['msg']='ลบข้อมูลเรียบร้อยแล้ว';
    }else{
        $_SESSION['flash']['type']='danger';
        $_SESSION['flash']['msg']='ไม่สามารถลบข้อมูลได้';
    }
}

################### เลือกข้อมูลมาแสดงในตาราง ###############
$sql = "SELECT * FROM item ORDER BY id DESC";//คำสั่งในการเลือกข้อมูล
$result = $con->prepare($sql);//เตรียมคำสั่ง SQL
$result->execute();//ประมวลผล
?>

<!-- ############### การแจ้งเตือน ############# -->
<?php if(isset($_SESSION['flash'])){ ?>
<div class="alert alert-<?php echo $_SESSION['flash']['type'];?>">
    <?php echo ucfirst($_SESSION['flash']['type']).' '.$_SESSION['flash']['msg'];?>
</div>
<?php }?>
<!--################ แบบฟอร์มกรอกข้อมูล ############## -->
<div class="row">
<div class="col-md-12">
<h3>&nbsp;</h3>
</div>

<hr />
<div class="col-md-12">
<!-- ############### รายการข้อมูล ############# -->
<h3>รายการวัสดุ</h3>
<div class="table-responsive">
<table width="592" class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
    		<th width="26"><center>ชื่อ</center></th>
			<th width="111"><center>หมายเลข Serial</center></th>
			<th width="79"><center>รหัสวัสดุ</center></th>
			<th width="106"><center>จำนวนคงเหลือ</center></th>
			<th width="130"><center>รายละเอียด</center></th>
			<th width="45"><center>ราคา</center></th>
			<th width="63"><center>สถานะ</center></th>

         
        </tr>
    </thead>
    <tbody>
    <?php while($rs=$result->fetch()){?>
        <tr>
    		<td align="center"><?php echo $rs['name'];?></td>
			<td align="center"><?php echo $rs['serial_no'];?></td>
			<td align="center"><?php echo $rs['item_code'];?></td>
			<td align="center"><?php echo $rs['in_stock'];?></td>
			<td align="center"><?php echo $rs['item_detail'];?></td>
			<td align="center"><?php echo $rs['price'];?></td>
			<td align="center"><?php echo $rs['item_status'];?></td>
	
                    
        </tr>
    <?php }?>
    </tbody>
</table>
</div>
</div>
</div><!--row-->
