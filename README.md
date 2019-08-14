# web-page
设计并实现一个个人主页及其后台维护系统

### 一、实验任务

设计并实现一个个人主页及其后台维护系统。要求如下：

1. 个人主页需要包含以下几个方面的内容：基本信息、照片、工作（学习）经历、获奖情况、其他等
2. 个人主页需要符合W3C规范，能通过[W3C](http://validator.w3.org)检测
3. 个人主页中的各项个人信息（含照片）均来自于后台服务器
4. 提供个人主页后台管理页面（通过个人主页中的链接进入）
5. 用户登录系统后即可实现对自己主页的维护
6. 系统登录采用短信验证的方式（后台存储了每个用户的手机号码），可尝试使用百度的短信平台
7. 维护信息包含照片的上传

可参考我校、我院及其他学校的教师个人主页

### 二、实验环境

php+mysql(8.0.13)

使用phpstudy搭建本地服务器

php(5.4.45)+Apache

### 三、实验过程及代码分析

#### 1、首页

![1547382855717](http://cdn.peckerwood.top/2019-08-14_204054.png)

​	首页由左侧导航栏与右边的个人简介组成，导航栏有两个选项，一个是当前显示的“Home”，即主页，一个“admin”，点击可管理个人信息，如果登陆之后再访问主页，此时导航栏会增加一个标签“logout”，即登出。

```php+HTML
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
```

​	登陆之后，将admin加入session['user']，所以这里可用session['user']是否为空来判断是否登陆。



​	个人简介处的头像和基本信息均可以在后台管理界面进行修改。

​	![1547383809838](http://cdn.peckerwood.top/2019-08-14_205009.png)



#### 2、登陆界面

![1547384773366](C:\Users\lenovo\AppData\Roaming\Typora\typora-user-images\1547384773366.png)

​	输入电话号码，点击发送验证码，通过ajax访问容联云实现短信测试的接口"SDK/SendTemplateSMS.php"，

收到的短信图如下：

![1547385566393](C:\Users\lenovo\AppData\Roaming\Typora\typora-user-images\1547385566393.png)

​	输入正确的短信验证码后即可进入admin.php页面。

```php+HTML
<?php
  session_start(); //首先要开始session
  //已登录，跳转至admin
  if(isset($_SESSION['user'])){
    header('location:admin/admin.php');
    exit();
  }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>login</title>
	<link rel="stylesheet" href="css/demo.css" type="text/css">
	<script type="text/javascript">
		function getverification(){
			if(window.XMLHttpRequest){
				// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
			    xmlhttp=new XMLHttpRequest();
			}else{
				// IE6, IE5 浏览器执行代码
				xmlhttp = new ActiveXObject(
					"Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function(){}
			xmlhttp.open("GET", "SDK/SendTemplateSMS.php",true);
			xmlhttp.send();
		}
	</script>
</head>
<body>
	<ul>
		<li><a href="index.php">首页</a></li>
		<li><a href="#" class="active">登录</a></li>
	</ul>
	<div style="margin-left: 15%;padding: 1px 16px;height: 1000px;">
		<h1>后台管理系统</h1>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
			<input type="text" name="telphone" placeholder="telphone">
			<br/>
			<input type="text" name="checkcode" placeholder="checkcode">
			<br/>
			<input class="button" type="button" name="Verification"  value="发送验证码" onclick="getverification()" style="width: 100px;">
			<input class="button" type="submit" name="submit" value="登录">
		</form>
		<?php 
			
			//echo "<p>".$_SESSION['code']."</p>";
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if($_POST['checkcode'] == $_SESSION['code']){
					$_SESSION['user'] = "admin";
					echo "<script>alert('Login Success!');location.href='admin/admin.php'</script>";
					exit();
				}else{
					echo "<script>alert('Verification code is not correct.Please try again!');history.go(-1);</script>";
					exit();
				}
			}
		?>
	</div>
</body>
</html>
```

#### 3、后台管理页面

​	左边导航栏由四个标签：首页，个人信息（默认active），照片修改和登出组成。页面先从数据库读取个人信息，作为信息输入框的默认值，修改完成后，点击保存，即可将表单提交给update.php

![1547385666001](http://cdn.peckerwood.top/2019-08-14_205427.png)

update.php

```php+HTML
<?php
$servername = 'localhost';
$username = 'root';
$password = 'imooc';
$dbname = 'web_datas';
//创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_query($conn, "UPDATE student SET sid='".$_POST['sid']."' WHERE id=1");
mysqli_query($conn, "UPDATE student SET sname='".$_POST['sname']."' WHERE id=1");
mysqli_query($conn, "UPDATE student SET exp='".$_POST['exp']."' WHERE id=1");
mysqli_query($conn, "UPDATE student SET award='".$_POST['award']."' WHERE id=1");

$conn->close();
echo "<script>alert('Save Success!');location.href='admin/admin.php'</script>";
?>
```

​	点击照片修改后进入修改照片界面，如下所示，页面先从后台读取头像显示，点击选择文件从本地选取图片文件，点击保存，后台将上传的图像存入img文件夹，然后重新链接至新图像，完成头像修改。

![png](http://cdn.peckerwood.top/2019-08-14_204503.png)

admin.php

```php+HTML
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
```



updatephoto.php

```php+HTML
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
```

​	点击后台管理系统的“登出”标签，清除session['user']，提示成功登出，跳转至主页。

```php
<?php
session_start();
unset($_SESSION['user']);
echo "<script>alert('You have logouted');location.href = 'index.php'</script>";
```



 