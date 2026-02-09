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
		
		$smtp_host = trim($this->input->post('smtp_host'));
		$smtp_port = trim($this->input->post('smtp_port')); 
		$smtp_username = trim($this->input->post('smtp_username')); 
		$smtp_password = trim($this->input->post('smtp_password'));
		$is_smtp = trim($this->input->post('is_smtp')); 
		
		$social_facebook = trim($this->input->post('social_facebook'));
		$social_twitter = trim($this->input->post('social_twitter')); 
		$social_google_plus = trim($this->input->post('social_google_plus')); 
		$social_linkedin = trim($this->input->post('social_linkedin'));
		$social_youtube = trim($this->input->post('social_youtube')); 
		$social_instagram = trim($this->input->post('social_instagram')); 
		
		$mail_title = trim($this->input->post('mail_title'));
		$mail_from_email_address = trim($this->input->post('mail_from_email_address'));
		
		$data=array("title"=>$txt_title,"smtp_host"=>$smtp_host,"smtp_port"=>$smtp_port,"smtp_username"=>$smtp_username,"smtp_password"=>$smtp_password,"is_smtp"=>$is_smtp,"mail_title"=>$mail_title,"mail_from_email_address"=>$mail_from_email_address,"social_facebook"=>$social_facebook,"social_twitter"=>$social_twitter,"social_google_plus"=>$social_google_plus,"social_linkedin"=>$social_linkedin,"social_youtube"=>$social_youtube,"social_instagram"=>$social_instagram);
		
		$this->db->where('id','1');
		$this->db->update('configuration',$data);
		
		// Unlink
		$this->db->where('id','1');
		$query = $this->db->get('configuration');
		$result= $query->row();
		$logo_img = $result->logo;
		
		if(isset($_FILES['photo']) && $_FILES['photo']!=''){
			/*if(isset($_FILES['photo']['size']) && $_FILES['photo']['size']>='20500'){
				$this->session->set_flashdata('error', 'File size is too large(Uplode image size less than 20500)');
				redirect(base_url().'admin/logo');
			}*/
			$config['upload_path'] = './assets/backend/logo/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload');
			$files = $_FILES;
			$count = count($_FILES['photo']['name']);
			$_FILES['photo']['name'] = $files['photo']['name'];
			$_FILES['photo']['type'] = $files['photo']['type'];
			$_FILES['photo']['tmp_name'] = $files['photo']['tmp_name'];
			$_FILES['photo']['error'] = $files['photo']['error'];
			$_FILES['photo']['size'] = $files['photo']['size'];
			
			$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
			$fileName=time().'.'.$ext; 
			/*$fileName = time().'_'.str_replace(' ','_',trim($_FILES['photo']['name']));*/
			$images[] = $fileName;
			$config['file_name'] = $fileName;
			$this->upload->initialize($config); 
			if ($this->upload->do_upload('photo')) {
				$config1 = array(
					'source_image'      => './assets/backend/logo/'.$fileName,
					'new_image'         => './assets/backend/logo/thumbnails/'.$fileName,
					'maintain_ratio'    => true,
					'width'             => 250,
					'height'            => 150
					);
				//here is the second thumbnail, notice the call for the initialize() function again
				$this->load->library('image_lib',$config1);
				$this->image_lib->initialize($config1);
				$this->image_lib->resize();
				$data=''; 
				$data=array("logo"=>$fileName);
				$this->db->where('id','1');
 				$this->db->update('configuration',$data);
					 			
		 			// Unlink
				$path = './assets/backend/logo/';
				$path1 = './assets/backend/logo/thumbnails/';
				unlink( $path . $logo_img ); 		
				unlink( $path1 . $logo_img ); 		
			} 
		}
		
		$this->session->set_flashdata('success', 'Updated Successfully!');
  	}
	
	public function email_templates_list(){		
		$this->db->order_by("id","desc");
		$query = $this->db->get('email_templates');
		return $query->result();		
	}
	
	public function track_readiness_read_mores_data(){		
		$this->db->order_by("id","asc");
		$query = $this->db->get_where('popup_messages',array('page_name'=>'readiness'));
		return $query->result();		
	}
	
	public function track_readiness_read_mores_details($id){
		$query = $this->db->get_where('popup_messages',array('id'=>$id));
		return $query->row();		
	} 
	
	public function update_track_readiness_read_mores($id){
		$title = $this->input->post('txt_title');
		$description = $this->input->post('description');
		$status = $this->input->post('status');  		
		$data=array("title"=>$title,"description"=>$description,"status"=>$status);		
		$this->db->where('id',$id);
		$this->db->update('popup_messages',$data);
		$this->session->set_flashdata('success', 'Updated Successfully!');
	}
	
	public function email_templates_full_details($id){
		 
		 $query = $this->db->get_where('email_templates',array('id'=>$id));
		 return $query->row();
		
	}
	
	public function edit_email_templates($id){
		
		$Subject = trim($this->input->post('Subject'));
		$message = trim($this->input->post('message')); 
		
		$data=array("Subject"=>$Subject,"message"=>$message);
		
		$this->db->where('id',$id);
		$this->db->update('email_templates',$data);
		$this->session->set_flashdata('success', 'Updated Successfully!');
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
		
		$this->session->set_flashdata('success', 'Updated successfully!');
 		
	}
	
	 
	
}
		