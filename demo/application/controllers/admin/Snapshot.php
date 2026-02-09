<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Snapshot extends CI_Controller {
 	 
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
		$this->data['active_class']='snapshot_menu';   
 	}
	
	public function index(){		
		$this->data['page_title']='Snapshot of Programs';
		$this->data['departments_details']=$this->Departments_mdl->departments_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/snapshot/list',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function display(){
	
		$last = $this->uri->total_segments();
		$department_id = $this->uri->segment($last);
		$this->data['department_id']=$department_id;
 		$this->data['departments_details'] = $this->Departments_mdl->departments_detail_row($department_id);
		$dept_type=$this->data['departments_details']->department_type;
 		$department_type_result = get_master_department_type_by_id($dept_type);
		$department_type = $department_type_result->txt_type;
 		$this->data['page_title']='Snapshot : : '.$this->data['departments_details']->department_name.' ('.$department_type.')';
		$this->data['checklist_detail'] = $this->Departments_mdl->get_department_checklist_detail($department_id);
		$this->data['department_feedback'] = $this->Departments_mdl->get_feedback_listing($department_id);
 		$this->load->view('Backend/includes/header',$this->data);
		
		if(isset($dept_type) && $dept_type==2){
		
			$this->data['unit_details'] = $this->Unit_reviews_mdl->get_admin_unit_details($department_id);
			$unit_id=$this->data['unit_details']->id;
			$this->data['unit_core_functions_details'] = $this->Unit_reviews_mdl->get_unit_core_functions_details($unit_id,$department_id);
			$this->load->view('Backend/snapshot/non_academic_view',$this->data);
		
		}else{
		
			$this->data['department_pslos_undergraduate'] = $this->Departments_mdl->department_pslos_undergraduate($department_id);
			$this->data['department_pslos_graduate'] = $this->Departments_mdl->department_pslos_graduate($department_id);
			$this->data['department_courses_result_undergraduate'] = $this->Departments_mdl->department_courses_result_undergraduate($department_id);
			$this->data['department_courses_result_graduate'] = $this->Departments_mdl->department_courses_result_graduate($department_id);
			$this->load->view('Backend/snapshot/viewall',$this->data);
		
		}		
		
		$this->load->view('Backend/includes/footer');
 	}
	
	public function feedback_save(){
		$this->Departments_mdl->feedback_save();
	}
	
}