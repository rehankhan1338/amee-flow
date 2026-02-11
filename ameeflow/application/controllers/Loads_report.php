<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Loads_report extends CI_Controller {

 	 

	function __construct(){ 

		parent::__construct();

		$this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));		

		$this->data['success_msg'] = $this->session->flashdata('success');

		$this->data['error_msg'] = $this->session->flashdata('error');

		$this->data['title']='LOADs Report'; 

		$this->data['active_class']='reports-menu';

		// $this->load->model('Backend/Accounts_mdl');

		// $this->load->model('Master_alignment_map_mdl');	  

		// $this->load->model('Course_enrollment_mdl');

		// $this->load->model('Notifications_mdl');

		$this->load->model('Loads_report_mdl');

		$this->data['shareReportFor']='2';

 	}



    public function index(){

		$this->data['pageTitle'] = 'LOADs Report';

		$universityId = $this->data['sessionDetailsArr']['universityId'];

		$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];

		$userId = $this->data['sessionDetailsArr']['userId'];

		$this->data['userLoadsReportDataArr'] = $this->Loads_report_mdl->userLoadsReportDataArr($userId);

		$this->load->view('Frontend/includes/header',$this->data);		 

		$this->load->view('Frontend/reports/loads_report/listing',$this->data);

		$this->load->view('Frontend/includes/footer',$this->data);

	}



	public function ajaxFormFields(){        

        if(isset($_GET['rId']) && $_GET['rId']!='' && $_GET['rId']>0){

            $this->data['reportDetailsArr'] = $this->Loads_report_mdl->reportDetailsArr($_GET['rId']);

        }else{

            $this->data['reportDetailsArr'] = array();

        }

        $this->load->view('Frontend/reports/loads_report/ajax-fields',$this->data);

    }



	public function genAIReport(){

		if(isset($_POST['rId']) && $_POST['rId']!='' && $_POST['rId']>0){

			echo $this->Loads_report_mdl->generateReport($_POST['rId']);

		}

	}



	public function saveReport(){

		echo $this->Loads_report_mdl->saveReport();

	}



	public function view(){

		$erId = $this->uri->segment(3);

		if(isset($erId) && $erId!=''){

			$this->data['pageTitle'] = 'LOADs Report';

			$universityId = $this->data['sessionDetailsArr']['universityId'];

			$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];

			$userId = $this->data['sessionDetailsArr']['userId'];

			$this->data['reportDetails'] = $this->Loads_report_mdl->reportDetailsByeIdArr($erId);

			$rId = $this->data['reportDetails']['rId'];

			$this->data['chkId'] = $rId;

			$this->data['chkenId'] = $erId;



			// $this->data['userLoadsReportDataArr'] = $this->Loads_report_mdl->userLoadsReportDataArr($userId);

			$this->load->view('Frontend/includes/header',$this->data);		 

			$this->load->view('Frontend/reports/loads_report/report',$this->data);

			$this->load->view('Frontend/includes/footer',$this->data);

		}else{

			redirect(base_url().'loads_report');

		}

	}



	public function saveAIreport(){

		echo $this->Loads_report_mdl->saveAIreport();

	}



	public function deleteReport(){

		if(isset($_GET['rIds']) && $_GET['rIds']!='' && $_GET['rIds']>0){

			echo $this->Loads_report_mdl->deleteReport($_GET['rIds']);

		}

	}



}