<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suites extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='suites_menu';
		$this->data['activity_name']='Suites';
 	}
 	
 	
 	public function index(){ 			
		$this->data['title']='Suites'; 
		$this->data['page_title']='Suites'; 
		$this->data['page_sub_title']='These are additional suites that Can be activated in the AMEE	Solution. You can read about each Suite below.	'; 
		$this->data['suites_details'] = $this->Suites_mdl->suites_details(); 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/suites/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	} 	 	
	
	public function doc_view(){ 			
		$this->data['title']='Suites'; 
		$this->data['page_title']='Suites'; 
		$this->data['page_sub_title']='These are additional suites that Can be activated in the AMEE	Solution. You can read about each Suite below.	'; 
		$this->data['suites_details'] = $this->Suites_mdl->suites_details(); 
		//$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/suites/doc_view',$this->data);
		//$this->load->view('Frontend/includes/footer',$this->data); 			
	} 
 	
 	
 	public function suites_detail_row_ajax(){
 		if(isset($_GET['id'])&& $_GET['id']!='' && isset($_GET['uniid'])&& $_GET['uniid']!=''){
			$dept_id = $this->session->userdata('dept_id');
			$this->ajax_data['university_id'] = $_GET['uniid'];		
			$this->ajax_data['suites_detail_row'] = $this->Suites_mdl->suites_detail_row($_GET['id']); 
			$this->ajax_data['precising_details'] = $this->Suites_mdl->suites_precising_details($_GET['id']); 
			$this->ajax_data['suites_user_detail_row'] = $this->Suites_mdl->suites_user_detail_row($_GET['id'],$_GET['uniid'],$dept_id); 			
			return $this->load->view('Frontend/suites/suites_model_ajax',$this->ajax_data);		
		}			
	} 	
	
	
	public function add_user(){ 	
		$dept_id = $this->session->userdata('dept_id');
		$this->Suites_mdl->add_user($dept_id); 	
		redirect(base_url().'department/suites');			
	}

	
}