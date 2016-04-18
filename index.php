<?php
if(!isset($_SESSION)){
	session_start();
}
include 'html_head.php';
?>

<div class="jumbotron">
  <h1>Suplies Management System (SMS)</h1>
  <p>ระบบริหารจัดการพัสดุ</p>
  <p><a href="login.php" class="btn btn-primary btn-lg">เข้าสู่ระบบ</a></p>
</div>

<?php
include 'html_foot.php';
?>