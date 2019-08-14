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
