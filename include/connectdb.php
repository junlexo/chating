<?php
$namehost = 'localhost';
$userhost = 'root';
$passhost = '260610';
$database = 'chating';
 
// Lệnh kết nối tới database
$cn = mysqli_connect($namehost, $userhost, $passhost, $database);
mysqli_set_charset($cn,"utf8mb4");
// Nếu kết nối database thất bại sẽ báo lỗi
if (!$cn) {
    echo 'Could not connect to database.';
}
?>