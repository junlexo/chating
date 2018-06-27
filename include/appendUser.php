<?php 
session_start();
include("general.php");
if(isset($_GET["id"]))
{
	$userfrom = $_SESSION['username'];
	$userto = $_GET["id"];	
}
?>
<div class="message-friend" id="message-<?php echo $userto;?>">				
	<div class="title-message">
		<a class="user-message-to"><?php echo $userto;?></a>	
		<a class="close-message">X</a>
	</div>
	<div class="content-message">					
	<?php 
		$query_messager = mysqli_query($cn, "SELECT * FROM messager WHERE (userfrom = '$userfrom' AND userto = '$userto') OR (userfrom = '$userto' AND userto = '$userfrom')");
		while ($row = mysqli_fetch_assoc($query_messager)) {
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
	</div>
	<div class="message-friend-send">
		<div class="input-text">
			<input type="text" name="comment">
			<a class="show-icon">😵</a>
			<div class="list-icon hide">
				<?php	
					$handle_Icon = fopen("../dataFeel.json", "r");
					$index_Icon = 0;
					if ($handle_Icon) {
						while (($line_Icon = fgets($handle_Icon)) !== false) {
							echo '<span>'.$line_Icon.'</span>';
						}
					}
				?>	
			</div>
		</div>
		<a class="btn-send-friend">Gửi</a>
	</div>
</div>
