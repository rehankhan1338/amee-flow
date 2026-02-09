<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Popup_messages extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='University | Administrator Panel';
		$this->data['active_class']='popup_messages_menu';   
 	}
	
	
	public function index(){
		$this->data['page_title']='Popup Messages';
		
		if(isset($_GET['id']) && $_GET['id']!=''){
			$university_id = $_GET['id'];
		}else{
			$university_id = 0;
		}
		$this->data['popup_messages_details_group_by_page'] = $this->Popup_messages_mdl->popup_messages_details_group_by_page($university_id);
		$this->data['university_detail_custom']=$this->Popup_messages_mdl->university_detail_by_custom();
		
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/popup_messages/list',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function add(){
		$this->form_validation->set_rules('university','University Name','required');	 
		$this->form_validation->set_rules('page_name','Page Name','required');
		$this->form_validation->set_rules('purpose','Purpose','required');
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('description','Description','required'); 
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Popup Messages : : Add'; 
			$this->data['university_details']=$this->University_mdl->university_details();
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/popup_messages/add',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Popup_messages_mdl->add_Popup_messages();
		}
	}


	public function edit(){
		if(isset($_GET['id'])&& $_GET['id']!=''){
			$id = $_GET['id'];
		}
		
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('description','Description','required'); 
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Popup Messages : : Edit'; 
			$this->data['Popup_messages_detail_row'] = $this->Popup_messages_mdl->Popup_messages_detail_row($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/popup_messages/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Popup_messages_mdl->edit_Popup_messages($id);
		}		
 	}
	
	
	
	public function delete(){
		if(isset($_GET['id'])&& $_GET['id']==''){
			redirect('admin/university');
		}
		$this->University_mdl->delete_university($_GET['id']);
		redirect('admin/university');
	}
	
	
} 