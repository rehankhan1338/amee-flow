<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct(); 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Testimonial | Administrator Panel';
		$this->data['active_class']='testimonial_menu';   
		 
 	}
	
	public function index(){	
		$this->data['page_title']='Testimonials';
		$this->data['testimonial_details']=$this->Testimonial_mdl->testimonial_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/testimonial/list',$this->data);
		$this->load->view('Backend/includes/footer');	
	}


	public function add(){
		$this->form_validation->set_rules('name','Name','required');		 
		$this->form_validation->set_rules('designation','Designation','required');		 
		$this->form_validation->set_rules('is_status','Status','required');	 	 
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Testimonials : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/testimonial/add',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Testimonial_mdl->add_testimonial();
		}
	}
	
	public function edit(){
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
	
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('designation','Designation','required');		  
		$this->form_validation->set_rules('is_status','Status','required');		
			 
		if($this->form_validation->run() == FALSE){
			$this->data['page_title']='Testimonials : : Edit';
			$this->data['testimonial_details'] = $this->Testimonial_mdl->testimonial_fulldetails($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/testimonial/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Testimonial_mdl->edit_testimonial($id);
		}	
 	}
	
	public function delete(){	
		$this->Testimonial_mdl->delete_testimonial($_GET['id']);
		redirect('admin/testimonial');
	}
	
} 