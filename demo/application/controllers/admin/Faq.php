<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='FAQs | Administrator Panel';
		$this->data['active_class']='faqs_menu';   
		 
 	}
	
	public function index(){		
		
		$this->data['page_title']='FAQs';
		$this->data['faq_details']=$this->faq_mdl->faq_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/faq/list',$this->data);
		$this->load->view('Backend/includes/footer');
			
	}
	
	public function edit(){
		
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('question','Question','required');	 
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['page_title']='FAQ : : Edit';
			$this->data['faq_details'] = $this->faq_mdl->faq_fulldetails($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/faq/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->faq_mdl->edit_faq($id);
			redirect('admin/faq');
		}
			
 	}
	
	public function delete(){
		
		$this->faq_mdl->delete_faq($_GET['id']);
		redirect('admin/faq');
	}
	
	public function add(){
		
		$this->form_validation->set_rules('question','Name','required');	 
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['page_title']='FAQ : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/faq/add',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->faq_mdl->add_faq();
			redirect('admin/faq');
		}
			
	}
} 