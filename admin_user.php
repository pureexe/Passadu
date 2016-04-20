<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'dbcon.php';

$firstname	= null; // กำหนดค่าเริ่มต้นของ $firstname
$lastname	= null; // กำหนดค่าเริ่มต้นของ $lastname
$username	= null; // กำหนดค่าเริ่มต้นของ $username
$password	= null; // กำหนดค่าเริ่มต้นของ $password
$address	= null; // กำหนดค่าเริ่มต้นของ $address
$tel		= null; // กำหนดค่าเริ่มต้นของ $tel
$user_type	= null; // กำหนดค่าเริ่มต้นของ $user_type
$major_id	= null; // กำหนดค่าเริ่มต้นของ $user_type

################### การเพิ่มข้อมูล ###############
if(isset($_POST['u']['action']) && $_POST['u']['action']=='insert'){//หากมีการกำหนด u['action'] และ u['action']=='insert' ให้เพิ่มข้อมูล
    $u = $_POST['u'];
    if($u['major_id']==0){
      $_SESSION['flash']['type']='danger';
      $_SESSION['flash']['msg']='กรุณาระบุสาขา';
    }else{
      $sqli = "INSERT INTO user (
                      firstname,
  					lastname,
  					username,
  					password,
  					major_id,
  					address,
  					tel,
  					user_type
  					) VALUES(
                      :firstname,
  					:lastname,
  					:username,
  					:password,
  					:major_id,
  					:address,
  					:tel,
  					:user_type


                  )";//คำสั่งในการเพิ่มข้อมูลลงในตาราง user
      $resulti = $con->prepare($sqli);//เตรียมคำสั่ง SQL
      $resulti->execute(array(
                      'firstname'=>$u['firstname'],
  					'lastname'=>$u['lastname'],
  					'username'=>$u['username'],
  					'password'=>$u['password'],
  					'major_id'=>$u['major_id'],
  					'address'=>$u['address'],
  					'tel'=>$u['tel'],
  					'user_type'=>$u['user_type']
                  )); //ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
      if($resulti!==false){
          $_SESSION['flash']['type']='success';
          $_SESSION['flash']['msg']='เพิ่มข้อมูลเรียบร้อย';
      }else{
          $_SESSION['flash']['type']='danger';
          $_SESSION['flash']['msg']='ไม่สามารถเพิ่มข้อมูลได้';
      }
    }
}

################### การแก้ไขข้อมูล #################
if(isset($_GET['action']) && $_GET['action']=='edit'){ //ถ้ามีการคลิกแก้ไข
    $uid = $_GET['id'];

    $sqle = "SELECT * FROM user WHERE id=:uid"; //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
    $resulte = $con->prepare($sqle);//เตรียมคำสั่ง SQL
    $resulte->execute(array('uid'=>$uid));//ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
    $rse = $resulte->fetch(); //เก็บไว้ในตัวแปร $rse แบบ array()

    $firstname = $rse['firstname'];
	$lastname = $rse['lastname'];
	$username = $rse['username'];
	$password = $rse['password'];
	$major_id = $rse['major_id'];
	$address = $rse['address'];
	$tel 	= $rse['tel'];
	$user_type = $rse['user_type'];

	 // กำหนดค่าให้กับตัวแปรเพื่อส่งให้ฟอร์ม
}

