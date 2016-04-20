<?php
if(!isset($_SESSION)){
	session_start();
}
include 'function.php';
include 'dbcon.php';
include 'bguse.php';
if(isset($_POST['l'])){
	$l = $_POST['l'];
	$sql = "SELECT user.*,major.major FROM user JOIN major ON user.major_id=major.id WHERE username=:user AND password=:pass";
	$result = $con->prepare($sql);
	$result->execute(array('user'=>$l['username'],'pass'=>$l['password']));
	$rs = $result->fetch();

	if(!empty($rs)){
		$_SESSION['user'] = $rs;
		if($rs['user_type']=='admin'){
			redirect('admin_dashboard.php');
		}else{
			redirect('user_dashboard.php');
		}
	}else{
		$_SESSION['flash']['type'] = 'danger';
		$_SESSION['flash']['msg'] = 'Username หรือ Password ไม่ถูกต้อง';
	}
}

include 'html_head.php';
?>
<!--####### Flash Message #####-->
<?php if(isset($_SESSION['flash'])){?>
	<div class="alert alert-<?php echo $_SESSION['flash']['type'];?>">
		<?php echo ucfirst($_SESSION['flash']['type']).' '.$_SESSION['flash']['msg'];?>
	</div>
<?php }?>

<h1>เข้าสู่ระบบ</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-horizontal">
	<div class="form-group">
		<label for="l-username" class="control-label col-md-2">Username</label>
		<div class="col-md-5">
			<input id="l-username" type="text" class="form-control" name="l[username]" required="required" />
		</div>
	</div>
	<div class="form-group">
		<label for="l-password" class="control-label col-md-2">Password</label>
		<div class="col-md-5">
			<input id="l-password" type="password" class="form-control" name="l[password]"  required="required" />
		</div>
	</div>

	<input type="submit" value="เข้าสู่ระบบ" class="btn btn-success">
</form>
