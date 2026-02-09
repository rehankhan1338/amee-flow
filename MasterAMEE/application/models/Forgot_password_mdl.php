<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password_mdl extends CI_Model {
	
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
	
	public function forgot_password(){
		$email = trim($this->input->post('username'));
 		$this->db->where('email', $email); 
		$query = $this->db->get('departments');
		$num = $query->num_rows();
 		if($num==1){
			$row = $query->row();
			if($row->is_delete==0){					
				return "Oops, your account has been deleted, so you aren't able to reset password, please contact to support.";					
			}else{
				$name = $row->first_name; 
				$rand = rand(100000, 999999);
				$unique = sha1($rand);
				$expire_temp_forget_link=time()+3600;
				$this->db->where('email', $email); 
				$this->db->update('departments',array('temp_forget'=>$unique,'expire_temp_forget_link'=>$expire_temp_forget_link));
				$recover_link = base_url().'recover/password/'.$row->id.'/'.$unique; 
				
				$this->db->select('*');
				$this->db->where('purpose', 'Forgot Password Department');
				$query1 = $this->db->get('email_templates');
				$fetch_email_templates = $query1->row();
				$subject = $fetch_email_templates->subject;
				$message = $fetch_email_templates->message;
				$status_email = $fetch_email_templates->status;
				$product_name = $this->config->item('product_name');
				if($status_email==1){
					$message = str_replace('{name}',$name,$message);
					$message = str_replace('{link}',$recover_link,$message);
					$message = str_replace('{product_name}',$product_name,$message);
					send_mail($email,$message,$name,'info',$subject);
					return 'success'; 
				}
			}
		}else{
			return str_msg18;
		}
	}
	
	public function recover_password($encrpted_id,$sha_forgot){
		$this->db->where('id', $encrpted_id);
		$this->db->where('temp_forget', $sha_forgot);
		$query = $this->db->get('departments');
		$num = $query->num_rows();
 		if($num>0){	
			$row = $query->row(); 
			$password = $this->input->post('confirm_password');
 			$data = array("password"=>md5($password), "password_view"=>$password, "temp_forget"=>'', "expire_temp_forget_link"=>'');
			$this->db->where('id',$row->id);
			$this->db->update('departments', $data);
			$this->session->set_flashdata('success', str_msg20); 
			redirect(base_url());
		}else{
			$this->session->set_flashdata('error', str_msg21);
			redirect(base_url()."forgot_password");
		}
	}
	
	
	function forgot_password_old(){
		$email = $this->input->post('username');
		
		$this->db->where('email', $email); 
		$query = $this->db->get('departments');
		$num = $query->num_rows();
		
		if($num==1){
			$row = $query->row();
			$name = $row->first_name.' '.$row->last_name; 
			
			$rand = rand(100000, 999999);
            $unique = sha1($rand);
            $this->db->where('email', $email); 
			$this->db->update('departments',array('temp_forget'=>$unique));
			$recover_link = base_url().'home/recover_password/'.$unique; 
			
			$this->db->select('*');
			$this->db->where('purpose', 'Forgot Password Department');
			$query1 = $this->db->get('email_templates');
			$fetch_email_templates = $query1->row();
			$subject = $fetch_email_templates->subject;
			$message = $fetch_email_templates->message;
			$status_email = $fetch_email_templates->status;
			
			if($status_email==1){
   				$message = str_replace('{name}',$name,$message);
				$message = str_replace('{link}',$recover_link,$message); 
				send_mail($email,$message,$name,'info',$subject);
				$this->session->set_flashdata('success', str_msg19); 
			}
		}else{
			$this->session->set_flashdata('error', str_msg18); 
		}
	}
	
	
	function recover_password_old($sha_forgot){
		$this->db->where('temp_forget', $sha_forgot);
		$query = $this->db->get('departments');
		$num = $query->num_rows();

		if($num>0){	
			$row = $query->row();
			$id = $row->id;
			$password = $this->input->post('confirm_password');
			
			$data = array("password"=>md5($password), "password_view"=>$password, "temp_forget"=>'');
			$this->db->where('id',$row->id);
			$this->db->update('departments', $data);
			$this->session->set_flashdata('success', str_msg20); 
			redirect(base_url().'home');
		}else{
			$this->session->set_flashdata('error', str_msg21);
			redirect(base_url()."home/forgot_password");
		}
	}
	
	
	
		
	
	
}	