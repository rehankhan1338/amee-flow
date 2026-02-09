<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_metrics extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id'));
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Metrics | Administrator Panel';
		$this->data['active_class']='dept_metrics_menu';
		$this->data['departments_details']=$this->Departments_mdl->departments_details();   
 	}
	
	public function index(){		
		$this->data['page_title']='Metrics';
		//$this->data['unit_reviews_listing']=$this->Unit_reviews_mdl->get_all_unit_reviews_listing();
		//$this->data['unit_core_functions_listing']=$this->Unit_reviews_mdl->get_all_core_functions_listing();
		//$this->data['core_functions_loop']=$this->Unit_reviews_mdl->get_core_functions_loop();
		
		//$this->data['all_strategic_priorities_count']=$this->Unit_reviews_mdl->get_all_strategic_priorities_count();
		//$this->data['all_direct_indirect_measures_count']=$this->Unit_reviews_mdl->get_all_direct_indirect_measures_count();
		
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/dept_metrics/view',$this->data);
		$this->load->view('Backend/includes/footer');
	}		
	
	
	public function department_reports(){	
		$this->data['active_class']='dept_reports_menu';
		$this->data['page_title']="Analysis Reporting";	
		$action_status = '2';
		//$this->data['department_reports_detail'] = $this->Departments_mdl->department_reports_fulldetail($action_status);	
		$this->data['submitted_analysis_reports'] = $this->Departments_mdl->get_submitted_analysis_reports_of_dept();
		//echo '<pre>'; print_r($this->data['submitted_analysis_reports']);die;			
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/dept_metrics/dept_submitted_reports',$this->data);
		//$this->load->view('Backend/dept_metrics/upload_document',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function department_reports_view(){
		$encryptReportId = $this->uri->segment(5);
		$this->data['active_class']='dept_reports_menu';
		$this->data['deptReportDetails'] = $this->Analyze_mdl->reportDetails($encryptReportId);
		$this->data['page_title']=$this->data['deptReportDetails']->reportTitle.' - '.$this->data['deptReportDetails']->reportYear.' Analysis Reporting';
		$this->data['optionsMasterArr'] = $this->Analyze_mdl->optionsMasterFromWebDB();
		$this->data['myDeptReportingData'] = $this->Analyze_mdl->myDeptReportingData($this->data['deptReportDetails']->department_id,$this->data['deptReportDetails']->reportId);
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/dept_metrics/dept_submitted_report_view',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
}