if(isset($_POST['u']['action']) && $_POST['u']['action']=='edit'){// ตรวจสอบว่ามีการส่งค่ามาจากการแก้ไขหรือไม่
    $u = $_POST['u'];
    if($u['major_id']==0){
      $_SESSION['flash']['type']='danger';
      $_SESSION['flash']['msg']='กรุณาระบุสาขา';
    }else{
    $sqlu = "UPDATE user SET
            firstname=:firstname,
			lastname=:lastname,
			username=:username,
			password=:password,
			address=:address,
			tel=:tel,
			user_type=:user_type,
		    major_id=:major_id

            WHERE id=:id";//คำสั่งในการแก้ไขข้อมูล
    $resultu = $con->prepare($sqlu);//เตรียมคำสั่ง SQL
    $resultu->execute(array(
                        'id'=>$u['id'],
                        'firstname'=>$u['firstname'],
						'lastname'=>$u['lastname'],
						'username'=>$u['username'],
						'password'=>$u['password'],
						'address'=>$u['address'],
						'tel'=>$u['tel'],
						'user_type'=>$u['user_type'],
						'major_id'=>$u['major_id']

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
}

################### การลบข้อมูล ###############
if(isset($_GET['action'])&& $_GET['action']=='delete'){//หากมีการกำหนด action=='delete' ให้ลบข้อมูล
    $sqld = "DELETE FROM user WHERE id=:id";//คำสั่งในการลบข้อมูล
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
$sql = "SELECT user.*,major.major FROM user JOIN major ON user.major_id = major.id ORDER BY id DESC";//คำสั่งในการเลือกข้อมูล
$result = $con->prepare($sql);//เตรียมคำสั่ง SQL
$result->execute();//ประมวลผล
?>

<!-- ############### การแจ้งเตือน ############# -->
<?php if(isset($_SESSION['flash'])){ ?>
<div class="alert alert-<?php echo $_SESSION['flash']['type'];?>">
    <?php echo ucfirst($_SESSION['flash']['type']).' '.$_SESSION['flash']['msg'];?>
</div>
<?php
  unset($_SESSION['flash']);
}
?>
<!--################ แบบฟอร์มกรอกข้อมูล ############## -->
<div class="row">
<div class="col-md-12">
<h3>เพิ่มข้อมูลผู้ใช้งาน</h3>
<p>&nbsp;</p>



<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-horizontal">
<?php if(isset($_GET['action']) && $_GET['action']=='edit'){?>
    <input type="hidden" name="u[action]" value="edit">
    <input type="hidden" name="u[id]" value="<?php echo $uid;?>">
<?php }else{?>
    <input type="hidden" name="u[action]" value="insert">
<?php }?>

    <div class="form-group">
        <label class="control-label col-md-2" for="u-firstname">ชื่อ</label>
        <div class="col-md-10">
            <input id="u-firstname" class="form-control" type="text" name="u[firstname]" value="<?php echo $firstname;?>" required="required">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="u-lastname">นามสกุล</label>
        <div class="col-md-10">
            <input id="u-lastname" class="form-control" type="text" name="u[lastname]" value="<?php echo $lastname;?>" required="required">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="u-username">ชื่อผู้ใช้</label>
        <div class="col-md-10">
            <input id="u-username" class="form-control" type="text" name="u[username]" value="<?php echo $username;?>" required="required">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="u-password">รหัสผ่าน</label>
        <div class="col-md-10">
            <input id="u-password" class="form-control" type="text" name="u[password]" value="<?php echo $password;?>" required="required">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2" for="u-address">ที่อยู่</label>
        <div class="col-md-10">
            <textarea name="u[address]" class="form-control" rows="10"  required="required"><?php echo $address;?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="u-tel">เบอร์โทร</label>
        <div class="col-md-10">
            <input id="u-tel" class="form-control" type="text" name="u[tel]" value="<?php echo $tel;?>" >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="u-user_type">ประเภทผู้ใช้งาน</label>
        <div class="col-md-10">
            <select name="u[user_type]" class="form-control" id="u-user_type">
				<option value="admin" <?php if($user_type=='admin'){?> selected="selected"<?php }?>>admin</option>
				<option value="user" <?php if($user_type=='user'){?> selected="selected"<?php }?>>user</option>
			</select>
             </div>

    </div>
     <div class="form-group">
        <label class="control-label col-md-2" for="u-major_id">สาขา</label>
        <div class="col-md-10">
            <select name="u[major_id]" class="form-control" id="u-major_id">
                        <option <?php echo ($major_id)?"selected":""; ?> value="0">เลือกสาขา</option>
                        <?php
                        $major=$con->prepare("SELECT * FROM major");
                        $major->execute();
                        while($ma = $major->fetch()){?>
                            <option value="<?php echo $ma['id'];?>" <?php echo ($ma['id']==$major_id)?"selected":""; ?>><?php echo $ma[1];?></option>
                        <?php }?>
                    </select>

        </div>
        <input type="submit" value="บันทึกข้อมูล ผู้ใช้งาน" class="btn btn-primary">
        <?php if(isset($_GET['action']) && $_GET['action']=='edit'){ //หากมีการแก้ไขให้แสดงปุ่ม ยกเลิก ?>
            <a href="admin_user.php" class="btn btn-warning">ยกเลิก</a>
        <?php }?>

</form>
</div>


<hr />
<div class="col-md-12">



      <?php
      /*
        $sql = "SELECT * FROM user i
                    LEFT JOIN major u ON u.id = i.major_id
                    WHERE i.user_type=:user_type";
        $result = $con->prepare($sql);
        $result->execute(array('user_type'=>'user'));
        */
      ?>

<h3>ข้อมูลผู้ใช้งาน</h3>
<div class="table-responsive">
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
    		<th>ชื่อ</th>
			<th>นามสกุล</th>
			<th>ชื่อผู้ใช้</th>
			<th>รหัสผ่าน</th>
			<th>ที่อยู่</th>
            <th>สาขา</th>
			<th>เบอร์โทร</th>
            <th>กลุ่มผู้ใช้งาน</th>

            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php while($rs_item=$result->fetch()){?>
        <tr>
    		<td><?php echo $rs_item['firstname'];?></td>
			<td><?php echo $rs_item['lastname'];?></td>
			<td><?php echo $rs_item['username'];?></td>
			<td><?php echo $rs_item['password'];?></td>
			<td><?php echo $rs_item['address'];?></td>
            <td><?php echo $rs_item['major'];?></td>
			<td><?php echo $rs_item['tel'];?></td>
			<td><?php echo $rs_item['user_type'];?></td>

            <td>
                <a href="<?php echo $_SERVER['PHP_SELF'];?>?action=edit&id=<?php echo $rs_item['id'];?>" class="btn btn-xs btn-warning">แก้ไข</a>
                <a href="<?php echo $_SERVER['PHP_SELF'];?>?action=delete&id=<?php echo $rs_item['id'];?>" class="btn btn-xs btn-danger" onclick="return confirm('แน่ใจนะว่าต้องการลบ?');">ลบ</a>
            </td>
        </tr>
    <?php }?>
    </tbody>
</table>
</div>
</div>
</div><!--row-->
