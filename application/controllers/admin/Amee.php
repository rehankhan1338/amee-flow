<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amee extends CI_Controller {  
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='amee_updates | Administrator Panel'; 
		$this->data['active_class']='amee_updates_menu';   
		 
 	}
	
	public function index(){		 
		$this->data['page_title']='Amee Updates';
		$this->data['amee_updates_details']=$this->Amee_mdl->amee_updates_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/amee_updates/list',$this->data);
		$this->load->view('Backend/includes/footer');
			
	}
	
	public function edit(){
		
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('title','Name','required');	 
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['page_title']='Amee Updates : : Edit';
			$this->data['amee_updates_details'] = $this->Amee_mdl->amee_updates_fulldetails($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/amee_updates/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Amee_mdl->edit_amee_updates($id);
			redirect('admin/amee');
		}
			
 	}
	
	public function delete(){
		
		$this->Amee_mdl->delete_amee_updates($_GET['id']);
		redirect('admin/amee');
	}
	
	public function add(){
		
		$this->form_validation->set_rules('title','Name','required');	 
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['page_title']='Amee Updates : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/amee_updates/add',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Amee_mdl->add_amee_updates();
			redirect('admin/amee');
		}
			
	}
} 