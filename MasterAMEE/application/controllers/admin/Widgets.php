<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Widgets extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct(); 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Widgets | Administrator Panel';
		$this->data['active_class']='widgets_menu';   
		 
 	}
	
	public function index(){
		$this->data['page_title']='Widgets';
		$this->data['widgets_list'] = $this->Widgets_mdl->widgets_list(); 
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/widgets/list',$this->data);
		$this->load->view('Backend/includes/footer');	
	}
	
	
	public function widgets_data_save(){
		$this->Widgets_mdl->widgets_data_save();
		$this->session->set_flashdata('success', 'Widget updated successfully!'); 
		redirect('admin/widgets');
	}
	
	
	public function listing(){
		$this->data['page_title']='Widgets : : Listing';
		$this->data['widgets_list'] = $this->Widgets_mdl->widgets_list(); 
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/widgets/listing',$this->data);
		$this->load->view('Backend/includes/footer');	
	}
	
	
	public function add(){	
		$this->form_validation->set_rules('txt_title','Title','required'); 
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Widgets : : Add';
			$this->data['field_type_list'] = $this->Widgets_mdl->field_type_list(); 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/widgets/add',$this->data);
			$this->load->view('Backend/includes/footer');	
		}else{
			$this->Widgets_mdl->widget_add();
			redirect('admin/widgets/listing');
		}
	}	
	
	
	
	
	
	public function addmeta(){
		if(isset($_GET['wid'])&& $_GET['wid']==''){ 
			redirect('admin/widgets/listing');
		}
		$this->form_validation->set_rules('fild_type','Fild Type','required'); 
		$this->form_validation->set_rules('meta_label','Meta Label','required'); 
		$this->form_validation->set_rules('meta_key','Meta key','required'); 
		$this->form_validation->set_rules('is_required','Is Required','required'); 
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Widgets : : Add';
			$this->data['field_type_list'] = $this->Widgets_mdl->field_type_list(); 			
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/widgets/addmeta',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Widgets_mdl->addmeta($_GET['wid']);
		}
	}
	
	
	
	
}