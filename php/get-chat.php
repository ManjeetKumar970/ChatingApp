<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = "";
		$a2= $outgoing_id;
		$b2 = $_POST['incoming_id'];
		
    $encryption_key=$a2+$b2;
	$cipher = "aes-128-cbc";
	$iv = "9854563214789632"; 
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){
					$message=openssl_decrypt($row['msg'], $cipher, $encryption_key, 0, $iv);
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $message .'</p>
                                </div>
                                </div>';
                }else{
                    $message=openssl_decrypt($row['msg'], $cipher, $encryption_key, 0, $iv);
                    $output .= '<div class="chat incoming">
                                <img src="php/images/'.$row['img'].'" alt="">
                                <div class="details">
                                    <p>'. $message .'</p>
                                </div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        }
        echo $output;
    }else{
        header("location: ../login.php");
    }

?>