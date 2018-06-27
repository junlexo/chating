<?php
	session_start();
	include("general.php");
	$target_dir = "../upload/";
	$save_dir = "upload/";

	// echo $_POST["uploadFile"];
	if(isset($_FILES) && !empty($_FILES))
	{			
		$imageFileType = pathinfo(basename($_FILES["uploadFile"]["name"]),PATHINFO_EXTENSION);
		$date_sent = $date_curent;
	    $day_sent = substr($date_sent, 8, 2); // Ngày gửi
	    $month_sent = substr($date_sent, 5, 2); // Tháng gửi
	    $year_sent = substr($date_sent, 0, 4); // Năm gửi
	    $hour_sent = substr($date_sent, 11, 2); // Giờ gửi
	    $min_sent = substr($date_sent, 14, 2); // Phút gửi
	    $sec_sent = substr($date_sent, 17, 2); // Giây gửi
		$target_dir = $target_dir.$day_sent.$month_sent.$year_sent.$hour_sent.$min_sent.$sec_sent.".".$imageFileType;
		$save_dir = $save_dir.$day_sent.$month_sent.$year_sent.$hour_sent.$min_sent.$sec_sent.".".$imageFileType;
		$userfrom = $_POST["username"];		
		//$query_send_msg1 = mysqli_query($cn, "DELETE FROM cover WHERE username = '$userfrom'");
		$query_send_msg = mysqli_query($cn, "INSERT INTO cover VALUES (
                '',
                '$userfrom',
                '$save_dir'
            )");			
		move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_dir);
	}	
?>
