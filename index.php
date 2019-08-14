<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<!-- header部分 -->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--上述3个meta标签必须放在最前面，任何其他内容都必须跟随其后！ -->
	<link rel="icon" href="public/img/favicon.ico">
	<title>web page</title>
	<link rel="stylesheet" href="css/demo.css" type="text/css">
</head>
<body>
	<ul id="nav"><!-- nav -->
		<li><a href="#" class="active">Home</a></li>
		<?php
			if(!isset($_SESSION['user'])){
		?>
		<li><a href="login.php">admin</a></li>
		<?php
			}else{
		?>
		<li><a href="logout.php">logout</a></li>
		<li><a href="admin/admin.php">admin</a></li>
		<?php
			}
		?>
	</ul><!-- /.nav -->

<div style="margin-left: 15%;padding: 1px 16px;height: 1000px;">
	<img src="img/timg.jpg" class="avatar" height="150" width="150">
	<?php
	require('connect.php');
	$sql = "SELECT sid, sname, exp, award FROM student";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()){
			echo "<p class='word'>"."学号：".$row['sid']."</p>";
			echo "<p class='word'>"."姓名：".$row['sname']."</p>";
			echo "<p class='word'>"."个人经历：".$row['exp']."</p>";
			echo "<p class='word'>"."获得奖项：".$row['award']."</p>";
		}
	}
	$conn->close();
	?>

</div>
</body>
</html>