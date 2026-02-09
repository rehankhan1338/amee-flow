<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutorials extends CI_Controller {
 	 
	function __construct(){
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='tutorials | Administrator Panel';
		$this->data['active_class']='tutorials_menu';   
 	}
	
	
	/*public function index(){		
		$this->data['page_title']='Tutorials';
		$this->data['tutorials_details']=$this->Tutorials_mdl->tutorials_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/tutorials/view',$this->data);
		$this->load->view('Backend/includes/footer');
	}*/
	
	
	public function manage(){		
		$this->data['page_title']='Tutorials';
		$this->data['tutorials_details']=$this->Tutorials_mdl->tutorials_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/tutorials/manage',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	
	public function add(){
		$this->form_validation->set_rules('txt_title','Title','required');	 
		$this->form_validation->set_rules('txt_link','You-tube Link','required');
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Tutorials : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/tutorials/add',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Tutorials_mdl->add_tutorials();
		}
	}
	
	
	public function edit(){
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('txt_title','Title','required');	 
		$this->form_validation->set_rules('txt_link','You-tube Link','required');
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Tutorials : : Edit';
			$this->data['tutorials_detail_row'] = $this->Tutorials_mdl->tutorials_detail_row($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/tutorials/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Tutorials_mdl->edit_tutorials($id);
		}
 	}
	
	
	public function delete(){
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->Tutorials_mdl->delete_tutorials($id);
		redirect('admin/tutorials');
	}
	
	
} 