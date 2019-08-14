<?php
	$servername = 'localhost';
	$username = 'root';
	$password = 'imooc';
	$dbname = 'web_datas';
	//创建连接
	$conn = new mysqli($servername, $username, $password, $dbname);
	//检查连接
	/*if($con->connect_error){
		die("连接失败：".$conn->connect_error);
	}*/
?>