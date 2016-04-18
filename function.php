<?php
if(!isset($_SESSION)){
	session_start();
}
function redirect($url){
	echo "<script> location.replace('".$url."');</script>";
}

function is_admin(){
	if(isset($_SESSION['user'])){// Login หรือยัง
		if($_SESSION['user']['user_type']!='admin'){// ถ้าไม่เป็น admin
			redirect('index.php');
		}
	}else{//ยังไม่เข้าระบบ
		redirect('login.php');
	}
}

function is_login(){
	if(!isset($_SESSION['user'])){//ยังไม่ login
		redirect('login.php');
	}
}