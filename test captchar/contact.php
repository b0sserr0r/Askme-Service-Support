<?php 

	session_start();

	if ( isset($_POST['message'], $_POST['token']) ) {

		
		$token = strtolower($_POST['token']);

		// validate captcha code 		
		if (isset($_SESSION['captcha_token']) && $_SESSION['captcha_token'] == $token) {

			//success your code here

			$to = "somebody@example.com";
			$subject = "subject";
			$message = $_POST['message'];
			$headers = "From: webmaster@example.com" . "\r\n" .  "CC: somebodyelse@example.com";
			
			//mail($to, $subject, $message, $headers);

			echo "success";

		} else {
			echo "error CAPTCHA code";
		}
		
	}
?>