<?php 
session_start();
include ('general.php');
	$usercurrent = $_SESSION['username'];
	$query_get_active = mysqli_query($cn, "SELECT * FROM user WHERE is_active = 1 AND username <> '$usercurrent'");
	while ($row1 = mysqli_fetch_assoc($query_get_active))
	{
		if($row1['singal'])
			echo "<div class='friend'><span class='avatar'><img src='image/avatar.png' class='img-responsive'></span><span class='name hide'>".$row1['username']."</span><span class='singal'>".$row1['singal']."</span></div>";
		else
			echo "<div class='friend'><span class='avatar'><img src='image/avatar.png' class='img-responsive'></span><span class='name hide'>".$row1['username']."</span><span class='singal'>".$row1['username']."</span></div>";
	}
?>
