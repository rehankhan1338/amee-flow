<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 if( !function_exists('send_mail') ) {
	 
	function send_mail($to,$message,$title,$status,$subject) {
	
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
		
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
		//$mail->AddEmbeddedImage(base_url().'assets/Frontend/images/logo.png', 'logo_2u');
		
		if(isset($to) && $to=='all_users'){
			$CI->db->select('email, first_name');
			$query_reg = $CI->db->get_where('registration', array('profile_status'=>'0', 'is_deleted'=>'0'));
			//$query_reg = $CI->db->get_where('registration', array('email'=>'tns.ankit@gmail.com'));			
			$num = $query_reg->num_rows();
			if($num>0){
				$res = $query_reg->result();
				foreach($res as $user){
					$mail->AddAddress($user->email, $title);
				}
			}
		}else{
			$mail->AddAddress($to, $title);
		}
		/*if($status=='equiry_mail'){
			$mail->AddCC('tns.chanda@gmail.com');
		}*/
		
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
		
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
		//$mail->AddEmbeddedImage(base_url().'assets/Frontend/images/logo.png', 'logo_2u');
		
		if(isset($to) && $to!=''){
			$to_arr = explode(',',$to);
			foreach($to_arr as $em){
				$email_name_arr = explode('||',$em);
				$send_email = trim($email_name_arr[0]);
				$send_name = $email_name_arr[1];
				$mail->AddAddress($send_email, $send_name);
			}
		}else{
        	$mail->AddAddress($to, $title);
		}
		
		/*if($status=='equiry_mail'){
			$mail->AddCC('tns.chanda@gmail.com');
		}*/
		
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