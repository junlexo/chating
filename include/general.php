<?php
// Bắt đầu lưu session
// Nếu tồn tại session
if (@$_SESSION['username']) {
    // Gán $user = session
    $user = $_SESSION['username'];
}
// Ngược lại 
else {
    // $user rỗng
    $user = '';
}
?>
<?php 
	//ket not voi file connectdb.php
	include('connectdb.php');
	//lay mui gio
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$date_curent = '';
	$date_curent = date("Y-m-d H:i:s:sa");
?>