<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller { 

	function __construct(){
		parent::__construct();
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='reports_menu';		
		$this->data['title']='Reports';  
		$this->data['activity_name']='Reports';
		$activity_name = 'reports';
		time_tracking_management_ch($activity_name); 
	}
	
	
	public function index(){
		$this->load->model('Assessment_mdl');
		$deptId = $this->session->userdata('dept_id');
		$this->data['deptAnalysisReports'] = $this->Assessment_mdl->rdAnalysisReports($deptId);
		$this->data['ClosingLoopList'] = $this->Assessment_mdl->rdClosingLoopList($deptId);
		$this->data['deptLogicModelData'] = $this->Assessment_mdl->rdLogicModelData($deptId);
 		$this->data['page_title']='Report Dashboard'; 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reports/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 	
	}


	public function preview_planning_report(){
		$department_id = $this->session->userdata('dept_id');
		$this->data['department_id']=$department_id;
		$this->data['checklist_detail'] = $this->Departments_mdl->get_department_checklist_detail($department_id);
		$this->data['department_pslos_undergraduate'] = $this->Departments_mdl->department_pslos_undergraduate($department_id);
		$this->data['department_pslos_graduate'] = $this->Departments_mdl->department_pslos_graduate($department_id);
		$this->data['department_courses_result_undergraduate'] = $this->Departments_mdl->department_courses_result_undergraduate($department_id);
		$this->data['department_courses_result_graduate'] = $this->Departments_mdl->department_courses_result_graduate($department_id);
		$this->data['rotation_plan_start_year'] = $this->Design_mdl->get_rotation_plan_year($department_id); 
		$this->data['rotation_plan_count'] = $this->config->item('rotation_year_plans');
		$this->data['team_members_detail_group_by'] = $this->Design_mdl->team_members_detail_group_by();
		$this->data['page_title']='Assessment Planning Report'; 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reports/department_checklist_detail',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 
	}
	
	public function preview_planning_report_new(){
	
		$this->load->model('Assessment_mdl');
		
		$deptId = $this->session->userdata('dept_id');
		$this->data['department_id']=$deptId;
		
		$this->data['checklist_detail'] = $this->Assessment_mdl->deptEnvisionGoalAndOutcomes($deptId);
		$this->data['deptLearningOutcomesData'] = $this->Assessment_mdl->deptLearningOutcomesData($deptId);
		
		$this->data['masterCoreCompetencyArr'] = $this->Assessment_mdl->masterCoreCompetencyArr();
		$this->data['deptAssignedCoreComtyData'] = $this->Assessment_mdl->deptAssignedCoreComtyData($deptId);
		
		$this->data['masterMatrixOptionsArr'] = $this->Assessment_mdl->masterMatrixOptionsArr();
		$this->data['deptAligementCoursesData'] = $this->Assessment_mdl->deptAligementCoursesData($deptId);
		
		$this->data['deptAligementMatrixDataArr'] = $this->Assessment_mdl->deptAligementMatrixData($deptId);
		
		// DESIGN STEP 3 : ROTATION PLAN
		$this->data['deptTeamMembersData'] = $this->Assessment_mdl->deptTeamMembersData($deptId);
		$this->data['deptRotationPlansData'] = $this->Assessment_mdl->deptRotationPlansData($deptId);			
		$this->data['deptRotationPlanCoursesData'] = array();
		if(count($this->data['deptRotationPlansData'])>0){
			$automaticIdsArr = array();
			foreach($this->data['deptRotationPlansData'] as $rpd){
				$automaticIdsArr[] = $rpd['id'];
			}
			$automaticIds = implode(',',$automaticIdsArr);
			$this->data['deptRotationPlanCoursesData'] = $this->Assessment_mdl->deptRotationPlanCoursesData($automaticIds);
		}
		
		$this->data['deptMaunalRotationPlansData'] = $this->Assessment_mdl->deptMaunalRotationPlansData($deptId);
		$this->data['deptManualRotationPlanCoursesData'] = array();
		if(count($this->data['deptMaunalRotationPlansData'])>0){
			$manualIdsArr = array();
			foreach($this->data['deptMaunalRotationPlansData'] as $rpd){
				$manualIdsArr[] = $rpd['id'];
			}
			$manualIds = implode(',',$manualIdsArr);
			$this->data['deptManualRotationPlanCoursesData'] = $this->Assessment_mdl->deptManualRotationPlanCoursesData($manualIds);
		}
		
		// REFLECT STEP 4 : ASSESSMENT PLAN
		$this->data['masterDirectAssessmentArr'] = $this->Assessment_mdl->masterDirectAssessmentArr();
		$this->data['masterIndirectAssessmentArr'] = $this->Assessment_mdl->masterIndirectAssessmentArr();
		$this->data['deptMeasurementAssessmentData'] = $this->Assessment_mdl->deptMeasurementAssessmentData($deptId);
		
		$this->data['page_title']='Assessment Planning Report'; 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reports/department_checklist_detail_new',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 
	}


	public function feedback_report(){
		$department_id = $this->session->userdata('dept_id');
		$this->data['department_id']=$department_id;
		$this->data['department_feedback'] = $this->Departments_mdl->get_feedback_listing($department_id);
		$this->data['page_title']='Administrative Feedback Report'; 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reports/feedback',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 
	}	


	public function time_tracker_report(){
		$department_id = $this->session->userdata('dept_id');
		$this->data['department_id']=$department_id;
		$this->data['time_tracker_details'] = $this->Reports_mdl->department_time_tracker_details($department_id);
		$this->data['page_title']='Time Tracker Report'; 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reports/time_tracker',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 
	}
	

	public function reset_time_tracker(){
		$department_id = $this->session->userdata('dept_id');
		$this->Reports_mdl->reset_time_tracker($department_id);
	}	

	public function save_time_tracker_ajax(){
		$department_id = $this->session->userdata('dept_id');
		if(isset($_GET['ses_tym']) && $_GET['ses_tym']!=''){
			$session_start_date_time = $_GET['ses_tym'];
			$activity_name = $_GET['activity_name'];
			$this->Reports_mdl->save_time_tracker_ajax($department_id, $session_start_date_time, $activity_name);	
		}
	}	


	public function assessment_template_report(){
		$department_id = $this->session->userdata('dept_id');
		$this->data['department_id']=$department_id;
		$this->data['page_title']='Assessment Template Report'; 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reports/assessment_report_template',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 
	}
		
	public function assessment_template_upload(){
		$action_status = '2'; // 1=Closing Loop, 2=Run Reports		
		$this->data['page_title']='Assessment Template Report';
		$this->data['department_reports_detail'] = $this->Analyze_mdl->department_reports_detail($action_status);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reports/assessment_upload_document',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}	
	
	public function upload(){	
		$department_id = $this->session->userdata('dept_id');
		$action_status = '2'; // 1=Closing Loop, 2=Run Reports
		$this->Analyze_mdl->save_upload($department_id,$action_status);
		redirect('department/reports/assessment/uplode');		
	}
	


	public function student_learning_outcome(){
		$department_id = $this->session->userdata('dept_id');
		$this->data['department_id']=$department_id;
		$this->data['department_pslos_undergraduate'] = $this->Reports_mdl->department_courses_pslos('0');
		$this->data['undergraduate_student_listing'] = $this->Reports_mdl->get_undergraduate_student_listing();
		$this->data['page_title']='UG - Student Learning Outcome Overall Performance Metrics'; 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reports/student_learning_outcome',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 
	}	
	

	public function grad_student_learning_outcome(){
		$department_id = $this->session->userdata('dept_id');
		$this->data['department_id']=$department_id;
		$this->data['department_pslos_graduate'] = $this->Reports_mdl->department_courses_pslos('1');		
		$this->data['undergraduate_student_listing'] = $this->Reports_mdl->get_undergraduate_student_listing();
		$this->data['page_title']='GRAD - Student Learning Outcome Overall Performance Metrics'; 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reports/grad_student_learning_outcome',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 
	}			

}