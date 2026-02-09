<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutorials extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();	 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id'));
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Departments | Administrator Panel';
		$this->data['active_class']='tutorials_menu'; 
 	}
 	
 	
 	public function index(){		
		$this->data['title']='Tutorials'; 
		$this->data['page_title']=''; 
		$this->data['page_sub_title']=''; 
		$action_status = '2'; //I=Departyment ,2=Admin
		$this->data['tutorials_heading_details'] = $this->Tutorials_mdl->tutorials_heading_details($action_status);	
		$this->load->view('Backend/tutorials/view',$this->data);			
	} 	 
}