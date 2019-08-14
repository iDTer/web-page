<?php
session_start();
unset($_SESSION['user']);
echo "<script>alert('You have logouted');location.href = 'index.php'</script>";