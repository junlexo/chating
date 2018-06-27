<?php 
	session_start();
	if(!$_SESSION['username'])
		echo '<script>window.location = "login.php";</script>'; // Chuyển qua trang chat
	include ('include/general.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chatting</title>
	<meta charset="utf-8">
	<?php 
		include ('include/header.php');
	?>
</head>
<body class="body">
	<div class="container">
		<div class="main-menu">
			<h1><i class="fa fa-commenting"></i> Messenger</h1>
			<a href="logout.php">Đăng xuất</a>
		</div>
		<div class="message">
			<div class="list-message">
			</div>
			<div class="textbox">
				<input type="text" name="comment">
				<a >Gửi</a>
				<p class="view-error"></p>
			</div>
		</div>
	</div>
	<?php 
		include ('include/footer.php');
	?>
</body>
</html>