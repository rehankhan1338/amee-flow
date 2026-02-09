<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password_admin_mdl extends CI_Model {
	
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
	
	function recover_password($md5_id){
		
		$this->db->select('*');
		$this->db->where('email_md5', $md5_id);
		$query = $this->db->get('admin_login');
		$num = $query->num_rows();
	
		if($num>0){
  				
			$row = $query->row();
			$pass_update_accpet_time=$row->pass_update_accpet_time;
			$current_time=time();
			
			if($pass_update_accpet_time>=$current_time){
			
				$password = $this->input->post('confirm_password');
				$this->db->where('id',$row->id);
				$this->db->update('admin_login',array('password'=>md5($password),'password_show'=>$password));
				$this->session->set_flashdata('success', str_msg20); 
				
			}else{
				
				$this->session->set_flashdata('error', str_msg22);
				redirect(base_url().$this->config->item('admin_directory_name')."forgot_password");	
			}
		
			 
		}else{
		
			$this->session->set_flashdata('error', str_msg21);
			redirect(base_url().$this->config->item('admin_directory_name')."forgot_password");
		}
	}
	
	function forgot_password(){
	
		$email = $this->input->post('username');
		
		$this->db->select('*');
		$this->db->where('email', $email); 
		$query = $this->db->get('admin_login');
		$num = $query->num_rows();
		
		if($num>0){
			
 			$row = $query->row();
			$reset_time=time();
			$pass_update_accpet_time=$reset_time+(60*60*24);
			
			$this->db->where('email',$row->email);
			$this->db->update('admin_login',array('email_md5'=>md5($email),'pass_update_accpet_time'=>$pass_update_accpet_time));			
			
			$recover_link = base_url().$this->config->item('admin_directory_name').'recover_password/'.$row->email_md5; 
			$name = $row->name; 
			
			$this->db->select('*');
			$this->db->where('purpose', 'Forgot Password Admin');
			$query1 = $this->db->get('email_templates');
			$fetch_email_templates = $query1->row();
			$subject = $fetch_email_templates->subject;
			$message = $fetch_email_templates->message;
			$status_email = $fetch_email_templates->status;
			
			if($status_email==1){			
   				$message = str_replace('{name}',$name,$message);				
				$message = str_replace('{product_name}',$this->config->item('product_name'),$message);
				$message = str_replace('{link}',$recover_link,$message);
				send_mail($email,$message,$name,'info',$subject);
				$this->session->set_flashdata('success', str_msg19); 
			}
			
		}else{
			
			$this->session->set_flashdata('error', str_msg18); 
			
		}
	}
	
}	