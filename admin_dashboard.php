<?php
if(!isset($_SESSION)){
	session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';
include 'bgadmin.php';

//print_r($_SESSION['user']);
?>

<?php
?>
<h3>ชื่อผู้ใช้ : <?php echo $_SESSION['user']['firstname'] .' '.$_SESSION['user']['lastname'];?></h3>
<?php

?>
<h3>ระดับผู้ใช้ : <?php echo $_SESSION['user']['user_type'];?></h3>
