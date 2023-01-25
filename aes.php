<?php 
	session_start();
		if(isset($_SESSION['unique_id']))
			include_once "php/config.php";
        $a2= $_SESSION['unique_id'];
        $b2 = mysqli_real_escape_string($conn, $_GET['user_id']);
		$a2=fmod($a2,100);
		while($a2>45)
		{
			$a2=$a2-4;
		}
		if($a2==0)
		{
			$a2=15;
		}
		$b2=fmod($b2,100);
		while($b2>45)
		{
			$b2=$b2-4;
		}
		if($b2==0)
		{
			$b2=15;
		}

	$prime=2101111;
    $gen=5;
    $res1=fmod(pow($gen,$a2),$prime);
    $encryption_key=fmod(pow($res1,$b2),$prime);
	echo "Key used in encryption: ". $encryption_key;
	$cipher = "aes-128-cbc";
	$iv = "9854563214789632"; 
	$data="Testing Here"; 
	echo "<br/>Plaintext: ". $data;
$message = openssl_encrypt($data, $cipher, $encryption_key, 0, $iv); 

echo "<br/>Encrypted Text: " . $message; $decrypted_data = openssl_decrypt($message, $cipher, $encryption_key, 0, $iv); 

echo "<br/>Decrypted Text: " . $decrypted_data; 


$message = mysqli_real_escape_string($conn, $message);

?>
	