<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subadmins extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct(); 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');   
		 
 	}
	
	public function index(){
		
		$this->data['title']='Sub Admins | Administrator Panel';
		$this->data['active_class']='system_setting';
		$this->data['page_title']='Sub Admins';
		$this->data['guest_details']=$this->Login_mdl->sub_admins_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/settings/sub_admins/list',$this->data);
		$this->load->view('Backend/includes/footer');
			
	}
	
	public function edit(){
		
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('superadmin_name','Name','required');
		$this->form_validation->set_rules('guest_user_name','User Name','required'); 	 
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['title']='Sub Admins | Administrator Panel';
			$this->data['active_class']='system_setting';
			$this->data['page_title']='Sub Admins : : Edit';
			$this->data['guest_details'] = $this->Login_mdl->adminlogin_details($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/settings/sub_admins/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Login_mdl->edit_sub_admins($id);
			redirect('admin/subadmins');
		}
			
 	}
	
	public function delete(){
		
		$this->Login_mdl->delete_sub_admins($_GET['id']);
		redirect('admin/subadmins');
	}
	
	public function add(){
		
		$this->form_validation->set_rules('superadmin_name','Name','required');
		$this->form_validation->set_rules('guest_user_name','User Name','required');
		$this->form_validation->set_rules('guest_password','Password','required');		 
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['title']='Sub Admins | Administrator Panel';
			$this->data['active_class']='system_setting';
			$this->data['page_title']='Sub Admins : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/settings/sub_admins/add',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Login_mdl->add_sub_admins();
			redirect('admin/subadmins');
		}
			
	}
} 