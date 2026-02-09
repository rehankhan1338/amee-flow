<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Signin extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error'); 
		$this->data['title']='Login'; 
		$this->load->model('Backend/Accounts_mdl');
		$this->load->model('Users_mdl');
		$this->load->model('Forgot_password_mdl');
 	}
	
	public function index(){
		// $cookie_prefix=$this->config->item('cookie_prefix');
		// if(isset($_COOKIE[$cookie_prefix.'light_user_access_sts']) && $_COOKIE[$cookie_prefix.'light_user_access_sts']!=''){                  
		// 	$this->Users_mdl->chkLightAccessPermission($_COOKIE[$cookie_prefix.'light_user_access_sts']);
		// }else{ 
		// 	$this->data['activeAccountDataArr'] = $this->Accounts_mdl->activeAccountDataArr();		 
		// 	$this->load->view('Frontend/signin/view',$this->data);
		// }

		$this->data['activeAccountDataArr'] = $this->Accounts_mdl->activeAccountDataArr();		 
		$this->load->view('Frontend/signin/view',$this->data);
	}
	
	public function checkLogin(){
		echo $this->Users_mdl->checkLogin(); 
	}
	public function profile(){
		$this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));		
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
		$this->data['title']='Profile'; 
		$this->data['pageTitle'] = 'Profile';
        $this->data['pageSubTitle'] = '';
		// echo '<pre>';print_r($this->data['sessionDetailsArr']);die;
		$this->load->view('Frontend/includes/header',$this->data);		 
		$this->load->view('Frontend/profile/manage',$this->data);
		$this->load->view('Backend/includes/footer',$this->data);
	}
 
	public function updateUserProfile(){
		echo $this->Users_mdl->updateUserProfile(); 
	}
	public function logout(){
		session_destroy();
		redirect(base_url()."signin");
	}

	public function fpRandomString($length = 5) {
		$characters = '123456789abdefghnqrstuABCDEFGHIJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function forgot_password(){
		$fpFor = $this->uri->segment(2);
		$this->data['fpFor'] = $fpFor;
		$this->data['title']='Forgot Password';
		$this->data['captcha_text']=$this->fpRandomString();
		$this->load->view('Frontend/signin/forgot_password',$this->data);	
	}

	public function checkForgotPassword(){
		echo $this->Forgot_password_mdl->checkForgotPassword();
	}
		
	public function recover_password(){		
	 
		$current_date = time();
		$fpFor = $this->uri->segment(2);
		$this->data['fpFor'] = $fpFor;
		$encryptId = $this->uri->segment(3);
		$this->data['encryptId'] = $encryptId;
		$sha_forgot = $this->uri->segment(4);

		if($fpFor=='user'){		 
			$this->db->where('uaeId', $encryptId);
			$this->db->where('tempForget', $sha_forgot);
			$query = $this->db->get('users_access');
		}else{
			$this->db->where('uaencryptId', $encryptId);
			$this->db->where('tempForget', $sha_forgot);
			$query = $this->db->get('university_admins');
		}
		$num = $query->num_rows();
		if($num==0){	
			$this->session->set_flashdata('error', str_msg21);
			redirect(base_url()."forgot-password/".$fpFor);
		}else{
		
			$row = $query->row();
			if($current_date>$row->expLinkTime){				
				$this->session->set_flashdata('error', str_msg22);
				redirect(base_url()."forgot-password/".$fpFor);			
			}else{
				 
				$this->data['title']='Forgot Password';
				$this->load->view('Frontend/signin/recover_password',$this->data);
			
			}
			
		}
	}

	public function checkRecoverPassword(){
		echo $this->Forgot_password_mdl->recover_password();
	}
	
	
	
	
	/*public function check_login(){
	$this->Login_details_mdl->login();
	}
	public function verify(){
		$last = $this->uri->total_segments();
		$confirmation_token = $this->uri->segment($last);
		
		$this->Login_details_mdl->verify_user($confirmation_token);
	}
	
	public function facebook_check_login(){
		$this->Login_details_mdl->facebook_check_login();
	}
	
	
	public function profile(){
		echo '<pre>';
		print_r($_SESSION);	
		echo 'Login Successfully.';
	}*/
	 
} 