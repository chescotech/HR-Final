<?php

class email {

   	function send_mail($email,$message,$subject)
	{						
		require_once('mailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 1;                     
		$mail->SMTPAuth   = true;                  
	
	    $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.office365.com';
        $mail->Port = '587';
	                
	        
		$mail->AddAddress($email);
		$mail->Username="info@fabank.co.zm";  
		$mail->Password="Fabonline@2021";
		$mail->SetFrom('info@fabank.co.zm',$subject);
		//$mail->AddReplyTo('info@fabank.co.zm',$subject);
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
                 
	} 
        
        
        function sendEmailWithAttachment($email,$message,$subject,$payslip)
	{						

		require_once('mailer/class.phpmailer.php');
		$mail = new PHPMailer();
		//$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;          
		$mail->IsHTML(true);
        $mail->AddAttachment($payslip);
		$mail->SMTPSecure = "ssl";                 
		$mail->Host       = "smtp.gmail.com";      
		$mail->Port       = 587;             
		$mail->AddAddress($email);
		$mail->Username="chescotechmail@gmail.com";  
		$mail->Password="mtnzvxqgjzxrqpyb";
		$mail->SetFrom('chescotechpayroll@gmail.com',$subject);
		$mail->AddReplyTo('chescotechpayroll@gmail.com',$subject);
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
                 
	}

}
?>

