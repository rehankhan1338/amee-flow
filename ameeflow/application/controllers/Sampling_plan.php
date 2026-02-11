<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sampling_plan extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		// echo '<pre>';print_r($_SESSION);die;
		$this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));	
		// echo '<pre>';print_r($this->data['sessionDetailsArr']);die;	
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
		$this->data['title']='Sampling Plan'; 
		$this->data['active_class']='reports-menu';
		// $this->load->model('Backend/Accounts_mdl');
		$this->load->model('Master_alignment_map_mdl');	  
		$this->load->model('Course_enrollment_mdl');
		$this->load->model('Notifications_mdl');
		$this->data['shareReportFor']='1';
 	}
	public function index(){
		$userId = $this->data['sessionDetailsArr']['userId'];
		$this->data['userSamplingPlanDataArr'] = $this->Course_enrollment_mdl->userSamplingPlanDataArr($userId);
		$this->data['pageTitle'] = 'Sampling Plans';
        $this->data['pageSubTitle'] = ''; 
		$this->load->view('Frontend/includes/header',$this->data);		 
		$this->load->view('Frontend/reports/sampling_plan/listing',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data);
	}
	public function report(){
		$speId = $this->uri->segment(3);
		if(isset($speId) && $speId!=''){
			$this->data['pageTitle'] = 'Sampling Plan Report';
			$universityId = $this->data['sessionDetailsArr']['universityId'];
			$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
			$userId = $this->data['sessionDetailsArr']['userId'];
			$this->data['spDetails'] = $this->Course_enrollment_mdl->sampling_plans_details($speId);
			$spId = $this->data['spDetails']['spId'];
			$userAccessId = $this->data['spDetails']['userAccessId'];
			$this->data['spUserAccessDetails'] = array();
			if(isset($userAccessId) && $userAccessId!='' && $userAccessId>0){
				$this->data['spUserAccessDetails'] = $this->Course_enrollment_mdl->spUserAccessDetails($userAccessId); 			
			}
			$this->data['samplingPlanCoursesDataArr'] = $this->Course_enrollment_mdl->samplingPlanCoursesDataArr($userId,$spId); 			
			$this->data['chkId'] = $spId;
			$this->data['chkenId'] = $this->data['spDetails']['speId'];

			// echo '<pre>';print_r($this->data['samplingPlanCoursesDataArr']);die;
			$this->load->view('Frontend/includes/header',$this->data);		 
			$this->load->view('Frontend/reports/sampling_plan/report',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data);
		}else{
			redirect(base_url().'sampling_plan');
		}
	}

	public function ajxgenspAIReport(){
		echo $this->Course_enrollment_mdl->ajaxgenspAIReport();
	}
	public function savespAIreport(){
		echo $this->Course_enrollment_mdl->savespAIreport();
	}
    public function build(){
		$universityId = $this->data['sessionDetailsArr']['universityId'];
		$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
		$this->data['oversightDataArr'] = $this->Course_enrollment_mdl->oversightDataArr($universityId,$uniAdminId); 
		$this->data['pageTitle'] = 'Build Sampling Plan';
        $this->data['pageSubTitle'] = ''; 
		$this->load->view('Frontend/includes/header',$this->data);		 
		$this->load->view('Frontend/reports/sampling_plan/build',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data);
	}
	public function moveStepTwo(){
		$userId = $this->data['sessionDetailsArr']['userId'];
		$userAccessId = $this->data['sessionDetailsArr']['userAccessId'];
		$universityId = $this->data['sessionDetailsArr']['universityId'];
		$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
		echo $this->Course_enrollment_mdl->moveStepTwo($userId,$universityId,$uniAdminId,$userAccessId); 
	}
	public function outcomes(){
		$speId = $this->uri->segment(3);
		if(isset($speId) && $speId!=''){
			$this->data['pageTitle'] = 'Step 2: Identify the Outcomes Being Assessed';
			$universityId = $this->data['sessionDetailsArr']['universityId'];
			$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
			$this->data['mamDetails'] = $this->Master_alignment_map_mdl->chkAlignmentMapSts($universityId,$uniAdminId);
			$this->data['spDetails'] = $this->Course_enrollment_mdl->sampling_plans_details($speId);
			$this->load->view('Frontend/includes/header',$this->data);		 
			$this->load->view('Frontend/reports/sampling_plan/outcomes',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data);
		}else{
			redirect(base_url().'sampling_plan/build');
		}
	}
	public function moveStepThree(){
		$userId = $this->data['sessionDetailsArr']['userId'];
		echo $this->Course_enrollment_mdl->moveStepThree($userId); 
	}
	public function participants(){
		$speId = $this->uri->segment(3);
		if(isset($speId) && $speId!=''){
			$this->data['pageTitle'] = 'Step 3: Select Courses';
			$this->data['pageSubTitle'] = '';
			$userId = $this->data['sessionDetailsArr']['userId'];
			$universityId = $this->data['sessionDetailsArr']['universityId'];
			$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
			//   echo '<pre>';print_r($this->data['sessionDetailsArr']);die;
			$this->data['spDetails'] = $this->Course_enrollment_mdl->sampling_plans_details($speId);
			$spId = $this->data['spDetails']['spId'];
			$termId = $this->data['spDetails']['termId'];
			$year = $this->data['spDetails']['year'];
			$oversigntId = $this->data['spDetails']['oversigntId'];
			$alignISLO = $this->data['spDetails']['alignISLO'];
			$alignGISLO = $this->data['spDetails']['alignGISLO'];
			$alignPSLO = $this->data['spDetails']['alignPSLO'];
			$alignGPSLO = $this->data['spDetails']['alignGPSLO'];
			
			$this->data['ceDetails'] = $this->Course_enrollment_mdl->ceDetailsByTermArr($universityId,$uniAdminId,$termId,$year);
			if(isset($this->data['ceDetails']['ceId']) && $this->data['ceDetails']['ceId']!=''){
			
				$ceId = $this->data['ceDetails']['ceId'];
				$this->data['ceId'] = $ceId;
				$this->data['getCourseTakenStsDataArr'] = $this->Course_enrollment_mdl->getCourseTakenStsDataArr($userId,$spId); 
				
				$this->data['courseISLOClassDataArr'] = $this->Course_enrollment_mdl->getCourseEnrollmentClassDataArr($ceId,$alignISLO,'courseISLO',$oversigntId); 
				$this->data['courseGISLOClassDataArr'] = $this->Course_enrollment_mdl->getCourseEnrollmentClassDataArr($ceId,$alignGISLO,'courseGISLO',$oversigntId); 
				$this->data['coursePSLOClassDataArr'] = $this->Course_enrollment_mdl->getCourseEnrollmentClassDataArr($ceId,$alignPSLO,'coursePSLO',$oversigntId); 
				$this->data['courseGPSLOClassDataArr'] = $this->Course_enrollment_mdl->getCourseEnrollmentClassDataArr($ceId,$alignGPSLO,'courseGPSLO',$oversigntId); 

				$this->data['selectedCourseForIsoDetails'] = $this->Course_enrollment_mdl->getSelectedCourseForIso($spId,$userId,$ceId);
				
				$this->load->view('Frontend/includes/header',$this->data);		 
				$this->load->view('Frontend/reports/sampling_plan/create',$this->data);
				$this->load->view('Frontend/includes/footer',$this->data);
			}else{
				// no course enrollment present
			}
		}else{
			redirect(base_url().'sampling_plan/build');
		}
	}
	public function ajaxCCEFields(){
        if(isset($_GET['ceClassId']) && $_GET['ceClassId']!='' && $_GET['ceClassId']>0){
            $this->data['classDetails'] = $this->Course_enrollment_mdl->classDetailsArr($_GET['ceClassId']);
        }else{
            $this->data['classDetails'] = array();
        }
        $this->data['selceId'] = $_GET['selceId'];
		$ceId = $this->data['selceId'];
        $this->data['ceDetailsArr'] = $this->Course_enrollment_mdl->ceDetailsArr($ceId);

		$this->data['groupSubjectArr'] = $this->Course_enrollment_mdl->groupSubjectArr($ceId);
		$this->data['groupcourseModalityArr'] = $this->Course_enrollment_mdl->groupcourseModalityArr($ceId);
		$this->data['groupcourseTypeArr'] = $this->Course_enrollment_mdl->groupcourseTypeArr($ceId);
		$this->data['groupcourseLevelArr'] = $this->Course_enrollment_mdl->groupcourseLevelArr($ceId);
		$this->data['groupdeptNameArr'] = $this->Course_enrollment_mdl->groupdeptNameArr($ceId);

        $this->load->view('Frontend/reports/sampling_plan/ajax-class-fields',$this->data);
    }
	public function manageClassEntry(){
		$universityId = $this->data['sessionDetailsArr']['universityId'];
		$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
        echo $this->Course_enrollment_mdl->manageClassEntry($universityId,$uniAdminId);
    }
	public function toggle_tem_classess(){
		$userId = $this->data['sessionDetailsArr']['userId'];
		echo $this->Course_enrollment_mdl->saveTempClassess($userId);
	}
	public function ajaxNoteFields(){
		$spId = $_GET['spId'];
		$sloFor = $_GET['sloFor'];
		$ceId = $_GET['ceId'];
		$ceClassId = $_GET['ceClassId'];
		$userId = $this->data['sessionDetailsArr']['userId'];
		$this->data['getCourseNoteDetailsArr'] = $this->Course_enrollment_mdl->getCourseNoteDetailsArr($userId,$spId,$sloFor,$ceId,$ceClassId); 
		$this->load->view('Frontend/reports/sampling_plan/ajax-note-field',$this->data);
	}
	public function manageClassNotes(){
		$userId = $this->data['sessionDetailsArr']['userId'];
		echo $this->Course_enrollment_mdl->manageClassNotes($userId);
	}
	public function saveSamplingPlan(){
		if(isset($_POST['speId']) && $_POST['speId']!=''){
			$userId = $this->data['sessionDetailsArr']['userId'];
			$userAccessId = $this->data['sessionDetailsArr']['userAccessId'];
			$universityId = $this->data['sessionDetailsArr']['universityId'];
			$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
			$speId = $_POST['speId'];
			echo $this->Course_enrollment_mdl->saveSamplingPlan($userId,$universityId,$uniAdminId,$speId,$userAccessId);
		}else{
			redirect(base_url().'sampling_plan/build');
		}
	}
	public function alignment_map(){
		$universityId = $this->data['sessionDetailsArr']['universityId'];
		$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
		$this->data['mamDetailsArr'] = $this->Master_alignment_map_mdl->chkAlignmentMapSts($universityId,$uniAdminId);
		$this->data['oversightsDataArr'] = $this->Master_alignment_map_mdl->oversightsDataArr($universityId,$uniAdminId);
		if(isset($_GET['osd']) && $_GET['osd']!='' && $_GET['osd']>0){
			$oversigntId = $_GET['osd'];
		}else{
			$oversigntId = $this->data['oversightsDataArr'][0]['oversigntId'];            
		}
		$this->data['seloversigntId'] = $oversigntId;            
		$this->data['cousesDataArr'] = $this->Master_alignment_map_mdl->alignmentCousesDataArr($universityId,$uniAdminId,$oversigntId);
		$this->data['shareFrom'] = 1; // 1=user, 0=PM   
		$this->data['pageTitle'] = 'Alignment Map';
        $this->data['pageSubTitle'] = ''; 
		$this->data['sharePermission'] = 1;
		$this->load->view('Frontend/includes/header',$this->data);		 
		$this->load->view('Frontend/reports/alignment_map/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data);
	}

	public function ajaxAMnotesField(){
        if(isset($_GET['mamCourseId']) && $_GET['mamCourseId']!='' && $_GET['mamCourseId']>0){
            $this->data['courseDetails'] = $this->Master_alignment_map_mdl->courseDetailsArr($_GET['mamCourseId']);
        }else{
            $this->data['courseDetails'] = array();
        }
        // $uniAdminId = $this->data['useuniAdminId'];
        // $universityId = $this->data['sessionDetailsArr']['universityId'];
        $this->data['seloversigntId'] = $_GET['seloversigntId'];
		$this->data['mamCourseId'] = $_GET['mamCourseId'];
		$userId = $this->data['sessionDetailsArr']['userId'];
        $this->data['mamNoteDetails'] = $this->Master_alignment_map_mdl->alignmentMapNotesData($_GET['mamCourseId'],$userId);
        $this->load->view('Frontend/reports/alignment_map/ajax-notes-fields',$this->data);
    }

	public function saveNotesAM(){
		echo $this->Master_alignment_map_mdl->saveNotesAM();
	}

	public function ajaxViewFeedback(){
		if(isset($_GET['mamId']) && $_GET['mamId']!='' && $_GET['mamId']>0 && isset($_GET['userId']) && $_GET['userId']!='' && $_GET['userId']>0){
			$this->data['feedbackDataArr'] = $this->Master_alignment_map_mdl->userFeedbackDataArr($_GET['mamId'],$_GET['userId']);
		}
		$this->load->view('Frontend/reports/alignment_map/ajax-feedbacks',$this->data);
	}

	public function deleteSamplingPlan(){
		if(isset($_GET['spIds']) && $_GET['spIds']!=''){
			$this->Course_enrollment_mdl->deleteSamplingPlan($_GET['spIds']);
		} 
	}
	public function ajaxGetRoles(){
		if(isset($_GET['rtype']) && $_GET['rtype']!=''){
			$userId = $this->data['sessionDetailsArr']['userId'];
			$this->data['rtype'] = $_GET['rtype'];
			if($_GET['rtype']=='self'){
				$this->data['rolesDataArr'] = array();
			}else{
				$this->data['rolesDataArr'] = $this->Notifications_mdl->ajaxGetRolesDataArr($_GET['rtype'],$_GET['spId'],$userId);
			}			
			$this->load->view('Frontend/reports/sampling_plan/ajax-roles',$this->data);
		}
	}
	
	
}