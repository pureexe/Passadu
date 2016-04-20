<?php
if(!isset($_SESSION)){
    session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'dbcon.php';
date_default_timezone_set('Asia/Bangkok');

$user_id	= null; // กำหนดค่าเริ่มต้นของ $user_id
$widen_date	= date("Y-m-d H:i:s"); // กำหนดค่าเริ่มต้นของ $widen_date


################### การเพิ่มข้อมูล ###############
if(isset($_POST['w']['action']) && $_POST['w']['action']=='insert'){//หากมีการกำหนด w['action'] และ w['action']=='insert' ให้เพิ่มข้อมูล
    $w = $_POST['w'];
    $sqli = "INSERT INTO widen(
                    user_id,
					widen_date
					) VALUES(
                    :user_id,
					:widen_date
					
                )";//คำสั่งในการเพิ่มข้อมูลลงในตาราง widen
    $resulti = $con->prepare($sqli);//เตรียมคำสั่ง SQL
    $resulti->execute(array(
                    'user_id'=>$w['user_id'],
					'widen_date'=>$w['widen_date']
					
                )); //ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
    $lastid = $con->lastInsertId();//เก็บ id ล่าสุดของ widen ไว้ใน $lastid

    $item_id = $_POST['item_id'];//เก็บรหัส item ไว้ใน $item_id
    $widen_amount = $_POST['widen_amount'];//เก็บจำนวนไว้ใน $widen_amount
    $return_date = $_POST['return_date'];
    //echo $lastid;
    for($i=0;$i<count($item_id);$i++){// loop ข้อมูลเพื่อบันทึกลงใน widen_detail
        //echo $item_id[$i].'<br>';
        //echo $widen_amount[$i];
        $sqlci = "SELECT * FROM item i WHERE i.id=:id";
        $resultci = $con->prepare($sqlci);
        $resultci->execute(array('id'=>$item_id[$i]));
        $rsci = $resultci->fetch();

        if($rsci['item_type']=='พัสดุ'){
            $ci = 'ยังไม่คืน';
        }else{
            $ci = null;
        }// ตรวจสอบว่าเป็นวัสดุหรือพัสดุ

        $sql_widen = "INSERT INTO widen_detail(widen_id,item_id,widen_amount)
                    VALUES(:widen_id,:item_id,:widen_amount)";
        $result_widen = $con->prepare($sql_widen);
        $result_widen->execute(array('widen_id'=>$lastid,'item_id'=>$item_id[$i],'widen_amount'=>$widen_amount[$i]));

        $sql_stock = "UPDATE item SET in_stock=in_stock-:in_stock WHERE id=:id";
        $result_stock = $con->prepare($sql_stock);
        $result_stock->execute(array('in_stock'=>$widen_amount[$i],'id'=>$item_id[$i]));
    }

    unset($_SESSION['item']);//ล้างการเลือก item

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

    $sqle = "SELECT * FROM widen WHERE id=:wid"; //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
    $resulte = $con->prepare($sqle);//เตรียมคำสั่ง SQL 
    $resulte->execute(array('wid'=>$wid));//ทำการ Bind ค่าลงใน Field ต่างๆ และประมวลผล
    $rse = $resulte->fetch(); //เก็บไว้ในตัวแปร $rse แบบ array()

    $user_id = $rse['user_id'];
	$widen_date = $rse['widen_date'];
	 // กำหนดค่าให้กับตัวแปรเพื่อส่งให้ฟอร์ม
}

