<?php
	session_start();
	//若没有登陆，跳转至主页
	if(!isset($_SESSION['user'])){
		echo "<script>alert('Please login!');location.href = '../index.php'</script>";
    	//header('location:../index.php');
    	exit();
  	}
	require('../connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta  charset="utf-8">
	<title>Admin</title>
	<link rel="stylesheet" href="../css/demo.css" type="text/css">
</head>
<body>
	<ul>
		<li><a href="../index.php">首页</a></li>
		<li><a class="active">个人信息</a></li>
		<li><a href="../updatephoto.php">照片修改</a></li>
		<li><a href="../logout.php">登出</a></li>
	</ul>
	<div id="data" style="margin-left: 15%;padding: 1px 16px;height: 1000px;">
		<h1>后台管理系统</h1>
		<form method="POST" action="../update.php">
		<?php
			$sql = "SELECT sid, sname, exp, award FROM student";
			$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()){
				$sid = $row['sid'];
				$sname = $row['sname'];
				$exp = $row['exp'];
				$award = $row['award'];
			}
		}
		$conn->close();
		?>
		<p>学号：</p><input type="text" name="sid" value="<?php echo $sid; ?>">
		<p>姓名：</p><input type="text" name="sname" value="<?php echo $sname; ?>">
		<p>个人经历：</p><input type="text" name="exp" value="<?php echo $exp; ?>">
		<p>获得奖项：</p><input type="text" name="award" value="<?php echo $award; ?>">
		<br/>
		<input type="submit" name="submit" value="保存">
		</form>
	</div>
</body>
</html>