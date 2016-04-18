<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'dbcon.php';

$order_id	= null; // กำหนดค่าเริ่มต้นของ $order_id
$item_id	= null; // กำหนดค่าเริ่มต้นของ $item_id
$order_amount	= null; // กำหนดค่าเริ่มต้นของ $order_amount

################### การเพิ่มข้อมูล ###############
if(isset($_POST['o']['action']) && $_POST['o']['action']=='insert'){//หากมีการกำหนด o['action'] และ o['action']=='insert' ให้เพิ่มข้อมูล
    $o = $_POST['o'];
    $sqli = "INSERT INTO order_detail(
                    order_id,
					item_id,
					order_amount
					) VALUES(
                    :order_id,
					:item_id,
					:order_amount
					
                )";//คำสั่งในการเพิ่มข้อมูลลงในตาราง order_detail
    $resulti = $con->prepare($sqli);//เตรียมคำสั่ง SQL
    $resulti->execute(array(
                    'order_id'=>$o['order_id'],
					'item_id'=>$o['item_id'],
					'order_amount'=>$o['order_amount']
					
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
    $oid = $_GET['id'];

    $sqle = "SELECT * FROM order_detail WHERE id=:oid"; //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
    $resulte = $con->prepare($sqle);//เตรียมคำสั่ง SQL 
    $resulte->execute(array('oid'=>$oid));//ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
    $rse = $resulte->fetch(); //เก็บไว้ในตัวแปร $rse แบบ array()

    $order_id = $rse['order_id'];
	$item_id = $rse['item_id'];
	$order_amount = $rse['order_amount'];
	 // กำหนดค่าให้กับตัวแปรเพื่อส่งให้ฟอร์ม
}

if(isset($_POST['o']['action']) && $_POST['o']['action']=='edit'){// ตรวจสอบว่ามีการส่งค่ามาจากการแก้ไขหรือไม่
    $o = $_POST['o'];
    $sqlu = "UPDATE order_detail SET
            order_id=:order_id,
			item_id=:item_id,
			order_amount=:order_amount
			
            WHERE id=:id";//คำสั่งในการแก้ไขข้อมูล
    $resultu = $con->prepare($sqlu);//เตรียมคำสั่ง SQL
    $resultu->execute(array(
                        'id'=>$o['id'],
                        'order_id'=>$o['order_id'],
						'item_id'=>$o['item_id'],
						'order_amount'=>$o['order_amount']
						
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
    $sqld = "DELETE FROM order_detail WHERE id=:id";//คำสั่งในการลบข้อมูล
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
$sql = "SELECT * FROM order_detail ORDER BY id DESC";//คำสั่งในการเลือกข้อมูล
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
<h3>รายละเอียดการสั่งซื้อ</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-horizontal">
<?php if(isset($_GET['action']) && $_GET['action']=='edit'){?>
    <input type="hidden" name="o[action]" value="edit">
    <input type="hidden" name="o[id]" value="<?php echo $oid;?>">
<?php }else{?>
    <input type="hidden" name="o[action]" value="insert">
<?php }?>
    
    <div class="form-group">
        <label class="control-label col-md-2" for="o-order_id">การสั่งซื้อ</label>
        <div class="col-md-10">
            <select name="o[order_id]" class="form-control" id="o-order_id">
                        <option>เลือกการสั่งซื้อ</option>
                        <?php
                        $order=$con->prepare("SELECT * FROM order");
                        $order->execute();
                        //print_r($order);
                        while($or = $order->fetch()){?>
                            <option value="<?php echo $or['id'];?>"><?php echo $or[1];?></option>
                        <?php }?>
                    </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="o-item_id">วัสดุ/พัสดุ</label>
        <div class="col-md-10">
            <select name="o[item_id]" class="form-control" id="o-item_id">
                        <option>เลือกวัสดุ/พัสดุ</option>
                        <?php
                        $item=$con->prepare("SELECT * FROM item");
                        $item->execute();
                        //print_r($item);
                        while($it = $item->fetch()){?>
                            <option value="<?php echo $it['id'];?>"><?php echo $it[1];?></option>
                        <?php }?>
                    </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="o-order_amount">จำนวนที่สั่ง</label>
        <div class="col-md-10">
            <input id="o-order_amount" class="form-control" type="text" name="o[order_amount]" value="<?php echo $order_amount;?>" required="required">
        </div>
    </div>
        <input type="submit" value="บันทึกข้อมูล รายละเอียดการสั่งซื้อ" class="btn btn-primary">
        <?php if(isset($_GET['action']) && $_GET['action']=='edit'){ //หากมีการแก้ไขให้แสดงปุ่ม ยกเลิก ?>
            <a href="admin_order_detail.php" class="btn btn-warning">ยกเลิก</a>
        <?php }?>

</form>
</div>

<hr />
<div class="col-md-12">
<!-- ############### รายการข้อมูล ############# -->
<h3>รายการรายละเอียดการสั่งซื้อ</h3>
<div class="table-responsive">
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
    		<th>การสั่งซื้อ</th>
			<th>วัสดุ/พัสดุ</th>
			<th>จำนวนที่สั่ง</th>
	
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php while($rs=$result->fetch()){?>
        <tr>
    		<td><?php echo $rs['order_id'];?></td>
			<td><?php echo $rs['item_id'];?></td>
			<td><?php echo $rs['order_amount'];?></td>
	
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
<?php
include 'html_foot.php';
?>
