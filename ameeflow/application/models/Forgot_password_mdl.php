<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password_mdl extends CI_Model {
	
	/**
	* Constructor
	*
	* @access public
	*/	 
	public function __construct(){
		parent::__construct();
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
	}
	
	public function checkForgotPassword(){
		
		if(isset($_POST['capchta_word']) && $_POST['capchta_word']!='' && isset($_POST['enter_captcha_txt']) && $_POST['enter_captcha_txt']!='' && $_POST['capchta_word']==$_POST['enter_captcha_txt']){
		
			$fpFor = trim($this->input->post('fpFor'));
			$email = trim($this->input->post('email'));

			if($fpFor=='user'){
				$this->db->where('auEmailId', $email); 
				$query = $this->db->get('users_access');
				$row = $query->row();
				$isDeleted = $row->auIsDeleted;
			}else{
				$this->db->where('email', $email); 
				$query = $this->db->get('university_admins');
				$row = $query->row();
				$isDeleted = $row->isDeleted;
			}
			
			$num = $query->num_rows();
			if($num==1){				
				if($isDeleted==1){					
					return "error||Oops, your account has been deleted, so you aren't able to reset password, please contact to support.";					
				}else{					
					
					$unique = $this->generateRandomString(10);
					$expLinkTime=time()+(24*60*60); 

					if($fpFor=='user'){
						$name = $row->auName;
						$eId = $row->uaeId;
						$this->db->where('auEmailId', $email); 
						$this->db->update('users_access',array('tempForget'=>$unique,'expLinkTime'=>$expLinkTime)); 
					}else{
						$name = $row->fullName; 
						$eId = $row->uaencryptId;
						$this->db->where('email', $email); 
						$this->db->update('university_admins',array('tempForget'=>$unique,'expLinkTime'=>$expLinkTime));
					}					
					$recover_link = base_url().'recover-password/'.$fpFor.'/'.$eId.'/'.$unique; 
					
					$this->db->select('*');
					$this->db->where('id', 23);
					$query1 = $this->db->get('email_templates');
					$fetch_email_templates = $query1->row();
					$subject = $fetch_email_templates->subject;
					$message = $fetch_email_templates->message;
					$status_email = $fetch_email_templates->status;
					
					if($status_email==1){
						$product_name = $this->config->item('product_name');
						$message = str_replace('{name}',$name,$message);
						$message = str_replace('{link}',$recover_link,$message);
						$message = str_replace('{product_name}',$product_name,$message);
						send_mail($email,$message,$name,'info',$subject);
						return 'success||'.str_msg19; 
					}
				}
			}else{
				return 'error||'.str_msg18;
			}
			
		}else{
			return 'error||Sorry, The captcha field does not match the Capchta Word field.';
		}
	}	
	
	public function recover_password(){
		$fpFor = trim($this->input->post('fpFor'));
		$encryptId = trim($this->input->post('encryptId'));

		if($fpFor=='user'){
			$this->db->where('uaeId', $encryptId);
			$query = $this->db->get('users_access');
		}else{
			$this->db->where('uaencryptId', $encryptId); 
			$query = $this->db->get('university_admins');
		}
		$num = $query->num_rows();
 		if($num>0){	
			$row = $query->row(); 
			$password = $this->input->post('confirm_password');
			$enPass = base64_encode($password);
			if($fpFor=='user'){		
				$userId = $row->auserId;		
				$this->db->where('uaeId', $encryptId);
				$this->db->update('users_access', array("auPassword"=>md5($password), "auRamdomId"=>$enPass, "tempForget"=>'', "expLinkTime"=>''));

				$this->db->where('userId', $userId);
				$this->db->update('users', array("password"=>md5($password), "randomId"=>$enPass));
			}else{
				$this->db->where('uaencryptId', $encryptId); 
				$this->db->update('university_admins', array("password"=>md5($password), "randomId"=>$enPass, "tempForget"=>'', "expLinkTime"=>''));
			}
			
			$this->session->set_flashdata('success', str_msg20); 
			return 'success||'.base_url().'signin'; 
		}else{
			return 'error||'.str_msg21;
		}
	}
	
	public function generateRandomString($length = 5) {
		$characters = '123456789abdefghnqrstuABCDEFGHIJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}		
	
}	