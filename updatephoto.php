
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>admin</title>
	<link rel="stylesheet" href="css/demo.css" type="text/css">
</head>
<body>
	<ul>
		<li><a href="admin/admin.php">个人信息</a></li>
		<li><a class="active" href="updatephoto.php">照片修改</a></li>
	</ul>
	<div style="margin-left: 15%;padding: 1px 16px;height: 1000px;">
		<h1>后台管理系统</h1>
		<?php
			$path = "img/";
			$file = scandir($path,1);
			echo "<img src=\"img/".$file[0]."\"width=\"150\"height=\"150\">";
		?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
		<input type="file" name="newimg" value="选择文件">	
		<input type="submit" name="submit" value="保存">
	</form>
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			unlink("img/timg.jpg");
			move_uploaded_file($_FILES["newimg"]["tmp_name"], "img/timg.jpg");
			echo "<script>alert('Saved!');location.href = 'updatephoto.php?'+Math.random()</script>";
		}
	?>
	</div>
</body>
</html>