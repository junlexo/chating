<?php
session_start();
// Kết nối database, lấy dữ liệu chung
include('general.php');
// echo '<div class="Error-fix">'
//         . '<h2>ĐANG SỬA XIN LỖI.....</h2>'
//         .'</div>';
// Lấy dữ liệu từ table messages theo thứ tự id_msg tăng dần
$query_get_msg = mysqli_query($cn, "SELECT * FROM room ORDER BY id ASC");
// Dùng vòng lập while để lấy dữ liệu
while ($row = mysqli_fetch_assoc($query_get_msg)) {
    // Thời gian gửi tin nhắn
    $date_sent = $row['date_create'];
    $day_sent = substr($date_sent, 8, 2); // Ngày gửi
    $month_sent = substr($date_sent, 5, 2); // Tháng gửi
    $year_sent = substr($date_sent, 0, 4); // Năm gửi
    $hour_sent = substr($date_sent, 11, 2); // Giờ gửi
    $min_sent = substr($date_sent, 14, 2); // Phút gửi
    // Nếu người gửi là $user thì hiển thị khung tin nhắn màu xanh
    if ($row['userfrom'] == $_SESSION['username']) {
        echo '<div class="msg-user">
                        <span>' . $row['body'] . '</span>
                        <div class="info-msg-user">
                                Bạn - ' . $day_sent . '/' . $month_sent . '/' . $year_sent
                                . ' lúc ' . $hour_sent . ':' . $min_sent 
                                . '</div>
                </div>';
    }
    // Ngược lại người gửi không phải là $user thì hiển thị khung tin nhắn màu xám
    else {
        $user = $row['userfrom'];
        $query_get_userfrom = mysqli_query($cn, "SELECT * FROM user WHERE username = '$user'");
        $rowuser = mysqli_fetch_assoc($query_get_userfrom);
        echo '  <div class="msg">
                        <span>' . $row['body'] . '</span>
                        <div class="info-msg">
                                ' . $row['userfrom'] . ' - ' . $day_sent . '/' . $month_sent . '/' . $year_sent 
                                . ' lúc ' . $hour_sent . ':' . $min_sent 
                                . '
                        </div>
                </div>';
    }
}
?>