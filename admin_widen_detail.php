<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'dbcon.php';

$widen_id	= null; // กำหนดค่าเริ่มต้นของ $widen_id
$item_id	= null; // กำหนดค่าเริ่มต้นของ $item_id
$widen_amount	= null; // กำหนดค่าเริ่มต้นของ $widen_amount

################### การเพิ่มข้อมูล ###############
if(isset($_POST['w']['action']) && $_POST['w']['action']=='insert'){//หากมีการกำหนด w['action'] และ w['action']=='insert' ให้เพิ่มข้อมูล
    $w = $_POST['w'];
    $sqli = "INSERT INTO widen_detail(
                    widen_id,
					item_id,
					widen_amount
					) VALUES(
                    :widen_id,
					:item_id,
					:widen_amount
					
                )";//คำสั่งในการเพิ่มข้อมูลลงในตาราง widen_detail
    $resulti = $con->prepare($sqli);//เตรียมคำสั่ง SQL
    $resulti->execute(array(
                    'widen_id'=>$w['widen_id'],
					'item_id'=>$w['item_id'],
					'widen_amount'=>$w['widen_amount']
					
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
    $wid = $_GET['id'];

    $sqle = "SELECT * FROM widen_detail WHERE id=:wid"; //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
    $resulte = $con->prepare($sqle);//เตรียมคำสั่ง SQL 
    $resulte->execute(array('wid'=>$wid));//ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
    $rse = $resulte->fetch(); //เก็บไว้ในตัวแปร $rse แบบ array()

    $widen_id = $rse['widen_id'];
	$item_id = $rse['item_id'];
	$widen_amount = $rse['widen_amount'];
	 // กำหนดค่าให้กับตัวแปรเพื่อส่งให้ฟอร์ม
}

if(isset($_POST['w']['action']) && $_POST['w']['action']=='edit'){// ตรวจสอบว่ามีการส่งค่ามาจากการแก้ไขหรือไม่
    $w = $_POST['w'];
    $sqlu = "UPDATE widen_detail SET
            widen_id=:widen_id,
			item_id=:item_id,
			widen_amount=:widen_amount
			
            WHERE id=:id";//คำสั่งในการแก้ไขข้อมูล
    $resultu = $con->prepare($sqlu);//เตรียมคำสั่ง SQL
    $resultu->execute(array(
                        'id'=>$w['id'],
                        'widen_id'=>$w['widen_id'],
						'item_id'=>$w['item_id'],
						'widen_amount'=>$w['widen_amount']
						
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
    $sqld = "DELETE FROM widen_detail WHERE id=:id";//คำสั่งในการลบข้อมูล
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
$sql = "SELECT * FROM widen_detail ORDER BY id DESC";//คำสั่งในการเลือกข้อมูล
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
<h3>รายละเอียดการเบิก/ยืม</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-horizontal">
<?php if(isset($_GET['action']) && $_GET['action']=='edit'){?>
    <input type="hidden" name="w[action]" value="edit">
    <input type="hidden" name="w[id]" value="<?php echo $wid;?>">
<?php }else{?>
    <input type="hidden" name="w[action]" value="insert">
<?php }?>
    
    <div class="form-group">
        <label class="control-label col-md-2" for="w-widen_id">การเบิก</label>
        <div class="col-md-10">
            <select name="w[widen_id]" class="form-control" id="w-widen_id">
                        <option>เลือกการเบิก</option>
                        <?php
                        $widen=$con->prepare("SELECT * FROM widen");
                        $widen->execute();
                        //print_r($widen);
                        while($wi = $widen->fetch()){?>
                            <option value="<?php echo $wi['id'];?>"><?php echo $wi[1];?></option>
                        <?php }?>
                    </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="w-item_id">วัสดุ</label>
        <div class="col-md-10">
            <select name="w[item_id]" class="form-control" id="w-item_id">
                        <option>เลือกวัสดุ</option>
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
        <label class="control-label col-md-2" for="w-widen_amount">จำนวนเบิก</label>
        <div class="col-md-10">
            <input id="w-widen_amount" class="form-control" type="text" name="w[widen_amount]" value="<?php echo $widen_amount;?>" required="required">
        </div>
    </div>
        <input type="submit" value="บันทึกข้อมูล รายละเอียดการเบิก" class="btn btn-primary">
        <?php if(isset($_GET['action']) && $_GET['action']=='edit'){ //หากมีการแก้ไขให้แสดงปุ่ม ยกเลิก ?>
            <a href="admin_widen_detail.php" class="btn btn-warning">ยกเลิก</a>
        <?php }?>

</form>
</div>

<hr />
<div class="col-md-12">
<!-- ############### รายการข้อมูล ############# -->
<h3>รายการรายละเอียดการเบิก</h3>
<div class="table-responsive">
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
    		<th>การเบิก</th>
			<th>วัสดุ</th>
			<th>จำนวนเบิก</th>
	
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php while($rs=$result->fetch()){?>
        <tr>
    		<td><?php echo $rs['widen_id'];?></td>
			<td><?php echo $rs['item_id'];?></td>
			<td><?php echo $rs['widen_amount'];?></td>
	
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
