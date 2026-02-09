<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suites extends CI_Controller {
 	 
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
		$this->data['active_class']='suites_menu'; 
 	}
 	
 	
 	public function index(){		
		$this->data['title']='Suites'; 
		$this->data['page_title']='Suites'; 
		$this->data['page_sub_title']='These are additional suites that Can be activated in the AMEE	Solution. You can read about each Suite below.	'; 
		$this->data['suites_details'] = $this->Suites_mdl->suites_details(); 
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/suites/view',$this->data);
		$this->load->view('Backend/includes/footer',$this->data); 			
	} 	 	
		
 	
 	public function suites_detail_row_ajax(){
 		if(isset($_GET['id'])&& $_GET['id']!='' && isset($_GET['uniid'])&& $_GET['uniid']!=''){
			$dept_id = '0';		
			$this->ajax_data['university_id'] = $_GET['uniid'];		
			$this->ajax_data['suites_detail_row'] = $this->Suites_mdl->suites_detail_row($_GET['id']); 
			$this->ajax_data['precising_details'] = $this->Suites_mdl->suites_precising_details($_GET['id']); 
			$this->ajax_data['suites_user_detail_row'] = $this->Suites_mdl->suites_user_detail_row($_GET['id'],$_GET['uniid'],$dept_id); 			
			return $this->load->view('Backend/suites/suites_model_ajax',$this->ajax_data);		
		}			
	} 	
	
	
	public function add_user(){ 
		$dept_id = '0';	
		$this->Suites_mdl->add_user($dept_id); 
		redirect('admin/suites');				
	}
	
	
}