<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core_competency extends CI_Controller {
 	 
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
	
	
	public function index(){		
		$this->data['page_title']='Departments';
		$this->data['core_competency_details']=$this->Core_competency_mdl->core_competency_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/core_competency/list',$this->data);
		$this->load->view('Backend/includes/footer');
	}	
		
	public function add(){
		$this->form_validation->set_rules('name','Name','required');

		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Core Competency : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/core_competency/add',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Core_competency_mdl->add_core_competency();
		}
	}

	public function edit(){
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('name','Name','required');	 
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Core Competency : : Edit';
			$this->data['core_competency_row'] = $this->Core_competency_mdl->core_competency_row($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/core_competency/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Core_competency_mdl->edit_core_competency($id);
		}
 	}
	
	
	public function delete(){
		if(isset($_GET['id'])&& $_GET['id']==''){
			redirect('admin/core_competency');
		}
		$this->Core_competency_mdl->delete_core_competency($_GET['id']);
	}
	
	
} 