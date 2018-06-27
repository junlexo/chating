<?php 
	session_start();
	if(!$_SESSION['username'])
		echo '<script>window.location = "login.php";</script>'; // Chuyển qua trang chat
	include ('include/general.php');
	$username = $_SESSION['username'];
	$query_get_msg = mysqli_query($cn, "SELECT * FROM cover WHERE username = '$username'");
	
?>
<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<title>Junlexo</title>
	<link rel="icon" type="image/icon" href="panda.ico">
	<link rel="stylesheet" type="text/css" href="css/xampp.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="lib/css/slick.css">
	<link rel="stylesheet" type="text/css" href="lib/css/slick-theme.css">
</head>
<?php	
	$handle = fopen("music_path/bienso.txt", "r");
	$index = 0;
?>	
<body class="body n">
	<div class="tab-message">
		<div class="message-box">
			<a id="view-history">Xem tin nhắn trước</a>
			<div class="main-menu">
				<h1><i class="fa fa-commenting"></i> Messenger</h1>			
				<span id="chat-user"><?php echo  $_SESSION['username']?></span><a href="logout.php">Đăng xuất</a>
			</div>
			<div class="listmessage">			
			</div>		
			<div >
				<div class="messageSend">
					<div class="input-text">
						<input type="text" name="comment">
						<a id="showIcon">😵</a>
						<div class="listIcon hide">
							<?php	
								$handle_Icon = fopen("dataFeel.json", "r");
								$index_Icon = 0;
								if ($handle_Icon) {
									while (($line_Icon = fgets($handle_Icon)) !== false) {
										echo '<span>'.$line_Icon.'</span>';
									}
								}
							?>	
						</div>
					</div>
					<a id="sendMessage">Gửi</a>
				</div>
			</div>
		</div>
		<div class="upload-box">				
			<div >
				<div class="messageSend">
					<form name="upload" enctype="multipart/form-data" action="./include/uploadFile.php" method="post">
						<input type="file" id="uploadFile" name="uploadFile">
						<input type="hidden"  name="username" id="username" value="<?php echo  $_SESSION['username']?>">		
						<a id="sendFile">Gửi File</a>										
						<div class="view-result"></div>
					</form>
				</div>
			</div>
		</div>
		<?php 
		if($_SESSION['username'] == 'ThanhLN6')
			{
		 ?>
		<div class="show-un-active">
			<span>Need Active</span>
			<div class="listuser">								
			</div>		
		</div>
		<div class="show-active">
			<span>Don't Unactive :'((</span>
			<div class="listuser">								
			</div>		
		</div>
		<?php 
			}
		?>
	</div>
	<div class="background-image">
		<div class="list-image">
			<?php while($row = mysqli_fetch_assoc($query_get_msg)){ ?>
			<div class="image" style="background: url(<?php if($row['path']) echo './'.$row['path'];
				else 
					echo 'img/bg_girl.jpg'?>) center center no-repeat;">			
			</div>
			<?php }?>
		</div>	
	</div>
	<div class="table-parent">
		<div class="control-video">
			<video controls="" autoplay="" name="media" class="video-manul" id="music"><source src="<?php echo "music_path/A%20Woman%20Loves%20A%20Man%20-%20Joe%20Cocker%20(NhacPro.net).mp3"; ?>" type="audio/mpeg"></video>
			<label for="repeat"><input type="checkbox" name="repeat" id="repeat" class="hide"><img src="image/unrepeat.png" class="img-responsive"></label>
		</div>
		<video controls="" autoplay="false" name="nofication" id="nofication" class="hide"><source src="<?php echo "media/smile.mp3"; ?>" type="audio/mpeg"></video>
		<span>5RP2E-EPH3K-BR3LG-KMGTE-FN8PY</span>
		<br>
		<span>E:\Test_SVN\Counter-Strike\hl.exe -nomaster -game cstrike</span>
		<span class="btn-open-music"><img src="./image/close-btn.png" class="img-responsive"></span>
		<div class="list-friend hide">
		</div>
		<div class="show-list-message-friend hide">
			<div class="list-message-friend">				
			</div>
		</div>
		<div class="table-manul">			
			<table>
				<tr>
					<td class="<?php if($index == 0) echo "active"; $index++; ?>">
						<a href="http://<?php echo $_SERVER['SERVER_ADDR']; ?>:3000" target="_blank"><?php echo $_SERVER['SERVER_ADDR']; ?>:3000</a><br>				   
					</td>
				</tr>	
				<?php 
					if ($handle) {
						while (($line = fgets($handle)) !== false) {					
				?>
				<tr>
					<td class="<?php if($index == 0) echo "active"; $index++; ?>">
						<a href="#<?php echo $line; ?>"><?php echo $line; ?></a><br>				   
					</td>
				</tr>	
				<?php	
				        // process the line read.
					}
					fclose($handle);
				}
				?> 
			</table>
		</div>		
	</div>
		<?php 				
			include ('include/footer.php');
		?>				
</body>
</html>
	