<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct(); 
		$this->data['configuration_details'] = $this->Settings_mdl->configuration_details();  
		  
 	} 
	
 	public function index(){	
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		
 		if ($this->form_validation->run() == FALSE){		
			$this->data['success_msg']=$this->session->flashdata('success');
			$this->data['error_login']=$this->session->flashdata('error');
 			$this->data['title']='Administrator Panel';
			$this->load->view('Backend/login/view',$this->data);
		
		}else{		
			$this->Login_mdl->check_admin_login();
		}
   		
	}
	
	public function logout(){		
		$this->session->sess_destroy();
		redirect(base_url()."admin");			
	}
	
	public function forgot_password(){	
		$this->form_validation->set_rules('username','Email','required|valid_email');
		
		if ($this->form_validation->run() == FALSE){
		
			$this->data['success_msg']=$this->session->flashdata('success');
			$this->data['error_login']=$this->session->flashdata('error');
			$this->data['title']='Administrator Panel';
			$this->load->view('Backend/forgot_password/view',$this->data);		
		}else{		
			$this->Forgot_password_admin_mdl->forgot_password();
			redirect(base_url()."admin/forgot_password");
		}
	}
	
	public function recover_password(){	
		$last = $this->uri->total_segments();
		$md5_id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('new_password', 'Password', 'required'); 
		
		if($this->form_validation->run() === FALSE){			
			$this->data['success_msg']=$this->session->flashdata('success');
			$this->data['error_login']=$this->session->flashdata('error');
			$this->data['title']='Administrator Panel';
			$this->load->view('Backend/forgot_password/change_password',$this->data);
		
		}else{		
			$this->Forgot_password_admin_mdl->recover_password($md5_id);
 			redirect(base_url()."admin");
		} 
	}
	 
	public function profile(){ 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		
		$this->form_validation->set_rules('user_name','Username','required'); 
		
		if ($this->form_validation->run() == FALSE){			
			$this->data['title']='Administrator Panel';
			$this->data['active_class']='';
			$this->data['page_title']='Profile';
			
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/profile/edit_profile',$this->data);
			$this->load->view('Backend/includes/footer');		
		}else{			
			$this->Login_mdl->update_profile();
			redirect(base_url()."admin/profile");
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
		
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
			
		$this->data['title']='Settings | Administrator Panel';
		$this->data['active_class']='system_setting';
		$this->data['page_title']='Email Templates';
		$this->data['email_templates_details']=$this->Settings_mdl->email_templates_list();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/settings/email_templates/viewall',$this->data);
		$this->load->view('Backend/includes/footer');
   		 
	 }
	 
	  public function email_templates_message(){
		$this->data['email_templates_details'] = $this->Settings_mdl->email_templates_full_details($_GET['id']);
 		$this->load->view('Backend/settings/email_templates/view_message',$this->data);
	}
	
	 public function edit_email_templates(){		 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
	
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
			
			if(isset($_GET['id']) && $_GET['id']==''){
				
				$this->session->set_flashdata('error', 'Sorry, please select record!');
				redirect(base_url()."admin/setting/email_templates/manage");
				
			}else{
				
				if(isset($_POST['cmdSubmit']) && $_POST['cmdSubmit']=='Save'){
					
					$this->Settings_mdl->edit_email_templates($_GET['id']);
					redirect(base_url()."admin/setting/email_templates/manage");
				}
				
				$this->data['title']='Settings | Administrator Panel';
				$this->data['active_class']='system_setting';
				$this->data['page_title']='Email Templates :: Edit';
				$this->data['email_templates_details']=$this->Settings_mdl->email_templates_full_details($_GET['id']);
				
				$this->load->view('Backend/includes/header',$this->data);
				$this->load->view('Backend/settings/email_templates/edit',$this->data);
				$this->load->view('Backend/includes/footer');	 
			} 		 
	 }
	 
	 
	 public function manage_configuration(){		 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;		
		
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
			
			
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
			redirect(base_url()."admin/setting/configuration/manage");
		}
		 
 		 
	 }
	 
	 public function track_readiness_read_mores(){		 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;		
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');		
		$this->data['title']='Settings | Administrator Panel';
		$this->data['active_class']='system_setting';
		$this->data['page_title']='System Setting : : Track Readiness : : Read Mores';
		$this->data['track_readiness_read_mores_data']=$this->Settings_mdl->track_readiness_read_mores_data();		
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/settings/read_mores/list',$this->data);
		$this->load->view('Backend/includes/footer'); 		 
	 }
	 
	 public function track_readiness_read_mores_edit(){		 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;		
		
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
 		$id = $this->uri->segment(5);
			
		$this->form_validation->set_rules('txt_title','Title','required');
		
		if ($this->form_validation->run() == FALSE){		
			$this->data['title']='Settings | Administrator Panel';
			$this->data['active_class']='system_setting';
			$this->data['page_title']='System Setting : : Track Readiness : : Read Mores : : Edit';
			$this->data['track_readiness_read_mores_details']=$this->Settings_mdl->track_readiness_read_mores_details($id);
			//print_r($this->data['track_readiness_read_mores_details']);die;
			
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/settings/read_mores/edit',$this->data);
			$this->load->view('Backend/includes/footer');		
		}else{		
			$this->Settings_mdl->update_track_readiness_read_mores($id);
			redirect(base_url()."admin/setting/track-readiness/read-mores");
		}
		 
 		 
	 }
	 
	   
}