<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Category | Administrator Panel';
		$this->data['active_class']='category_menu';   
		 
 	}
	
	public function index(){		
		
		$this->data['page_title']='Category';
		$this->data['category_details']=$this->category_mdl->category_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/category/list',$this->data);
		$this->load->view('Backend/includes/footer');
			
	}
	
	public function edit(){
		
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('txt_name','Name','required');	 
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['page_title']='Category : : Edit';
			$this->data['category_details'] = $this->category_mdl->category_fulldetails($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/category/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->category_mdl->edit_category($id);
			redirect('admin/category');
		}
			
 	}
	
	public function delete(){
		
		$this->category_mdl->delete_category($_GET['id']);
		redirect('admin/category');
	}
	
	public function add(){
		
		$this->form_validation->set_rules('txt_name','Name','required');	 
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['page_title']='Category : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/category/add',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->category_mdl->add_category();
			redirect('admin/category');
		}
			
	}
} 