if(isset($_POST['w']['action']) && $_POST['w']['action']=='edit'){// ตรวจสอบว่ามีการส่งค่ามาจากการแก้ไขหรือไม่
    $w = $_POST['w'];
    $sqlu = "UPDATE widen SET
            user_id=:user_id,
			widen_date=:widen_date
			
            WHERE id=:id";//คำสั่งในการแก้ไขข้อมูล
    $resultu = $con->prepare($sqlu);//เตรียมคำสั่ง SQL
    $resultu->execute(array(
                        'id'=>$w['id'],
                        'user_id'=>$w['user_id'],
						'widen_date'=>$w['widen_date']
						
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
    $sqld = "DELETE FROM widen WHERE id=:id";//คำสั่งในการลบข้อมูล
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

################# ล้างรายการ ##############
if(isset($_GET['action']) && $_GET['action']=='item_reset'){
    if(isset($_SESSION['item'])){
        unset($_SESSION['item']);
    }
}




################### เลือกข้อมูลมาแสดงในตาราง ###############
$sql = "SELECT w.*,u.firstname,u.lastname FROM widen w 
    LEFT JOIN user u ON u.id = w.user_id
    ORDER BY w.id DESC";//คำสั่งในการเลือกข้อมูล
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
<h3>การเบิก/ยืม</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-horizontal">
<?php if(isset($_GET['action']) && $_GET['action']=='edit'){?>
    <input type="hidden" name="w[action]" value="edit">
    <input type="hidden" name="w[id]" value="<?php echo $wid;?>">
<?php }else{?>
    <input type="hidden" name="w[action]" value="insert">
<?php }?>
    
    <div class="form-group">
        <label class="control-label col-md-2" for="w-user_id">ผู้เบิก/ยืม</label>
        <div class="col-md-3">
            <select name="w[user_id]" class="form-control" id="w-user_id">
                        <option>เลือกผู้เบิก/ยืม</option>
                        <?php
                        $user=$con->prepare("SELECT * FROM user");
                        $user->execute();
                        //print_r($user);
                        while($us = $user->fetch()){?>
                            <option value="<?php echo $us['id'];?>"><?php echo $us[1];?></option>
                        <?php }?>
          </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="w-widen_date">วันที่เบิก/ยืม</label>
        <div class="col-md-3">
            <input id="w-widen_date" readonly="readonly" class="form-control" type="text" name="w[widen_date]" value="<?php echo $widen_date;?>" required="required">
        </div>
    </div>
    
    <!-- โหลด Modal เพื่อเลือก Item -->
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
      เลือกวัสดุ-พัสดุ
    </button>
    <a href="<?php echo $_SERVER['PHP_SELF'];?>?action=item_reset" class="btn btn-warning btn-sm">ล้างรายการ</a>
    <h3>รายการวัสดุ-พัสดุที่เบิก-ยืม</h3>
    <?php
        if(isset($_POST['item'])){
            $_SESSION['item'] = $_POST['item'];
        }
        if(isset($_SESSION['item'])){
            //print_r($_SESSION['item']);
        }
        
    ?>
    <div class="table responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>ชื่อ</th>
                    <th>หน่วย</th>
                    <th>เลขพัสดุ</th>
                    <th>Serial NO.</th>
                    <th>จำนวน</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if(isset($_SESSION['item'])){
            for($i=0;$i<count($_SESSION['item']);$i++){
                $sql_select = "SELECT * FROM item i
                LEFT JOIN unit u ON u.id = i.unit_id
                WHERE i.id='".$_SESSION['item'][$i]."'";
                $result_select = $con->prepare($sql_select);
                $result_select->execute();
                $rs_select = $result_select->fetch();
                ?>
                <tr>
                    <td><?php echo $rs_select['name'];?></td>
                    <td><?php echo $rs_select['unit'];?></td>
                    <td><?php echo $rs_select['item_code'];?></td>
                    <td><?php echo $rs_select['serial_no'];?></td>
                    <td>
                        <input type="text" name="widen_amount[]" class="form-control" required="required">
                        <input type="hidden" name="item_id[]" value="<?php echo $rs_select[0];?>">
                    </td>
                </tr>
                <script>
                    $('#datepicker<?php echo $i;?>').datepicker({
                        language: "th",
                        format: "yyyy-mm-dd",
                        startDate: "<?php echo date('Y-m-d');?>"
                    });
                </script>
            <?php }
            }?>
            </tbody>
        </table>
    </div>



        <input type="submit" value="บันทึกข้อมูล การเบิก/ยืม" class="btn btn-primary">
        <?php if(isset($_GET['action']) && $_GET['action']=='edit'){ //หากมีการแก้ไขให้แสดงปุ่ม ยกเลิก ?>
            <a href="admin_widen.php" class="btn btn-warning">ยกเลิก</a>
        <?php }?>

</form>


<!-- Modal -->
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เลือกวัสดุ-พัสดุ</h4>
      </div>
      <div class="modal-body">
      
      
      <script>
            $(document).ready(function() {
                $('#item').DataTable();
            } );
      </script>
      <?php
        $sql_item = "SELECT * FROM item i
                    LEFT JOIN unit u ON u.id = i.unit_id
                    WHERE i.in_stock>0 AND i.item_status=:item_status";
        $result_item = $con->prepare($sql_item);
        $result_item->execute(array('item_status'=>'ใช้ได้'));
      ?>
            <div class="table-responsive">
                <table cellspacing="0" width="100%" id="item" class="display table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>หน่วย</th>
                            <th>เลขพัสดุ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($rs_item = $result_item->fetch()){?>
                        <tr>
                            <td><?php echo $rs_item['name'];?></td>
                            <td><?php echo $rs_item['unit'];?></td>
                            <td><?php echo $rs_item['item_code'];?></td>
                            <td><input type="checkbox" name="item[]" value="<?php echo $rs_item[0];?>"></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <input type="submit" class="btn btn-primary" value="เลือกรายการ">
      </div>
    </div>
  </div>
</div>
</form>
<!-- Modal -->


</div>

<hr />
<div class="col-md-12">
<!-- ############### รายการข้อมูล ############# -->
<h3>รายการการเบิก/ยืม</h3>
<div class="table-responsive">
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
    		<th>ผู้เบิก</th>
			<th>วันที่เบิก</th>
	
	
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php while($rs=$result->fetch()){?>
        <tr>
    		<td><?php echo $rs['firstname'];?> <?php echo $rs['lastname'];?></td>
			<td><?php echo $rs['widen_date'];?></td>
			
	
            <td>
                <a href="admin_widen_view.php?id=<?php echo $rs['id'];?>" target="_blank" class="btn btn-xs btn-info">รายละเอียด</a> <a href="<?php echo $_SERVER['PHP_SELF'];?>?action=delete&id=<?php echo $rs['id'];?>" class="btn btn-xs btn-danger" onclick="return confirm('แน่ใจนะว่าต้องการลบ?');">ลบ</a>
            </td>
        </tr>
    <?php }?>
    </tbody>
</table>
</div>
</div>
</div><!--row-->

