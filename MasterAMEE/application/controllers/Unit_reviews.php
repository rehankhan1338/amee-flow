<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_reviews extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='create_menu';
		$this->data['title']='Create'; 
		$this->data['activity_name']='Unit Reviews';
 	}
	
	public function index(){
			
		$this->data['page_title']='Create Step5 : Measurement Tools'; 
		$this->data['action_menu']='2'; 
		$this->data['unit_analysis_listing'] = $this->Unit_reviews_mdl->get_unit_analysis_listing($this->session->userdata('dept_id'));
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/unit_reviews/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}	
	 
	public function manage(){
			
		$this->data['page_title']='Create Step5 : Measurement Tools'; 
		$this->data['action_menu']='2'; 
		if(isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
			
			$this->data['unit_details'] = $this->Unit_reviews_mdl->get_unit_fulldetails($_GET['unit_id'],$_GET['dept_id']);
			$this->data['unit_core_functions_details'] = $this->Unit_reviews_mdl->get_unit_core_functions_details($_GET['unit_id'],$_GET['dept_id']);
		
		}
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/unit_reviews/manage',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}	
	
	public function manage_unit_details(){
		
		if(isset($_GET['unit_id']) && $_GET['unit_id']!=''){
			$unit_id=$_GET['unit_id'];
		}else{
			$unit_id=0;
		}
		$dept_id = $this->session->userdata('dept_id');
		$this->Unit_reviews_mdl->manage_unit_details($dept_id,$unit_id);
	}
	
	public function mission_statement_modifications(){
		$dept_id = $this->session->userdata('dept_id');
		$unit_id=$_GET['unit_id'];
		$this->Unit_reviews_mdl->mission_statement_modifications($dept_id,$unit_id);
	}
	
	public function core_functions(){
		$dept_id = $this->session->userdata('dept_id');
		$unit_id=$_GET['unit_id'];
		$this->Unit_reviews_mdl->core_functions($dept_id,$unit_id);
	}
	
	public function evaluation_assessment(){
		$dept_id = $this->session->userdata('dept_id');
		$unit_id=$_GET['unit_id'];
		$this->Unit_reviews_mdl->evaluation_assessment($dept_id,$unit_id);
	}
	
	public function discuss_of_evaluation_result(){
		$dept_id = $this->session->userdata('dept_id');
		$unit_id=$_GET['unit_id'];
		$this->Unit_reviews_mdl->discuss_of_evaluation_result($dept_id,$unit_id);
	}
	
	public function management_of_finance_hr(){
		$dept_id = $this->session->userdata('dept_id');
		$unit_id=$_GET['unit_id'];
		$this->Unit_reviews_mdl->management_of_finance_hr($dept_id,$unit_id);
	}
	
	public function delete_core_function(){
		$dept_id = $this->session->userdata('dept_id');
		$unit_id=$_GET['unit_id'];
		$core_function_id=$_GET['id'];
		$this->Unit_reviews_mdl->delete_core_function($core_function_id);
		redirect(base_url().'department/create/unit_reviews/manage?tab=3&unit_id='.$unit_id.'&dept_id='.$dept_id);
	}	
	
	
	public function archive_delete_unit_review(){
		$this->Unit_reviews_mdl->archive_delete_unit_review();
		redirect(base_url().'department/create/unit_reviews');
	}
	
}