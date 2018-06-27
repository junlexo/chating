<?php
include('general.php');
class ChatHandler {
	function send($message, $send_type, $usersend, $userrecv) {
		global $clientSocketArray;
		$messageLength = strlen($message);
		switch ($send_type) {
			case 'room':
				foreach($clientSocketArray as $clientSocket)
				{
					@socket_write($clientSocket,$message,$messageLength);
				}
				break;
			case 'message':
				$namehost = 'localhost';
				$userhost = 'root';
				$passhost = '260610';
				$database = 'chating';		 
				// Lệnh kết nối tới database
				$cn = mysqli_connect($namehost, $userhost, $passhost, $database);
				mysqli_set_charset($cn,"utf8");
				$date_curent = '';
				$date_curent = date("Y-m-d H:i:sa");	
				$query_user_socket1 = mysqli_query($cn, "SELECT clientSocket FROM user WHERE username = '$usersend'");
				$query_user_socket2 = mysqli_query($cn, "SELECT clientSocket FROM user WHERE username = '$userrecv'");
				$row1 = mysqli_fetch_assoc($query_user_socket1);
				$row2 = mysqli_fetch_assoc($query_user_socket2);
				$loop = 1;
				foreach($clientSocketArray as $clientSocket)
				{
					if((string)$clientSocket == $row1['clientSocket'] || (string)$clientSocket == $row2['clientSocket'] || $loop == 1)
					{
						echo $clientSocket." - ".$row1['clientSocket']." - ".$loop."\n";
						@socket_write($clientSocket,$message,$messageLength);						
					}
					$loop++;
				}
				//@socket_write($row1['clientSocket'],$message,$messageLength);
				//@socket_write($row2['clientSocket'],$message,$messageLength);
				break;
		}		
		return true;
	}

	function unseal($socketData) {
		$length = ord($socketData[1]) & 127;
		if($length == 126) {
			$masks = substr($socketData, 4, 4);
			$data = substr($socketData, 8);
		}
		elseif($length == 127) {
			$masks = substr($socketData, 10, 4);
			$data = substr($socketData, 14);
		}
		else {
			$masks = substr($socketData, 2, 4);
			$data = substr($socketData, 6);
		}
		$socketData = "";
		for ($i = 0; $i < strlen($data); ++$i) {
			$socketData .= $data[$i] ^ $masks[$i%4];
		}
		return $socketData;
	}

	function seal($socketData) {
		$b1 = 0x80 | (0x1 & 0x0f);
		$length = strlen($socketData);
		
		if($length <= 125)
			$header = pack('CC', $b1, $length);
		elseif($length > 125 && $length < 65536)
			$header = pack('CCn', $b1, 126, $length);
		elseif($length >= 65536)
			$header = pack('CCNN', $b1, 127, $length);
		return $header.$socketData;
	}

	function doHandshake($received_header,$client_socket_resource, $host_name, $port) {
		$headers = array();
		$lines = preg_split("/\r\n/", $received_header);
		foreach($lines as $line)
		{
			$line = chop($line);
			if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
			{
				$headers[$matches[1]] = $matches[2];
			}
		}

		$secKey = $headers['Sec-WebSocket-Key'];
		$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
		$buffer  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
		"Upgrade: websocket\r\n" .
		"Connection: Upgrade\r\n" .
		"WebSocket-Origin: $host_name\r\n" .
		"WebSocket-Location: ws://$host_name:$port/demo/shout.php\r\n".
		"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
		socket_write($client_socket_resource,$buffer,strlen($buffer));
	}
	
	function newConnectionACK($client_ip_address, $newSocket) {
		$namehost = 'localhost';
		$userhost = 'root';
		$passhost = '260610';
		$database = 'chating';		 
		// Lệnh kết nối tới database
		$cn = mysqli_connect($namehost, $userhost, $passhost, $database);
		mysqli_set_charset($cn,"utf8");
		$date_curent = '';
		$date_curent = date("Y-m-d H:i:sa");	
		$query_userip = mysqli_query($cn, "SELECT * FROM user WHERE ip_last = '$client_ip_address'");
		mysqli_query($cn, "UPDATE user SET  clientSocket =  '$newSocket' WHERE ip_last = '$client_ip_address'");
		while ($row = mysqli_fetch_assoc($query_userip)) {
			if($row['singal'])		
				$message = $row['singal']. ' joined';
			else
				$message = $row['username']. ' joined';
			$messageArray = array('message'=>$message,'message_type'=>'chat-connection-ack','date_curent'=>$date_curent);
			$ACK = $this->seal(json_encode($messageArray));
		}
		return $ACK;
	}
	
	function connectionDisconnectACK($client_ip_address) {
		$namehost = 'localhost';
		$userhost = 'root';
		$passhost = '260610';
		$database = 'chating';		 
		// Lệnh kết nối tới database
		$cn = mysqli_connect($namehost, $userhost, $passhost, $database);
		mysqli_set_charset($cn,"utf8");
		$date_curent = '';
		$date_curent = date("Y-m-d H:i:sa");	
		$query_userip = mysqli_query($cn, "SELECT * FROM user WHERE ip_last = '$client_ip_address'");
		while ($row = mysqli_fetch_assoc($query_userip)) {
			if($row['singal'])
				$message = $row['singal'].' disconnected';
			else
				$message = $row['username']. ' disconnected';
			$messageArray = array('message'=>$message,'message_type'=>'chat-connection-ack','date_curent'=>$date_curent);
			$ACK = $this->seal(json_encode($messageArray));
		}
		return $ACK;
	}	
	function createChatBoxMessage($chat_type,$chat_user, $user_to,$chat_box_message) {
		// $message = $chat_user . ": <div class='chat-box-message'>" . $chat_box_message . "</div>";	
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$date_curent = '';
		$date_curent = date("Y-m-d H:i:sa");
		switch ($chat_type) {
				case 'room':
					# code...
					$messageArray = array('chatType'=>'room','user'=>$chat_user,'message'=>$chat_box_message,'message_type'=>'chat-box-html', 'date_curent'=>$date_curent);
					break;
				case 'message':
					# code...
					$messageArray = array('chatType'=>'message','user'=>$chat_user,'userto'=>$user_to,'message'=>$chat_box_message,'message_type'=>'chat-box-html', 'date_curent'=>$date_curent);
					break;
				default:
					# code...
					break;
			}	
		
		// $message = $chat_user . ": <div class='chat-box-message'>" . $chat_box_message . "</div>";	
		
		// }
		$chatMessage = $this->seal(json_encode($messageArray));
		return $chatMessage;
	}
}
?>