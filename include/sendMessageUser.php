<?php
	session_start();
	include ('general.php');
	// Khai báo các biến gán với dữ liệu nhận đượ
	$body_msg = @mysqli_real_escape_string($cn, $_POST['body']);
	$userto = @mysqli_real_escape_string($cn, $_POST['userto']);
	// Nếu $body_msg khác rỗng
	if ($body_msg != '') {
        // Thực thi gửi tin nhắn
        $userfrom = $_SESSION['username']; 	
        $query_send_msg = mysqli_query($cn, "INSERT INTO messager VALUES ('','$userfrom','$userto','$body_msg','$date_curent')");
	}
?>