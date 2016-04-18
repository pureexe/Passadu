<?php
if(!isset($_SESSION)){
	session_start();
}
include 'function.php';
is_admin();
include 'html_head.php';

//print_r($_SESSION['user']);
?>
<h2>สวัสดี <?php echo $_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname'];?></h2>

<?php
include 'html_foot.php';
?>