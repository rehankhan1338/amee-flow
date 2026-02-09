<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='notifications_menu';
		$this->data['title']='Notifications'; 
		$this->data['page_title']='Notifications';		
		$this->data['activity_name']='Notifications';
		$activity_name = 'notifications';
		time_tracking_management_ch($activity_name); 
 	} 	
 
	public function index(){
		$department_id=$this->session->userdata('dept_id');
		$university_id = $this->config->item('cv_university_id');
 		$this->data['department_notification_list']=$this->Notification_mdl->get_department_notification_list($department_id,$university_id);
		//print_r($this->data['department_notification_list']);die;
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/notifications/list',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
}