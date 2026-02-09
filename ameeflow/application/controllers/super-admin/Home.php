<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 		
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_login']=$this->session->flashdata('error');
		$this->data['error_msg']=$this->session->flashdata('error');
		//$this->data['configuration_details'] = $this->Settings_mdl->configuration_details();  		  
 	} 
	
	// public function get_wards_by_zoneId(){
	// 	if(isset($_GET['zoneId']) && $_GET['zoneId']!=''){
	// 		$this->data['selectedWardId']=$_GET['selectedWardId'];
	// 		$this->data['wards_data']=$this->Setup_mdl->get_wards_by_zoneId($_GET['zoneId']);
	// 		$this->load->view('Backend/includes/ajaxWards',$this->data);
	// 	}
	// }
	
 	public function index(){	
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');		
 		if ($this->form_validation->run() == FALSE){		
			$this->data['btnText']='Sign in to start your session';
			$this->data['accTypeSts']=0;
			$this->data['accType']='Super Admin';
			$this->data['frmAction']=$this->config->item('ajax_base_url').$this->config->item('admin_directory_name').'home/check_admin_login';
			$this->data['title']=$this->data['accType'].' - '.$this->config->item('product_name');
			$this->load->view('Backend/includes/login_header',$this->data);
			$this->load->view('Backend/login/view',$this->data);
			$this->load->view('Backend/includes/login_footer',$this->data);		
		}else{		
			$this->Login_mdl->check_admin_login();
		}
   		
	}
	
	public function check_admin_login(){
		$this->Login_mdl->check_admin_login();
	}
	
	public function logout(){		
		$this->session->sess_destroy();
		redirect(base_url().$this->config->item('admin_directory_name'));
	}
	
	public function forgot_password(){	
		$this->form_validation->set_rules('username','Email','required|valid_email');		
		if ($this->form_validation->run() == FALSE){	
			$this->data['title']=''.$this->config->item('product_name');
			$this->data['page_title']='<span>Forgot</span> Password';
			$this->load->view('Backend/includes/login_header',$this->data);
			$this->load->view('Backend/forgot_password/view',$this->data);	
			$this->load->view('Backend/includes/login_footer',$this->data);	
		}else{		
			$this->Forgot_password_admin_mdl->forgot_password();
			redirect(base_url().$this->config->item('admin_directory_name')."forgot_password");
		}
	}
	
	public function recover_password(){	
		$md5_id = $this->uri->segment(3);		
		if(isset($md5_id) && $md5_id!=''){
			$this->form_validation->set_rules('new_password', 'Password', 'required'); 		
			if($this->form_validation->run() === FALSE){			
				$this->data['title']=$this->config->item('product_name');
				$this->data['page_title']='<span>Create</span> Password';
				$this->load->view('Backend/includes/login_header',$this->data);
				$this->load->view('Backend/forgot_password/change_password',$this->data);
				$this->load->view('Backend/includes/login_footer',$this->data);		
			}else{		
				$this->Forgot_password_admin_mdl->recover_password($md5_id);
				redirect(base_url().$this->config->item('admin_directory_name'));
			}
		}else{
			$this->session->set_flashdata('error', 'Oops, your link has been expired.');
			redirect(base_url().$this->config->item('admin_directory_name')."forgot_password");
		}
	}
	 
	public function profile(){
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		
		$this->form_validation->set_rules('user_name','Username','required'); 
		
		if ($this->form_validation->run() == FALSE){
			
			$this->data['title']='Administrator Panel';
			$this->data['active_class']='profile_menu';
			$this->data['page_title']='Profile';
			
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/profile/edit_profile',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
			
			$this->Login_mdl->update_profile();
			redirect(base_url().$this->config->item('admin_directory_name')."profile");
		}	
 		 
 	}
	
	public function get_pass_fields(){		
	 	$this->load->view('Backend/profile/get_pass_fields');		
	}
	
	
	public function manage_email_templates(){

		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
			
		$this->data['title']='Settings | Administrator Panel';
		$this->data['active_class']='system_setting';
		$this->data['page_title']='Email Templates';
		$this->data['email_templates_details']=$this->Settings_mdl->admin_email_templates_list();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/settings/email_templates/viewall',$this->data);
		$this->load->view('Backend/includes/footer');
   		 
	 }
	 
	  public function email_templates_message(){

		$this->data['email_templates_details'] = $this->Settings_mdl->email_templates_full_details($_GET['id']);
		$this->load->view('Backend/includes/fancybox_header',$this->data);
 		$this->load->view('Backend/settings/email_templates/view_message',$this->data);
		$this->load->view('Backend/includes/fancybox_footer',$this->data);
		 
	}
	
	 public function edit_email_templates(){
	 		 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;		
		
		if(isset($_GET['id']) && $_GET['id']!=''){
		
			$this->form_validation->set_rules('Subject','Subject','required'); 
			
			if($this->form_validation->run() == FALSE){
				$this->data['title']='Settings | Administrator Panel';
				$this->data['active_class']='system_setting';
				$this->data['email_templates_details']=$this->Settings_mdl->email_templates_full_details($_GET['id']);				
				$this->data['page_title']='Email Templates : : '.$this->data['email_templates_details']->purpose.' : : Edit';			
				$this->load->view('Backend/includes/header',$this->data);
				$this->load->view('Backend/settings/email_templates/edit',$this->data);
				$this->load->view('Backend/includes/footer'); 		
			}else{
				$this->Settings_mdl->edit_email_templates($_GET['id']);
				redirect(base_url().$this->config->item('admin_directory_name')."setting/email_templates/manage");
			}		
									
		}else{			
			$this->session->set_flashdata('error', 'Sorry, please select templates first!');
			redirect(base_url().$this->config->item('admin_directory_name')."setting/email_templates/manage");
		}
 		 
	 }
	 
	 public function manage_configuration(){
		 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;				
			
		$this->form_validation->set_rules('txt_title','Title','required');
		$this->form_validation->set_rules('is_smtp','is_smtp','required'); 
		
		if ($this->form_validation->run() == FALSE){
		
			$this->data['title']='Settings | Administrator Panel';
			$this->data['active_class']='system_setting';
			$this->data['page_title']='Configuration : : Manage';
			$this->data['configuration_details']=$this->Settings_mdl->configuration_details();
			
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/settings/configuration/manage',$this->data);
			$this->load->view('Backend/includes/footer');	
		
		}else{
		
			$this->Settings_mdl->update_configuration();
			redirect(base_url().$this->config->item('admin_directory_name')."setting/configuration/manage");
		}		 
 		 
	 }	
	 
	 public function notice_board(){
 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		
		$this->form_validation->set_rules('h_item_cnt','h_item_cnt','required'); 
		
		if ($this->form_validation->run() == FALSE){
			
			$this->data['title']='Notice Board : : Administrator Panel';
			$this->data['active_class']='system_setting';
			$this->data['page_title']='Notice Board';
			$this->data['todays_notice_data']=$this->Login_mdl->admin_todays_notice();
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/profile/notice_board',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
			
			$this->Login_mdl->update_notice_board();
			redirect(base_url().$this->config->item('admin_directory_name')."notice-board");
		}	
 		 
 	} 
	   
}