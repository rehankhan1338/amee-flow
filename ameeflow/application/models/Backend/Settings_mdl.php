<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_mdl extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * @access	public
	 */
	 
	public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
	}
	 	
	public function configuration_details(){		
		 $query = $this->db->get('configuration');
		 return $query->row();		
	} 
	
	public function update_configuration(){
		
		$txt_title = trim($this->input->post('txt_title'));
		$email = trim($this->input->post('txt_email'));
		$phone_no = trim($this->input->post('txt_phone_no'));
		$logo_img = trim($this->input->post('logo_img'));
		
		$smtp_host = trim($this->input->post('smtp_host'));
		$smtp_port = trim($this->input->post('smtp_port')); 
		$smtp_username = trim($this->input->post('smtp_username')); 
		$smtp_password = trim($this->input->post('smtp_password'));
		$is_smtp = trim($this->input->post('is_smtp')); 
		
		$social_facebook = trim($this->input->post('social_facebook'));
		$social_twitter = trim($this->input->post('social_twitter')); 
		$social_google_plus = trim($this->input->post('social_google_plus')); 
		$social_pinterest = trim($this->input->post('social_pinterest'));
		$social_linkedin = trim($this->input->post('social_linkedin'));
		$social_youtube = trim($this->input->post('social_youtube')); 
		$social_instagram = trim($this->input->post('social_instagram')); 
		
		$mail_title = trim($this->input->post('mail_title'));
		$mail_from_email_address = trim($this->input->post('mail_from_email_address'));		
				
		if(isset($_FILES['photo']['name']) && $_FILES['photo']['name']!=''){
			
			if($_FILES['photo']['error']==0){
			
				$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
				$photo=time().'.'.$ext;
				
				$config['file_name'] =$photo;
				$config['upload_path'] = './assets/upload/logo/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$this->load->library('upload');
				$this->upload->initialize($config);
				$this->upload->do_upload('photo');
				
				$errors = $this->upload->display_errors('<span>', '</span>');
				if(isset($errors) && $errors!=''){
					 $this->session->set_flashdata('error', $errors);
					 $this->session->set_flashdata('success', ''); 
				}else{
				
					$data=array("logo"=>$photo,"title"=>$txt_title,"email"=>$email,"phone_no"=>$phone_no,"smtp_host"=>$smtp_host,"smtp_port"=>$smtp_port,"smtp_username"=>$smtp_username,"smtp_password"=>$smtp_password,"is_smtp"=>$is_smtp,"mail_title"=>$mail_title,"mail_from_email_address"=>$mail_from_email_address,"social_facebook"=>$social_facebook,"social_twitter"=>$social_twitter,"social_google_plus"=>$social_google_plus,"social_pinterest"=>$social_pinterest,"social_linkedin"=>$social_linkedin,"social_youtube"=>$social_youtube,"social_instagram"=>$social_instagram);
					
					$this->db->where('id','1');
					$this->db->update('configuration',$data);
					
					if(isset($logo_img) && $logo_img!=''){	 			
						// Unlink
						$path = './assets/upload/logo/';
						$path1 = './assets/upload/logo/thumbnails/';
						unlink( $path . $logo_img ); 		
						unlink( $path1 . $logo_img ); 		
					}
					
					$this->session->set_flashdata('success', 'System configuration has been updated Successfully!');
					
				} 
			}
			
		}else{
			
			$data=array("title"=>$txt_title,"email"=>$email,"phone_no"=>$phone_no,"smtp_host"=>$smtp_host,"smtp_port"=>$smtp_port,"smtp_username"=>$smtp_username,"smtp_password"=>$smtp_password,"is_smtp"=>$is_smtp,"mail_title"=>$mail_title,"mail_from_email_address"=>$mail_from_email_address,"social_facebook"=>$social_facebook,"social_twitter"=>$social_twitter,"social_google_plus"=>$social_google_plus,"social_pinterest"=>$social_pinterest,"social_linkedin"=>$social_linkedin,"social_youtube"=>$social_youtube,"social_instagram"=>$social_instagram);
			
			$this->db->where('id','1');
			$this->db->update('configuration',$data);
			$this->session->set_flashdata('success', 'System configuration has been updated Successfully!');
		
		}	
		
  	}

	public function universityEmailsListbyuId($uniAdminId){		
		$this->db->where('uniAdminId',$uniAdminId);
		$this->db->order_by("id","desc");
		$query = $this->db->get('email_templates');
		return $query->result();		
	}

	public function universityEmailsList($universityId){		
		$this->db->where('universityId',$universityId);
		$this->db->order_by("id","desc");
		$query = $this->db->get('email_templates');
		return $query->result();		
	}
	
	public function email_templates_list(){	
		$this->db->where('defaultUniSts', 0);
		 $this->db->order_by("id","desc");
		 $query = $this->db->get('email_templates');
		 return $query->result();		
	}
	
	public function admin_email_templates_list(){	
		$this->db->where('universityId', 0);
		 $this->db->order_by("id","desc");
		 $query = $this->db->get('email_templates');
		 return $query->result();		
	}
	
	public function email_templates_full_details($id){		 
		 $query = $this->db->get_where('email_templates',array('id'=>$id));
		 return $query->row();		
	}

	public function emailDetailsArr($id){		 
		$query = $this->db->get_where('email_templates',array('id'=>$id));
		return $query->row_array();		
   }
	
	public function edit_email_templates($id){		
		$Subject = trim($this->input->post('Subject'));
		$message = trim($this->input->post('message')); 		
		$data=array("Subject"=>$Subject,"message"=>$message);		
		$this->db->where('id',$id);
		$this->db->update('email_templates',$data);
		$this->session->set_flashdata('success', 'Email content has been updated successfully!');
  	}

	public function updateEmailContent(){
		$id = trim($this->input->post('emailId'));
		$subject = trim($this->input->post('eSubject'));
        $message = $this->input->post('eMsg');
		$this->db->where('id', $id);
		$this->db->update('email_templates', array('subject'=>$subject, 'message'=>$message));
		$this->session->set_flashdata('success', 'Email content has been updated successfully!');
		return 'success||'.base_url().$this->config->item('system_directory_name').'settings/emails';
	}
	
	public function paypal_details(){		 
		 $query = $this->db->get('paypal_settings');
		 return $query->result();		
	}  
	
	public function paypal_full_details($id){		 
		 $this->db->where('id',$id);
		 $query = $this->db->get('paypal_settings');
		 return $query->row();		
	}  
	
	public function manage_paypal_setting($id){
		
		$showcase_paypal_id = trim($this->input->post('showcase_paypal_id'));
		$showcase_status = trim($this->input->post('showcase_status'));
		$showcase_amount = trim($this->input->post('showcase_amount'));
		$showcase_item_name = trim($this->input->post('showcase_item_name'));
		$showcase_currency_code = trim($this->input->post('showcase_currency_code'));
		$showcase_duration = trim($this->input->post('showcase_duration'));
		
		$data=array(
			"paypal_id"=>$showcase_paypal_id,
			"status"=>$showcase_status,
			"amount"=>$showcase_amount,
			"item_name"=>$showcase_item_name,
			"currency_code"=>$showcase_currency_code,
			"duration"=>$showcase_duration);
		
		$this->db->where('id', $id);
		$this->db->update('paypal_settings',$data);
		
		$this->session->set_flashdata('success', 'Paypal setting has been updated successfully!');
 		
	} 
	
}
		