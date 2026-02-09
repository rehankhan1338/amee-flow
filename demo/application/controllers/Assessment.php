<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->load->model('Assessment_mdl');
 	}
	
	public function report(){		
		$deptEncryptId = $this->uri->segment(3);
		$this->data['dept_detail'] = $this->Assessment_mdl->dept_detail($deptEncryptId);
		$this->data['title'] = 'Assessment Report of '.$this->data['dept_detail']->department_name.' - '.$this->config->item('project_name_page_first');
		$deptId = $this->data['dept_detail']->id;
		
		//echo '<pre>'; print_r($this->data['dept_detail']);die;
		
		if((isset($_GET['s1']) && $_GET['s1']!='' && $_GET['s1']==1) || (isset($_GET['s2']) && $_GET['s2']!='' && $_GET['s2']==1) || (isset($_GET['s3']) && $_GET['s3']!='' && $_GET['s3']==1) || (isset($_GET['s4']) && $_GET['s4']!='' && $_GET['s4']==1)){ // for planning report
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
			
		}		
 		//echo '<pre>'; print_r($this->data['deptAligementCoursesData']);die;
		
		if(isset($_GET['ar']) && $_GET['ar']!=''){ // for analaysis reporting
			$this->data['optionsMasterArr'] = $this->Analyze_mdl->optionsMasterFromWebDB();
			$this->data['deptAnalysisReports'] = $this->Assessment_mdl->deptAnalysisReports($deptId,$_GET['ar']);
			$this->data['deptAnalysisReportData'] = $this->Assessment_mdl->deptAnalysisReportData($deptId,$_GET['ar']);
		}else{
			$this->data['deptAnalysisReports'] = array();
			$this->data['deptAnalysisReportData'] = array();
		}
		
		if(isset($_GET['ctl']) && $_GET['ctl']!=''){ // for closing the loop
			$this->data['indicatorMasters'] = $this->Analyze_mdl->indicatorMasters();
			$this->data['ClosingLoopList'] = $this->Assessment_mdl->deptClosingLoopList($deptId, $_GET['ctl']);
			$this->data['closing_loop_data_arr'] = $this->Assessment_mdl->deptClosingLoopValueData($deptId, $_GET['ctl']);	
		}else{
			$this->data['ClosingLoopList'] = array();
			$this->data['closing_loop_data_arr'] = array();
		}
		
		if(isset($_GET['lm']) && $_GET['lm']!=''){ // for logic moodel
			$this->data['deptLogicModelData'] = $this->Assessment_mdl->deptLogicModelData($deptId, $_GET['lm']);
		}else{
			$this->data['deptLogicModelData'] = array();
		}
		
		$this->load->view('Frontend/assessment/report',$this->data);   		   			
	}
	
}