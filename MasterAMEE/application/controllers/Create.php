<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='create_menu';
		$this->data['title']='Create'; 
		$activity_name = 'create';
		time_tracking_management_ch($activity_name); 
 	}
	
	public function index(){
			
		$this->data['page_title']='Create Step 5 : Measurement Tools'; 
		
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	} 
	
}