<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_admin();
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
<h3>วัสดุ</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-horizontal">
<?php if(isset($_GET['action']) && $_GET['action']=='edit'){?>
    <input type="hidden" name="i[action]" value="edit">
    <input type="hidden" name="i[id]" value="<?php echo $iid;?>">
<?php }else{?>
    <input type="hidden" name="i[action]" value="insert">
<?php }?>
    
    <div class="form-group">
        <label class="control-label col-md-2" for="i-name">ชื่อ</label>
        <div class="col-md-10">
            <input id="i-name" class="form-control" type="text" name="i[name]" value="<?php echo $name;?>" required="required">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="i-unit_id">หน่วย</label>
        <div class="col-md-10">
          <select name="i[unit_id]" class="form-control" id="i-unit_id">
            <option selected="selected">เลือกหน่วย</option>
            <?php
			
                        $unit=$con->prepare("SELECT * FROM unit");
                        $unit->execute();
                        //print_r($unit);
                        while($un = $unit->fetch()){?>
            <option value="<?php echo $un['id'];?>"><?php echo $un[1];?></option>
            
            <?php }?>
          </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="i-serial_no">หมายเลข Serial</label>
        <div class="col-md-10">
            <input id="i-serial_no" class="form-control" type="text" name="i[serial_no]" value="<?php echo $serial_no;?>" >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="i-item_code">รหัสวัสดุ</label>
        <div class="col-md-10">
            <input id="i-item_code" class="form-control" type="text" name="i[item_code]" value="<?php echo $item_code;?>" >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="i-in_stock">จำนวนคงเหลือ</label>
        <div class="col-md-10">
          <input id="i-in_stock" class="form-control" type="text" name="i[in_stock]" value="<?php echo $in_stock;?>" required="required" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="i-item_detail">รายละเอียด</label>
        <div class="col-md-10">
            <textarea name="i[item_detail]" class="form-control" rows="10"  ><?php echo $item_detail;?></textarea>
        </div>
    </div>
    <div class="form-group" enctype="multipart/form-data">
        <label class="control-label col-md-2" for="i-price">ราคา</label>
        <div class="col-md-10">
            <input id="i-price" class="form-control" type="text" name="i[price]" value="<?php echo $price;?>" >
        </div>
    </div>
    
    
    
    
    <div class="form-group">
      <div class="col-md-10"></div>
    </div>
    
    
    
    
    
    
    
    <div class="form-group">
      <div class="col-md-10"></div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="i-item_status">สถานะ</label>
        <div class="col-md-10">
            <select name="i[item_status]" class="form-control" id="i-item_status">
				<option value="ใช้ได้" <?php if($item_status=='ใช้ได้'){?> selected="selected"<?php }?>>ใช้ได้</option>
				<option value="ใช้ไม่ได้" <?php if($item_status=='ใช้ไม่ได้'){?> selected="selected"<?php }?>>ใช้ไม่ได้</option>
                <option value="ยังไม่ตรวจรับ" <?php if($item_status=='ยังไม่ตรวจรับ'){?> selected="selected"<?php }?>>ยังไม่ตรวจรับ</option>
			</select>

        </div>
    </div>
        <input type="submit" value="บันทึกข้อมูล พัสดุ" class="btn btn-primary">
        <?php if(isset($_GET['action']) && $_GET['action']=='edit'){ //หากมีการแก้ไขให้แสดงปุ่ม ยกเลิก ?>
            <a href="admin_item.php" class="btn btn-warning">ยกเลิก</a>
        <?php }?>

</form>
</div>

<hr />







      <?php
        $sql = "SELECT * FROM item i
                    LEFT JOIN unit u ON u.id = i.unit_id
                    WHERE i.item_status=:item_status";
					
        $result = $con->prepare($sql);
        $result->execute(array('item_status'=>'ใช้ได้'));
      ?>
<div class="col-md-12">
<!-- ############### รายการข้อมูล ############# -->
<h3>รายการพัสดุ/วัสดุ</h3>
<div class="table-responsive">
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
    		<th>ชื่อ</th>
			<th>หน่วย</th>
			<th>หมายเลข Serial</th>
			<th>รหัสพัสดุ</th>
			<th>จำนวนคงเหลือ</th>
			<th>รายละเอียด</th>
			<th>ราคา</th>
			<th>สถานะ</th>
	
            <th></th>
        </tr>
    </thead>
    <tbody>
     
    <?php while($rs = $result->fetch()){?>
        <tr>
    		<td><?php echo $rs['name'];?></td>
			<td><?php echo $rs['unit'];?></td>
            <td><?php echo $rs['serial_no'];?></td>
			<td><?php echo $rs['item_code'];?></td>
			<td><?php echo $rs['in_stock'];?></td>
			<td><?php echo $rs['item_detail'];?></td>
			<td><?php echo $rs['price'];?></td>
			<td><?php echo $rs['item_status'];?></td>
	
            <td>
                <a href="<?php echo $_SERVER['PHP_SELF'];?>?action=edit&id=<?php echo $rs['id'];?>" class="btn btn-xs btn-warning">แก้ไข</a>
                <a href="<?php echo $_SERVER['PHP_SELF'];?>?action=delete&id=<?php echo $rs['id'];?>" class="btn btn-xs btn-danger" onclick="return confirm('แน่ใจนะว่าต้องการลบ?');">ลบ</a>
            </td>
        </tr>
    <?php }?>
    </tbody>
</table>
</div>
</div>
</div><!--row-->

