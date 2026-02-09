<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Slider | Administrator Panel';
		$this->data['active_class']='cms_menu'; 
		$this->data['sub_active_class']='home_menu';    
 	}
	
	public function index(){		
		$this->data['page_title']='Slider';
		$this->data['slider_details']=$this->Sliderhome_mdl->slider_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/slider/list',$this->data);
		$this->load->view('Backend/includes/footer');	
	}
	
	
	public function edit(){
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		$this->form_validation->set_rules('txt_title','Title','required');	 
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Slider : : Edit';
			$this->data['slider_details'] = $this->Sliderhome_mdl->slider_fulldetails($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/slider/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Sliderhome_mdl->edit_slider($id);
		}	
 	}
	
	
	public function delete(){
		$this->Sliderhome_mdl->delete_slider($_GET['id']);
		redirect('admin/slider');
	}
	
	
	public function add(){
		$this->form_validation->set_rules('txt_title','Title','required'); 
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Slider : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/slider/add',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Sliderhome_mdl->add_slider();
			redirect('admin/slider');
		}
	}
	
} 