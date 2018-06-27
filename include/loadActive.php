<?php 
session_start();
include ('general.php');
	if($_SESSION['username'] == 'ThanhLN6')
	{
		$query_get_active = mysqli_query($cn, "SELECT * FROM user WHERE is_active = 1 AND username <> 'ThanhLN6'");
		while ($row1 = mysqli_fetch_assoc($query_get_active))
		{
			echo "<div class='user-active'><a target='_blank' href='include/unActiveAccount.php?id=".$row1['username']."'>".$row1['username']."</a></div>";
		}
	}
?>