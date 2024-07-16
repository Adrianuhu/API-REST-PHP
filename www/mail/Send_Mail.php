<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';
	
    function Send_Mail($to,$subject,$body){
		// include ($_SERVER['DOCUMENT_ROOT'].'/configFiles/config.php');

		// TESTS LOCAL
		include ($_SERVER['DOCUMENT_ROOT'].'/bbtournaments/configFiles/config.php');
        $mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->isSMTP();
		$mail->SMTPDebug  = 0;
		$mail->SMTPAuth   = true;
		$mail->Host       = "smtp.hostinger.com";
		$mail->Port       = 587;
		$mail->Username   = $config['mailUserName'];
		$mail->Password   = $config['mailPassword'];
		$mail->SetFrom($config['mailUserName'], 'BBTOURNAMENTS');
		$mail->Subject    = $subject;

		$mail_template = file_get_contents('https://bbtournaments.es/mail/mail_template.html'); 
    	$bodyExtended = str_replace('%Content%', $body, $mail_template);

		$mail->MsgHTML($bodyExtended);
        $addresses = explode(",", $to);
		foreach ($addresses as $address){
			$mail->AddAddress($address);
		}
        
		if(!$mail->Send()) {
			return $mail->ErrorInfo;
		} else {
		  return TRUE;
		}
    }
?>
