<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'dbcon.php';

$unit	= null; // กำหนดค่าเริ่มต้นของ $unit

################### การเพิ่มข้อมูล ###############
if(isset($_POST['u']['action']) && $_POST['u']['action']=='insert'){//หากมีการกำหนด u['action'] และ u['action']=='insert' ให้เพิ่มข้อมูล
    $u = $_POST['u'];
    $sqli = "INSERT INTO unit(
                    unit
					) VALUES(
                    :unit
					
                )";//คำสั่งในการเพิ่มข้อมูลลงในตาราง unit
    $resulti = $con->prepare($sqli);//เตรียมคำสั่ง SQL
    $resulti->execute(array(
                    'unit'=>$u['unit']
					
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
    $uid = $_GET['id'];

    $sqle = "SELECT * FROM unit WHERE id=:uid"; //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
    $resulte = $con->prepare($sqle);//เตรียมคำสั่ง SQL 
    $resulte->execute(array('uid'=>$uid));//ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
    $rse = $resulte->fetch(); //เก็บไว้ในตัวแปร $rse แบบ array()

    $unit = $rse['unit'];
	 // กำหนดค่าให้กับตัวแปรเพื่อส่งให้ฟอร์ม
}

if(isset($_POST['u']['action']) && $_POST['u']['action']=='edit'){// ตรวจสอบว่ามีการส่งค่ามาจากการแก้ไขหรือไม่
    $u = $_POST['u'];
    $sqlu = "UPDATE unit SET
            unit=:unit
			
            WHERE id=:id";//คำสั่งในการแก้ไขข้อมูล
    $resultu = $con->prepare($sqlu);//เตรียมคำสั่ง SQL
    $resultu->execute(array(
                        'id'=>$u['id'],
                        'unit'=>$u['unit']
						
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
    $sqld = "DELETE FROM unit WHERE id=:id";//คำสั่งในการลบข้อมูล
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
$sql = "SELECT * FROM unit ORDER BY id DESC";//คำสั่งในการเลือกข้อมูล
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
<h3>หน่วย</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-horizontal">
<?php if(isset($_GET['action']) && $_GET['action']=='edit'){?>
    <input type="hidden" name="u[action]" value="edit">
    <input type="hidden" name="u[id]" value="<?php echo $uid;?>">
<?php }else{?>
    <input type="hidden" name="u[action]" value="insert">
<?php }?>
    
    <div class="form-group">
        <label class="control-label col-md-2" for="u-unit">หน่วย</label>
        <div class="col-md-10">
            <input id="u-unit" class="form-control" type="text" name="u[unit]" value="<?php echo $unit;?>" required="required">
        </div>
    </div>
        <input type="submit" value="บันทึกข้อมูล หน่วย" class="btn btn-primary">
        <?php if(isset($_GET['action']) && $_GET['action']=='edit'){ //หากมีการแก้ไขให้แสดงปุ่ม ยกเลิก ?>
            <a href="admin_unit.php" class="btn btn-warning">ยกเลิก</a>
        <?php }?>

</form>
</div>

<hr />
<div class="col-md-12">
<!-- ############### รายการข้อมูล ############# -->
<h3>รายการหน่วย</h3>
<div class="table-responsive">
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
    		<th>หน่วย</th>
	
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php while($rs=$result->fetch()){?>
        <tr>
    		<td><?php echo $rs['unit'];?></td>
	
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
