<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id')); 
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Departments | Administrator Panel';
		$this->data['active_class']='departments_menu';   
 	}
	
	
	public function sendmail(){
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
			if(isset($id) && $id==''){
				redirect('admin/departments');
			}
		$this->Departments_mdl->sendmail($id);
	}
	
	
	public function index(){		
		$this->data['page_title']='Department/Program';
		$this->data['departments_details']=$this->Departments_mdl->departments_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/departments/list',$this->data);
		$this->load->view('Backend/includes/footer');
	}	
		
	public function add(){
		$this->data['pre_department_name'] = $this->session->flashdata('department_name');
		$this->data['pre_department_type'] = $this->session->flashdata('department_type');
		$this->data['pre_user_name'] = $this->session->flashdata('user_name');
		$this->data['pre_first_name'] = $this->session->flashdata('first_name');
		$this->data['pre_last_name'] = $this->session->flashdata('last_name');
		$this->data['pre_email'] = $this->session->flashdata('email');

		$this->form_validation->set_rules('department_name','Departments Name','required');
		$this->form_validation->set_rules('department_type','Departments Type','required');		 
		$this->form_validation->set_rules('first_name','First Name','required');	 
		$this->form_validation->set_rules('last_name','Last Name','required');	 
		$this->form_validation->set_rules('email','Email','required');	 
		$this->form_validation->set_rules('user_name','User Name','required'); 
		$this->form_validation->set_rules('new_password','New Password','required'); 
		$this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[new_password]'); 
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Department/Program : : Add'; 
			$this->data['master_departments_type_detail'] = $this->Master_helper_mdl->master_departments_type_detail();
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/departments/add',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Departments_mdl->add_departments();
		}
	}
	

	public function edit(){
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('department_name','Departments Name','required');	 
		$this->form_validation->set_rules('department_type','Departments Type','required');	 
		$this->form_validation->set_rules('first_name','First Name','required');	 
		$this->form_validation->set_rules('last_name','Last Name','required');	 
		$this->form_validation->set_rules('email','Email','required');	 
		$this->form_validation->set_rules('user_name','User Name','required'); 
		$this->form_validation->set_rules('status','Status','required'); 

		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Department/Program : : Edit';
			$this->data['master_departments_type_detail'] = $this->Master_helper_mdl->master_departments_type_detail();
			$this->data['departments_details'] = $this->Departments_mdl->departments_detail_row($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/departments/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Departments_mdl->edit_departments($id);
		}
 	}
	
	
	public function delete(){
		
		if(isset($_GET['id'])&& $_GET['id']==''){
		$this->Departments_mdl->delete_departments($_GET['id']);
		}
		redirect('admin/departments');
	}
	
	
} 