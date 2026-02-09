<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id'));
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Notifications | Administrator Panel';
		$this->data['active_class']='notifications_menu';   
 	}
	
	public function index(){		
		$this->data['page_title']='Notifications';
		$this->data['departments_details']=$this->Departments_mdl->departments_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/notification/department_profiles',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function display(){	
	
		$last = $this->uri->total_segments();
		$department_id = $this->uri->segment($last);
		$this->data['department_id']=$department_id;
 		$this->data['departments_details'] = $this->Departments_mdl->departments_detail_row($department_id);
 		$this->data['page_title']='Notifications : : '.$this->data['departments_details']->department_name;
			
		$this->data['department_notification_list']=$this->Notification_mdl->get_department_notification_list($department_id,'admin');
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/notification/display',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function send(){
 		$this->Notification_mdl->send_notification_to_department();
		redirect("admin/notifications");
	}
	
}