<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Readiness extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='readiness_menu';
		$activity_name = 'preparedness_checklist';
		time_tracking_management_ch($activity_name); 
 	}	
	
	public function index(){				
		$this->data['title']='Readiness'; 
		$this->data['page_title']='Evaluation/Assessment Readiness Checklist'; 
		//$this->data['page_sub_title']='Click on all that are established in your program.'; 
		//$this->data['get_department_checklist'] = $this->Master_helper_mdl->get_department_checklist(); 
		$this->data['my_checklist_data'] = $this->Readiness_mdl->get_my_checklist_data();   
		$this->data['web_readness_list'] = $this->Master_helper_mdl->get_web_readness_list(); 
		$this->data['checklist_sum'] = $this->Readiness_mdl->checklist_sum(); 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/readiness/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function save_checklist_data(){
		echo $this->Readiness_mdl->save_checklist_data(); 
	}
	
	public function checklist_image(){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$data['checklist_images_row'] = $this->Readiness_mdl->department_checklist_images_row($_GET['id']);  
			$this->load->view('Frontend/readiness/checklist_image',$data);
		} 		
	}	
	
	
	public function open_popup_messages_ajax(){
		if(isset($_GET['status']) && $_GET['status']!='' && isset($_GET['val']) && $_GET['val']!=''){
			echo $data['popup_messages_row_by_purpose'] = $this->Readiness_mdl->popup_messages_row_by_purpose($_GET['status'],$_GET['val']); 
			//print_r($data['popup_messages_row_by_purpose']); 
			//return $this->load->view('Frontend/popup_modal/view',$data);
		} 		
	}
	
	
}