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