<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutorials extends CI_Controller {
 	 
	function __construct(){
		parent::__construct();
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='Tutorials_menu';
		$this->data['title']='Tutorials'; 
		$this->data['activity_name']='Tutorials';
		$activity_name = 'tutorials';
		time_tracking_management_ch($activity_name); 
 	}
	
	
	public function index(){
		$this->data['page_title']='Tutorials'; 
		$this->data['action_menu']='1'; 
		$action_status = '1'; //I=Departyment ,2=Admin
		$this->data['tutorials_heading_details'] = $this->Tutorials_mdl->tutorials_heading_details($action_status);		
		$this->load->view('Frontend/tutorials/view',$this->data);			
	}
	
 	
	
}