<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_review extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id'));
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Departments Unit Review | Administrator Panel';
		$this->data['active_class']='unit_review_menu';   
 	}
	
	public function index(){		
		$this->data['page_title']='Unit Reviews';
		$this->data['unit_reviews_listing']=$this->Unit_reviews_mdl->get_all_unit_reviews_listing();
		$this->data['unit_core_functions_listing']=$this->Unit_reviews_mdl->get_all_core_functions_listing();
		$this->data['core_functions_loop']=$this->Unit_reviews_mdl->get_core_functions_loop();
		
		$this->data['all_strategic_priorities_count']=$this->Unit_reviews_mdl->get_all_strategic_priorities_count();
		$this->data['all_direct_indirect_measures_count']=$this->Unit_reviews_mdl->get_all_direct_indirect_measures_count();
		
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/unit_review/view',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
}