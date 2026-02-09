<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 if( !function_exists('send_mail') ) {
	 
	function send_mail($to,$message,$title,$status,$subject, $cc=0) {
 		//$this->load->library('My_PHPMailer');
		include_once(APPPATH.'libraries/PHPMailer/class.smtp.php');  
		include_once(APPPATH.'libraries/PHPMailer/class.phpmailer.php');
		$CI = & get_instance();
 		$CI->db->where('id', '1');
		$query = $CI->db->get('configuration');
		$configuration_details = $query->row();
 		$mail_title=$configuration_details->mail_title;
		$is_smtp=$configuration_details->is_smtp;
 		$from_title = $mail_title;
		$mail = new PHPMailer();
 		if($is_smtp==1){
 			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
 			$mail->Host = $configuration_details->smtp_host;      // setting GMail as our SMTP server
			$mail->Port =  $configuration_details->smtp_port;                   // SMTP port to connect to GMail
			$mail->Username = $configuration_details->smtp_username;  // user email address
			$mail->Password = $configuration_details->smtp_password;            // password in GMail
			$mail->SetFrom($configuration_details->smtp_username, $from_title);  //Who is sending the email
 		}else{
 			$mail->SetFrom($configuration_details->mail_from_email_address, $from_title);  //Who is sending the email
 		}
 		//$mail->AddReplyTo("info@techninjasolutions.com","Firstname Lastname");  //email address that receives the response
		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';  
		$mail->Subject = $subject;
		// $mail->addEmbeddedImage('./assets/frontend/img/logo.png', 'logo_cid');
		// $msgContent = $configuration_details->templateHeader.$message.$configuration_details->templateFooter;
		$msgContent = $message;
		$mail->Body = $msgContent;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
		//$mail->AddEmbeddedImage(base_url().'assets/Frontend/images/logo.png', 'logo_2u');
 		$to_arr = explode(',',$to);
		if(count($to_arr)>0){
			foreach($to_arr as $email_details){
				$mail->AddAddress($email_details, $title);
			}
		}else{
			$mail->AddAddress($to, $title);
		}
		if($cc==1){
			$ccEmailArr = explode('||',$CI->config->item('admin_email_sent_to_cc'));
			$ccEmail = $ccEmailArr[0];
			$ccName = $ccEmailArr[1];
			//$mail->AddCC($ccEmail, $ccName);
		}
		//$mail->AddAttachment("images/phpmailer.gif");      // some attached files
		//$mail->AddAttachment("images/phpmailer_mini.gif"); // as many as you want
		if(!$mail->Send()) {
			$data["message"] = "Error: " . $mail->ErrorInfo;
			echo $mail->ErrorInfo;
			//echo 'no';
		} else {
			$data["message"] = "Message sent correctly!";
			//echo 'yes';
		} 
		
	}
	
 }
 
 if( !function_exists('send_mail_to_multiple') ) {
	 
	function send_mail_to_multiple($to,$message,$title,$status,$subject) {
	
		//$this->load->library('My_PHPMailer');
		include_once(APPPATH.'libraries/PHPMailer/class.smtp.php');  
		include_once(APPPATH.'libraries/PHPMailer/class.phpmailer.php');
		$CI = & get_instance();
 		$CI->db->where('id', '1');
		$query = $CI->db->get('configuration');
		$configuration_details = $query->row();
	
		$mail_title=$configuration_details->mail_title;
		$is_smtp=$configuration_details->is_smtp;
			
		$from_title = $mail_title;
		$mail = new PHPMailer();
		
		if($is_smtp==1){
		
			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
			
			$mail->Host = $configuration_details->smtp_host;      // setting GMail as our SMTP server
			$mail->Port =  $configuration_details->smtp_port;                   // SMTP port to connect to GMail
			$mail->Username = $configuration_details->smtp_username;  // user email address
			$mail->Password = $configuration_details->smtp_password;            // password in GMail
			$mail->SetFrom($configuration_details->smtp_username, $from_title);  //Who is sending the email
		
		}else{
		
			$mail->SetFrom($configuration_details->mail_from_email_address, $from_title);  //Who is sending the email
			
		}
		
		//$mail->AddReplyTo("info@techninjasolutions.com","Firstname Lastname");  //email address that receives the response
		
		$mail->isHTML(true);  
		$mail->CharSet = 'UTF-8';
		$mail->Subject = $subject;
		$mail->addEmbeddedImage('./assets/frontend/web/images/new_logo.png', 'logo_cid');
		$msgContent = $configuration_details->templateHeader.$message.$configuration_details->templateFooter;
		$mail->Body = $msgContent;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
		//$mail->AddEmbeddedImage(base_url().'assets/Frontend/images/logo.png', 'logo_2u');
		
		if(isset($to) && $to!=''){
			$to_arr = explode(',',$to);
			foreach($to_arr as $em){
				$email_name_arr = explode('||',$em);
				$send_email = trim($email_name_arr[0]);
				if(isset($email_name_arr[1]) && $email_name_arr[1]!=''){
					$send_name = $email_name_arr[1];
				}else{
					$send_name = '';
				}
				$mail->AddAddress($send_email, $send_name);
			}
		}else{
        	$mail->AddAddress($to, $title);
		}
		 
		 
			//$ccEmailArr = explode('||',$CI->config->item('admin_email_sent_to_cc'));
			//$ccEmail = $ccEmailArr[0];
			//$ccName = $ccEmailArr[1];
			//$mail->AddCC($ccEmail, $ccName);
		 
		//$mail->AddAttachment("images/phpmailer.gif");      // some attached files
		//$mail->AddAttachment("images/phpmailer_mini.gif"); // as many as you want
		if(!$mail->Send()) {
			$data["message"] = "Error: " . $mail->ErrorInfo;
			echo $mail->ErrorInfo;die;
			//echo 'no';
		} else {
			$data["message"] = "Message sent correctly!";
			//echo 'yes';
		} 
		
	}
	
 }

 if( !function_exists('shareMail') ) {	 
	function shareMail($to,$message,$title,$imgPath,$subject) {
 		//$this->load->library('My_PHPMailer');
		include_once(APPPATH.'libraries/PHPMailer/class.smtp.php');  
		include_once(APPPATH.'libraries/PHPMailer/class.phpmailer.php');
		$CI = & get_instance();
 		$CI->db->where('id', '1');
		$query = $CI->db->get('configuration');
		$configuration_details = $query->row();
 		$mail_title=$configuration_details->mail_title;
		$is_smtp=$configuration_details->is_smtp;
 		$from_title = $mail_title;
		$mail = new PHPMailer();
 		if($is_smtp==1){
 			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
 			$mail->Host = $configuration_details->smtp_host;      // setting GMail as our SMTP server
			$mail->Port =  $configuration_details->smtp_port;                   // SMTP port to connect to GMail
			$mail->Username = $configuration_details->smtp_username;  // user email address
			$mail->Password = $configuration_details->smtp_password;            // password in GMail
			$mail->SetFrom($configuration_details->smtp_username, $from_title);  //Who is sending the email
 		}else{
 			$mail->SetFrom($configuration_details->mail_from_email_address, $from_title);  //Who is sending the email
 		}
		$mail->isHTML(true);  
		$mail->Subject = $subject;
		$mail->addEmbeddedImage($imgPath, 'logo_cid');
		$mail->Body = $message;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
 		$to_arr = explode(',',$to);
		if(count($to_arr)>0){
			foreach($to_arr as $email_details){
				if(isset($email_details) && $email_details!=''){
					$mail->AddAddress(trim($email_details), $title);
				}
			}
		}else{
			$mail->AddAddress($to, $title);
		}
		if(!$mail->Send()) {
			$data["message"] = "Error: " . $mail->ErrorInfo;
			echo $mail->ErrorInfo;die;
			//echo 'no';
		} else {
			$data["message"] = "Message sent correctly!";
			//echo 'yes';
		}		
	}	
 }










 if( !function_exists('chk_send_mail') ) {
	 
	function chk_send_mail($to,$message,$title,$status,$subject, $cc=0) {
 		//$this->load->library('My_PHPMailer');
		include_once(APPPATH.'libraries/PHPMailer/class.smtp.php');  
		include_once(APPPATH.'libraries/PHPMailer/class.phpmailer.php');
		$CI = & get_instance();
 		$CI->db->where('id', '1');
		$query = $CI->db->get('configuration_bk');
		$configuration_details = $query->row();
 		$mail_title=$configuration_details->mail_title;
		$is_smtp=$configuration_details->is_smtp;
 		$from_title = $mail_title;
		$mail = new PHPMailer();
 		if($is_smtp==1){
 			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
 			$mail->Host = $configuration_details->smtp_host;      // setting GMail as our SMTP server
			$mail->Port =  $configuration_details->smtp_port;                   // SMTP port to connect to GMail
			$mail->Username = $configuration_details->smtp_username;  // user email address
			$mail->Password = $configuration_details->smtp_password;            // password in GMail
			$mail->SetFrom($configuration_details->smtp_username, $from_title);  //Who is sending the email
 		}else{
 			$mail->SetFrom($configuration_details->mail_from_email_address, $from_title);  //Who is sending the email
 		}
 		//$mail->AddReplyTo("info@techninjasolutions.com","Firstname Lastname");  //email address that receives the response
		$mail->isHTML(true);  
		$mail->Subject = $subject;
		// $mail->addEmbeddedImage('./assets/frontend/img/logo.png', 'logo_cid');
		// $msgContent = $configuration_details->templateHeader.$message.$configuration_details->templateFooter;
		$msgContent = $message;
		$mail->Body = $msgContent;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
		//$mail->AddEmbeddedImage(base_url().'assets/Frontend/images/logo.png', 'logo_2u');
 		$to_arr = explode(',',$to);
		if(count($to_arr)>0){
			foreach($to_arr as $email_details){
				$mail->AddAddress($email_details, $title);
			}
		}else{
			$mail->AddAddress($to, $title);
		}
		if($cc==1){
			$ccEmailArr = explode('||',$CI->config->item('admin_email_sent_to_cc'));
			$ccEmail = $ccEmailArr[0];
			$ccName = $ccEmailArr[1];
			//$mail->AddCC($ccEmail, $ccName);
		}
		//$mail->AddAttachment("images/phpmailer.gif");      // some attached files
		//$mail->AddAttachment("images/phpmailer_mini.gif"); // as many as you want
		if(!$mail->Send()) {
			$data["message"] = "Error: " . $mail->ErrorInfo;
			echo $mail->ErrorInfo;
			//echo 'no';
		} else {
			$data["message"] = "Message sent correctly!";
			//echo 'yes';
		} 
		
	}
	
 }