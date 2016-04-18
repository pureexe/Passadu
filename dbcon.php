<?php
// ไฟล์สำหรับเชื่อมต่อฐานข้อมูล
# xxxxx
/*
x
x
*/

$host = 'localhost';//database hostname
$user = 'pure_passadu';//database username
$pass = '12345678';//database password
$db = 'pure_passadu';//database name

try{
	$con = new PDO("mysql:host=".$host."; dbname=".$db."",
			$user,$pass,
			array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
}catch(PDOException $e){//ดักจับ ERROR แล้วเก็บไว้ใน $e
	echo $e->getMessage();# แสดงออกมาหน้าจอ
}