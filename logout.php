<?php
if(!isset($_SESSION)){
	session_start();
}
include 'function.php';
unset($_SESSION['user']);//ยกเลิก Session

redirect('login.php');//เด้งไปหน้า index.php