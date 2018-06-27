<?php 
session_start();
include ('general.php');
	if($_SESSION['username'] == 'ThanhLN6')
	{
		$query_get_active = mysqli_query($cn, "SELECT * FROM user WHERE is_active = 0");
		while ($row1 = mysqli_fetch_assoc($query_get_active))
		{			
			echo "<div class='user-un-active'><a target='_blank' href='include/activeAccount.php?id=".$row1['username']."'>".$row1['username']."</a></div>";
		}
	}
?>