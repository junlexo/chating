<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<?php 
		include ('include/header.php');
	?>
</head>
<body class="body">
	<div class="box-join">
	    <p>Tạo tài khoản hoặc đăng nhập để tham gia với chúng tôi</p>
	    <form method="POST" id="formJoin" onsubmit="return false;">
	    	<input type="text" placeholder="Biệt danh ( Biệt danh mới )" class="data-input" id="sigal">
	        <input type="text" placeholder="Tên đăng nhập" class="data-input" id="username">
	        <input type="password" placeholder="Mật khẩu" class="data-input" id="password">
	        <button class="btn-submit">Tham Gia</button>
	        <div class="alert danger"></div>
	    </form><!-- form#formJoin -->
	</div><!-- div.box-join -->
	<script type="text/javascript" src="lib/javascript/jquery.min.js"></script>
	<script type="text/javascript" src="lib/javascript/bootstrap.min.js"></script>
	<script type="text/javascript" src="javascript/login.js"></script>
</body>
</html>