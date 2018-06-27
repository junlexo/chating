<?php 
session_start();
// Kết nối database, lấy dữ liệu chung
include('general.php');
include('getip.php');
// Khai báo các biến nhận dữ liệu
$username = @mysqli_real_escape_string($cn, $_POST['username']);
$password = @mysqli_real_escape_string($cn, $_POST['password']);
$sigal = @mysqli_real_escape_string($cn, $_POST['sigal']);

// Các biến hiển thị thông báo 
$show_alert = '<script>$("#formJoin .alert").show();</script>'; // Hiển thị thông báo lỗi
$hide_alert = '<script>$("#formJoin .alert").hide();</script>'; // Ẩn thông báo lỗi
$success_alert = '<script>$("#formJoin .alert").attr("class", "alert success");</script>'; // Thông báo thành công

$query_check_exist_user = mysqli_query($cn, "SELECT * FROM user WHERE username = '$username'");
if($username == '' || $password == '')
{
	echo $show_alert.'Vui lòng nhập đầy đủ thông tin.';
}
else
{
	if(mysqli_num_rows($query_check_exist_user)) 
	{
		$password = md5($password);
		$query_check_login1 = mysqli_query($cn, "SELECT * FROM user WHERE username = '$username' AND password = '$password' AND is_active = '1'");
		$query_check_login = mysqli_query($cn, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
		if(mysqli_num_rows($query_check_login) > 0)
		{
			if(mysqli_num_rows($query_check_login1) > 0)
			{
				echo $show_alert . $success_alert . 'Đăng nhập thành công.'; // Thông báo
				$_SESSION['username'] = $username;			
				$user_ip = getUserIP();
				if($sigal != '')
					$query_update_userip = mysqli_query($cn, "UPDATE user SET  ip_last =  '$user_ip', singal = '$sigal' WHERE username = '$username'");
				else
					$query_update_userip = mysqli_query($cn, "UPDATE user SET  ip_last =  '$user_ip' WHERE username = '$username'");
				echo '<script>window.location = "index.php";</script>'; // Chuyển qua trang chat
			}	
			else
				echo $show_alert . 'Tài khoản chưa được kích hoạt vui lòng liên hệ ThanhLN6.'; // Thông báo		
		}
		else
		{
			echo $show_alert . 'Tên đăng nhập hoặc mật khẩu không chính xác.'; // Thông báo
		}
	}
	else
	{
		if(strlen($username) < 6 && strlen($username) > 40)
		{
			echo $show_alert."Tên đăng nhập trong khoảng từ 6-40 ký tự.";
		}
		else if(preg_match('/\W/', $username))
		{
			echo $show_alert."Tên đăng nhập không được chứa khoảng trống hoặc ký tự đặc biệt.";	
		}
		else if(strlen($username) < 6)
		{
			echo $show_alert."Tên đăng nhập quá ngắn.";		
		}
		else 
		{
			$user_ip = getUserIP();
			$password = md5($password);
			$query_create_user = mysqli_query($cn, "INSERT INTO user VALUES (
                        '',
                        '$username',
                        '$password',
						0,                        
                        '$date_curent',
                        '$sigal',
                        '$user_ip',
                        ''
                    )");
			echo $show_alert . $success_alert . 'Đăng ký tài khoản thành công. Vui lòng liên hệ ThanhLN6 để kích hoạt tài khoản!'; // Thông báo
            $_SESSION['username'] = $username; // Lưu session giá trị username
            // $_SESSION['is_active'] = false;
            // echo '<script>window.location = "index.php";</script>'; // Chuyển qua trang chat
		}
	}
}
?>