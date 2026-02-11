<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General_reports extends CI_Controller {

 	 

	function __construct(){ 

		parent::__construct();

		$this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));		

		$this->data['success_msg'] = $this->session->flashdata('success');

		$this->data['error_msg'] = $this->session->flashdata('error');

		$this->data['title']='General Reports'; 

		$this->data['active_class']='reports-menu';

		// $this->load->model('Backend/Accounts_mdl');

		// $this->load->model('Master_alignment_map_mdl');	  

		// $this->load->model('Course_enrollment_mdl');

		// $this->load->model('Notifications_mdl');

		$this->load->model('General_reports_mdl');

		$this->data['shareReportFor']='3';

 	}



    public function index(){

		$this->data['pageTitle'] = 'General Reports';

		$universityId = $this->data['sessionDetailsArr']['universityId'];

		$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];

		$userId = $this->data['sessionDetailsArr']['userId'];

		$this->data['userGeneralReportDataArr'] = $this->General_reports_mdl->userGeneralReportDataArr($userId);

		// $spId = $this->data['spDetails']['spId'];

		// $this->data['samplingPlanCoursesDataArr'] = $this->Course_enrollment_mdl->samplingPlanCoursesDataArr($userId,$spId); 

		// echo '<pre>';print_r($this->data['samplingPlanCoursesDataArr']);die;

		$this->data['guestAccessDataArr'] = array();

		$this->load->view('Frontend/includes/header',$this->data);		 

		$this->load->view('Frontend/reports/general_reports/listing',$this->data);

		$this->load->view('Frontend/includes/footer',$this->data);

	}



	public function ajaxFormFields(){        

        if(isset($_GET['rId']) && $_GET['rId']!='' && $_GET['rId']>0){

            $this->data['reportDetailsArr'] = $this->General_reports_mdl->reportDetailsArr($_GET['rId']);

        }else{

            $this->data['reportDetailsArr'] = array();

        }

        $this->load->view('Frontend/reports/general_reports/ajax-fields',$this->data);

    }



	public function genAIGeneralReport(){

		echo $this->General_reports_mdl->genAIGeneralReport();

	}



	public function saveReport(){

		echo $this->General_reports_mdl->saveReport();

	}



	public function updateAIreport(){

		echo $this->General_reports_mdl->updateAIreport();

	}



	public function view(){

		$erId = $this->uri->segment(3);

		if(isset($erId) && $erId!=''){

			$this->data['pageTitle'] = 'General Report';

			$universityId = $this->data['sessionDetailsArr']['universityId'];

			$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];

			$userId = $this->data['sessionDetailsArr']['userId'];

			$this->data['reportDetails'] = $this->General_reports_mdl->reportDetailsByeIdArr($erId);

			$rId = $this->data['reportDetails']['rId'];

			$this->data['chkId'] = $rId;

			$this->data['chkenId'] = $erId;

			$this->load->view('Frontend/includes/header',$this->data);		 

			$this->load->view('Frontend/reports/general_reports/report',$this->data);

			$this->load->view('Frontend/includes/footer',$this->data);

		}else{

			redirect(base_url().'general_reports');

		}

	}



	public function deleteReport(){

		if(isset($_GET['rIds']) && $_GET['rIds']!='' && $_GET['rIds']>0){

			echo $this->General_reports_mdl->deleteReport($_GET['rIds']);

		}

	}



}