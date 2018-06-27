<?php 
session_start();
// Kết nối database, lấy dữ liệu chung
include('general.php');

if(isset($_GET["id"]))
{
	$useractive = $_GET["id"];	
	$query_update_userActive = mysqli_query($cn, "UPDATE user SET  is_active =  0 WHERE username = '$useractive'");
	echo "<script>window.close();</script>";
}
?>